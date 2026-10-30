<?php

namespace App\Services\TrendIntelligence;

use App\Models\TrendCategory;
use App\Models\TrendCollectionError;
use App\Models\TrendCollectionRun;
use App\Models\TrendObservation;
use App\Models\TrendSource;
use App\Services\TrendIntelligence\Connectors\HackerNewsAlgoliaConnector;
use App\Services\TrendIntelligence\Connectors\PublicJsonDatasetConnector;
use App\Services\TrendIntelligence\Connectors\RssAtomFeedConnector;
use App\Services\TrendIntelligence\Connectors\TrendConnectorInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;

class TrendCollectionService
{
    /** @var array<string, TrendConnectorInterface> */
    protected array $connectors = [];

    public function __construct(
        protected UrlSafetyValidator $urlValidator
    ) {
        $this->registerConnector(new HackerNewsAlgoliaConnector($this->urlValidator));
        $this->registerConnector(new PublicJsonDatasetConnector($this->urlValidator));
        $this->registerConnector(new RssAtomFeedConnector($this->urlValidator));
    }

    public function registerConnector(TrendConnectorInterface $connector): void
    {
        $this->connectors[$connector->getType()] = $connector;
    }

    public function getSupportedConnectorTypes(): array
    {
        return array_keys($this->connectors);
    }

    /**
     * Collect observations from a single configured TrendSource.
     */
    public function collectSource(
        TrendSource $source,
        string $triggeredBy = 'manual',
        ?int $userId = null,
        bool $respectInterval = false
    ): TrendCollectionRun {
        $startTime = microtime(true);

        $run = TrendCollectionRun::create([
            'trend_source_id' => $source->id,
            'triggered_by' => $triggeredBy,
            'triggered_by_user_id' => $userId,
            'status' => 'running',
            'started_at' => now(),
            'items_fetched' => 0,
            'items_stored' => 0,
            'items_skipped_duplicate' => 0,
            'items_rejected_irrelevant' => 0,
            'error_count' => 0,
        ]);

        // 1. Check fetch interval when scheduled
        if ($respectInterval && $source->last_collected_at !== null) {
            $minutesSinceLast = $source->last_collected_at->diffInMinutes(now());
            if ($minutesSinceLast < $source->fetch_interval_minutes) {
                $run->update([
                    'status' => 'completed',
                    'finished_at' => now(),
                    'duration_ms' => (int) ((microtime(true) - $startTime) * 1000),
                    'summary_notes' => "Skipped: fetch interval ({$source->fetch_interval_minutes} min) has not elapsed yet.",
                ]);

                return $run->fresh();
            }
        }

        // 2. Enforce per-source rate limit
        $rateKey = 'trend-source-collect:' . $source->id;
        $maxPerMinute = max(1, (int) $source->rate_limit_per_minute);

        if (RateLimiter::tooManyAttempts($rateKey, $maxPerMinute)) {
            $this->recordError($run, $source, 'rate_limit', 'LOCAL_RATE_LIMIT', "Source rate limit of {$maxPerMinute}/min reached.");
            $run->update([
                'status' => 'failed',
                'finished_at' => now(),
                'error_count' => 1,
                'duration_ms' => (int) ((microtime(true) - $startTime) * 1000),
                'summary_notes' => 'Aborted due to local rate limit protection.',
            ]);

            return $run->fresh();
        }
        RateLimiter::hit($rateKey, 60);

        // 3. Validate connector type
        $connector = $this->connectors[$source->connector_type] ?? null;
        if (!$connector) {
            $this->recordError($run, $source, 'validation', 'UNKNOWN_CONNECTOR', "Unsupported connector type '{$source->connector_type}'.");
            $run->update([
                'status' => 'failed',
                'finished_at' => now(),
                'error_count' => 1,
                'duration_ms' => (int) ((microtime(true) - $startTime) * 1000),
                'summary_notes' => 'Unsupported connector type.',
            ]);

            return $run->fresh();
        }

        // 4. Execute connector fetch
        $result = $connector->fetch($source);
        $httpStatus = $result['http_status'] ?? null;
        $rawItems = $result['items'] ?? [];
        $connectorErrors = $result['errors'] ?? [];

        foreach ($connectorErrors as $err) {
            $this->recordError(
                $run,
                $source,
                $err['error_type'] ?? 'general',
                $err['error_code'] ?? null,
                $err['message'] ?? 'Connector error occurred.',
                $err['context'] ?? null
            );
        }

        $categories = TrendCategory::where('is_active', true)->get()->keyBy('id');
        $categoriesBySlug = $categories->keyBy('slug');

        $stored = 0;
        $duplicates = 0;
        $irrelevant = 0;
        $errorCount = count($connectorErrors);

        foreach ($rawItems as $rawItem) {
            try {
                $title = trim((string) ($rawItem['title'] ?? ''));
                $originalUrl = trim((string) ($rawItem['original_url'] ?? ''));

                if ($title === '' || !$this->urlValidator->isSafeCitationUrl($originalUrl)) {
                    $irrelevant++;
                    continue;
                }

                $category = $this->resolveCategory($rawItem, $source, $categories, $categoriesBySlug);
                if (!$category) {
                    $irrelevant++;
                    continue;
                }

                $relevanceStatus = $this->evaluateRelevance($title, (string) ($rawItem['summary'] ?? ''), $category, $source);
                if ($relevanceStatus === 'irrelevant') {
                    $irrelevant++;
                    continue;
                }

                $publishedAt = isset($rawItem['published_at'])
                    ? Carbon::parse($rawItem['published_at'])
                    : now();

                $metricKey = isset($rawItem['metric_key']) && $rawItem['metric_key'] !== ''
                    ? (string) $rawItem['metric_key']
                    : null;

                $duplicateHash = TrendObservation::computeDuplicateHash(
                    $source->id,
                    $rawItem['external_id'] ?? null,
                    $originalUrl,
                    $metricKey,
                    $publishedAt->toDateString()
                );

                if (TrendObservation::where('duplicate_hash', $duplicateHash)->exists()) {
                    $duplicates++;
                    continue;
                }

                $evidenceType = (string) ($rawItem['evidence_type'] ?? 'article_signal');
                $isDirectMetric = (bool) ($rawItem['is_direct_metric'] ?? false);

                // Enforce Phase 3 rule: article counts, social media activity, or repository activity
                // are NEVER treated as direct proof of industry-wide change.
                if (in_array($evidenceType, TrendObservation::NON_PROOF_EVIDENCE_TYPES, true) || !$source->allows_direct_metric_proof) {
                    $isDirectMetric = false;
                }

                $metricValue = isset($rawItem['metric_value']) && is_numeric($rawItem['metric_value'])
                    ? (float) $rawItem['metric_value']
                    : null;

                $qualityScore = $this->computeQualityScore($source, $isDirectMetric, $metricValue, $relevanceStatus);
                $isContradictory = (bool) ($rawItem['is_contradictory'] ?? false);

                $qualityStatus = $isContradictory
                    ? 'flagged_contradictory'
                    : ($qualityScore >= 0.75 ? 'verified' : ($qualityScore >= 0.45 ? 'provisional' : 'low_quality'));

                TrendObservation::create([
                    'trend_source_id' => $source->id,
                    'trend_collection_run_id' => $run->id,
                    'trend_category_id' => $category->id,
                    'source_name' => $source->name,
                    'original_url' => $originalUrl,
                    'external_id' => $rawItem['external_id'] ?? null,
                    'duplicate_hash' => $duplicateHash,
                    'title' => mb_substr($title, 0, 500),
                    'summary' => isset($rawItem['summary']) ? mb_substr((string) $rawItem['summary'], 0, 500) : null,
                    'published_at' => $publishedAt,
                    'collected_at' => now(),
                    'metric_key' => $metricKey,
                    'metric_value' => $metricValue,
                    'metric_unit' => $rawItem['metric_unit'] ?? $category->primary_metric_unit,
                    'evidence_type' => $evidenceType,
                    'is_direct_metric' => $isDirectMetric,
                    'evidence_quality_score' => $qualityScore,
                    'quality_status' => $qualityStatus,
                    'relevance_status' => $relevanceStatus,
                    'is_contradictory' => $isContradictory,
                    'contradiction_notes' => $rawItem['contradiction_notes'] ?? null,
                    'raw_metadata' => $rawItem['raw_metadata'] ?? null,
                ]);

                $stored++;
            } catch (Throwable $e) {
                $errorCount++;
                $this->recordError($run, $source, 'validation', 'ITEM_STORE_ERROR', $e->getMessage());
            }
        }

        $status = 'completed';
        if ($errorCount > 0 && $stored === 0 && count($rawItems) === 0) {
            $status = 'failed';
        } elseif ($errorCount > 0) {
            $status = 'partial';
        }

        if ($status !== 'failed') {
            $source->update(['last_collected_at' => now()]);
        }

        $run->update([
            'status' => $status,
            'finished_at' => now(),
            'items_fetched' => count($rawItems),
            'items_stored' => $stored,
            'items_skipped_duplicate' => $duplicates,
            'items_rejected_irrelevant' => $irrelevant,
            'error_count' => $errorCount,
            'http_status' => $httpStatus,
            'duration_ms' => (int) ((microtime(true) - $startTime) * 1000),
            'summary_notes' => sprintf(
                'Fetched %d items: %d stored, %d duplicates skipped, %d irrelevant filtered, %d errors.',
                count($rawItems),
                $stored,
                $duplicates,
                $irrelevant,
                $errorCount
            ),
        ]);

        return $run->fresh();
    }

    /**
     * Collect all active sources.
     */
    public function collectAllActive(string $triggeredBy = 'manual', ?int $userId = null, bool $respectInterval = false): array
    {
        $sources = TrendSource::where('is_active', true)->get();
        $runs = [];

        foreach ($sources as $source) {
            $runs[] = $this->collectSource($source, $triggeredBy, $userId, $respectInterval);
        }

        return $runs;
    }

    protected function resolveCategory(array $rawItem, TrendSource $source, $categories, $categoriesBySlug): ?TrendCategory
    {
        if (!empty($rawItem['category_slug']) && isset($categoriesBySlug[$rawItem['category_slug']])) {
            return $categoriesBySlug[$rawItem['category_slug']];
        }

        $haystack = strtolower($rawItem['title'] . ' ' . ($rawItem['summary'] ?? ''));

        foreach ($categories as $category) {
            $keywords = $category->keywords ?? [];
            foreach ($keywords as $keyword) {
                if ($keyword !== '' && str_contains($haystack, strtolower($keyword))) {
                    return $category;
                }
            }
        }

        if ($source->default_category_id && isset($categories[$source->default_category_id])) {
            return $categories[$source->default_category_id];
        }

        return $categories->first();
    }

    protected function evaluateRelevance(string $title, string $summary, TrendCategory $category, TrendSource $source): string
    {
        $haystack = strtolower($title . ' ' . $summary);

        // If source is dedicated to a specific category and provides direct empirical metrics, mark relevant
        if ($source->allows_direct_metric_proof && $source->default_category_id === $category->id) {
            return 'relevant';
        }

        $keywords = $category->keywords ?? [];
        foreach ($keywords as $kw) {
            if ($kw !== '' && str_contains($haystack, strtolower($kw))) {
                return 'relevant';
            }
        }

        // Broad software industry terms check
        $softwareTerms = [
            'software', 'developer', 'engineering', 'code', 'coding', 'api', 'cloud',
            'saas', 'security', 'vulnerability', 'cve', 'ai', 'llm', 'modernization',
            'legacy', 'programming', 'devops', 'database', 'architecture', 'hiring',
        ];

        foreach ($softwareTerms as $term) {
            if (str_contains($haystack, $term)) {
                return 'marginal';
            }
        }

        return 'irrelevant';
    }

    protected function computeQualityScore(TrendSource $source, bool $isDirectMetric, ?float $metricValue, string $relevanceStatus): float
    {
        $score = (float) $source->trust_weight * 0.60;

        if ($isDirectMetric && $metricValue !== null) {
            $score += 0.25;
        } elseif ($metricValue !== null) {
            $score += 0.10;
        }

        if ($relevanceStatus === 'relevant') {
            $score += 0.15;
        } elseif ($relevanceStatus === 'marginal') {
            $score += 0.05;
        }

        return round(min(1.00, max(0.10, $score)), 2);
    }

    protected function recordError(
        TrendCollectionRun $run,
        TrendSource $source,
        string $errorType,
        ?string $errorCode,
        string $message,
        ?array $context = null
    ): TrendCollectionError {
        return TrendCollectionError::create([
            'trend_collection_run_id' => $run->id,
            'trend_source_id' => $source->id,
            'error_type' => $errorType,
            'error_code' => $errorCode,
            'message' => mb_substr($message, 0, 1000),
            'context' => $context,
            'occurred_at' => now(),
        ]);
    }
}

