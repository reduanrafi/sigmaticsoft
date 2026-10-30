<?php

namespace App\Services\TrendIntelligence;

use App\Models\TrendCategory;
use App\Models\TrendForecast;
use App\Models\TrendObservation;
use App\Models\TrendWeeklyMetric;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TrendForecastService
{
    public const METHODOLOGY_VERSION = 'v1.0-deterministic';
    public const ALLOWED_HORIZONS = [3, 6, 12];

    public function __construct(
        protected TrendAnalysisService $analysisService,
        protected UrlSafetyValidator $urlValidator
    ) {
    }

    /**
     * Generate a new draft forecast for a category and horizon (3, 6, or 12 months).
     * Always creates a new historical record rather than overwriting earlier predictions.
     */
    public function generateDraftForecast(TrendCategory $category, int $horizonMonths = 3): TrendForecast
    {
        if (!in_array($horizonMonths, self::ALLOWED_HORIZONS, true)) {
            throw new InvalidArgumentException("Invalid forecast horizon '{$horizonMonths}'. Allowed horizons: 3, 6, or 12 months.");
        }

        // Ensure weekly metrics are up to date
        $metrics = $this->analysisService->analyzeCategory($category);
        /** @var TrendWeeklyMetric $latestMetric */
        $latestMetric = $metrics->last();

        // Gather actual stored supporting observations
        $observations = TrendObservation::where('trend_category_id', $category->id)
            ->whereIn('relevance_status', ['relevant', 'marginal'])
            ->orderByDesc('is_direct_metric')
            ->orderByDesc('evidence_quality_score')
            ->orderByDesc('published_at')
            ->limit(10)
            ->get();

        $supportingEvidence = [];
        foreach ($observations as $obs) {
            if (!$this->urlValidator->isSafeCitationUrl($obs->original_url)) {
                continue;
            }
            $supportingEvidence[] = [
                'observation_id' => $obs->id,
                'title' => $obs->title,
                'source_name' => $obs->source_name,
                'url' => $obs->original_url,
                'published_at' => $obs->published_at ? $obs->published_at->toDateString() : null,
                'metric_key' => $obs->metric_key,
                'metric_value' => $obs->metric_value,
                'metric_unit' => $obs->metric_unit,
                'evidence_type' => $obs->evidence_type,
                'is_direct_metric' => (bool) $obs->is_direct_metric,
            ];
        }

        $direction = $latestMetric->direction ?? 'insufficient_evidence';
        [$confidenceLevel, $confidenceJustification] = $this->determineConfidence($latestMetric, $horizonMonths);

        $whatIsHappeningNow = $this->buildWhatIsHappeningNow($category, $latestMetric);
        $whatMayHappenNext = $this->buildWhatMayHappenNext($category, $latestMetric, $horizonMonths);
        $whyGenerated = $this->buildWhyGenerated($category, $latestMetric, $horizonMonths, count($supportingEvidence));
        $uncertainties = $this->buildUncertainties($category, $latestMetric, $horizonMonths);

        $nextSeq = TrendForecast::count() + 1;
        $forecastCode = sprintf('FC-%s-%04d-%s', now()->format('Ymd'), $nextSeq, strtoupper(Str::random(4)));

        $directionTitleMap = [
            'increasing' => 'Upward Trajectory',
            'decreasing' => 'Downward Shift',
            'stable' => 'Stable Baseline Trajectory',
            'contradictory' => 'Diverging Signal Assessment',
            'insufficient_evidence' => 'Insufficient Evidence Assessment',
        ];
        $dirPhrase = $directionTitleMap[$direction] ?? 'Trend Assessment';

        $title = "{$category->name}: {$horizonMonths}-Month {$dirPhrase} ({$latestMetric->year_week})";
        $slug = Str::slug("{$category->slug}-{$horizonMonths}m-{$latestMetric->year_week}-{$nextSeq}");

        return TrendForecast::create([
            'forecast_code' => $forecastCode,
            'trend_category_id' => $category->id,
            'horizon_months' => $horizonMonths,
            'title' => $title,
            'slug' => $slug,
            'trend_direction' => $direction,
            'internal_trend_score' => $latestMetric->trend_score,
            'confidence_level' => $confidenceLevel,
            'confidence_justification' => $confidenceJustification,
            'what_is_happening_now' => $whatIsHappeningNow,
            'what_may_happen_next' => $whatMayHappenNext,
            'why_generated' => $whyGenerated,
            'uncertainties_and_alternatives' => $uncertainties,
            'data_limitations' => $latestMetric->data_limitations,
            'supporting_evidence' => $supportingEvidence,
            'baseline_snapshot' => [
                'year_week' => $latestMetric->year_week,
                'week_start_date' => $latestMetric->week_start_date?->toDateString(),
                'recent_mean' => $latestMetric->primary_metric_mean,
                'baseline_mean' => $latestMetric->baseline_mean,
                'percent_change_vs_baseline' => $latestMetric->percent_change_vs_baseline,
                'persistence_weeks' => $latestMetric->persistence_weeks,
                'independent_source_count' => $latestMetric->independent_source_count,
                'empirical_observation_count' => $latestMetric->empirical_observation_count,
            ],
            'target_date' => now()->addMonths($horizonMonths)->toDateString(),
            'methodology_version' => self::METHODOLOGY_VERSION,
            'status' => 'draft',
            'generated_at' => now(),
        ]);
    }

    /**
     * Generate draft forecasts for all 3 horizons (3, 6, 12 months) for a category.
     *
     * @return array<int, TrendForecast>
     */
    public function generateAllHorizonsForCategory(TrendCategory $category): array
    {
        $forecasts = [];
        foreach (self::ALLOWED_HORIZONS as $horizon) {
            $forecasts[$horizon] = $this->generateDraftForecast($category, $horizon);
        }

        return $forecasts;
    }

    /**
     * Defensible deterministic confidence evaluation.
     * Never presents internal trend score as a calibrated probability.
     */
    protected function determineConfidence(TrendWeeklyMetric $metric, int $horizonMonths): array
    {
        $disclaimer = 'Internal trend scores are deterministic rule-based indices (-100 to +100) and are never presented as calibrated statistical probabilities. Forecast accuracy cannot be claimed until evaluated against subsequent outcomes after the target horizon date.';

        if ($metric->evidence_sufficiency !== 'sufficient' || $metric->direction === 'insufficient_evidence') {
            return [
                'insufficient_data',
                "Confidence is set to 'insufficient_data' because stored observations do not meet minimum empirical baseline requirements ({$metric->data_limitations}). {$disclaimer}",
            ];
        }

        if ($metric->direction === 'contradictory') {
            return [
                'low',
                "Confidence is restricted to 'low' because contradictory observations were recorded during {$metric->year_week} ({$metric->contradiction_summary}). {$disclaimer}",
            ];
        }

        if (
            $horizonMonths === 3
            && $metric->persistence_weeks >= 3
            && $metric->independent_source_count >= 2
            && $metric->contradictory_observation_count === 0
            && $metric->empirical_observation_count >= 2
        ) {
            return [
                'high',
                sprintf(
                    "Assigned 'high' qualitative confidence for the 3-month horizon based on %d consecutive weeks of directional persistence, corroboration across %d independent sources, and zero contradictory observations. %s",
                    $metric->persistence_weeks,
                    $metric->independent_source_count,
                    $disclaimer
                ),
            ];
        }

        if (
            $horizonMonths <= 6
            && $metric->persistence_weeks >= 2
            && $metric->independent_source_count >= 1
            && $metric->contradictory_observation_count <= 1
        ) {
            return [
                'moderate',
                sprintf(
                    "Assigned 'moderate' qualitative confidence for the %d-month horizon based on %d consecutive weeks of directional consistency across %d source(s). %s",
                    $horizonMonths,
                    $metric->persistence_weeks,
                    $metric->independent_source_count,
                    $disclaimer
                ),
            ];
        }

        return [
            'low',
            sprintf(
                "Assigned 'low' qualitative confidence for the %d-month horizon due to longer horizon uncertainty (%d months), %d persistence week(s), and %d independent source(s). %s",
                $horizonMonths,
                $horizonMonths,
                $metric->persistence_weeks,
                $metric->independent_source_count,
                $disclaimer
            ),
        ];
    }

    protected function buildWhatIsHappeningNow(TrendCategory $category, TrendWeeklyMetric $metric): string
    {
        if ($metric->evidence_sufficiency !== 'sufficient' || $metric->direction === 'insufficient_evidence') {
            return sprintf(
                'During %s, %s has insufficient empirical evidence to establish a verified industry-wide shift (%d direct empirical observation(s), %d indirect signal(s) recorded). %s',
                $metric->year_week,
                $category->name,
                $metric->empirical_observation_count,
                $metric->signal_only_count,
                $metric->data_limitations ?? ''
            );
        }

        $changeSign = $metric->percent_change_vs_baseline > 0 ? '+' : '';

        return sprintf(
            'In week %s, measured empirical indicators for %s averaged %s %s compared to the prior historical baseline mean of %s %s (%s%s%% relative change). This %s pattern has persisted for %d consecutive week(s) across %d independent source(s).',
            $metric->year_week,
            $category->name,
            number_format((float) $metric->primary_metric_mean, 2),
            $metric->metric_unit ?? 'units',
            number_format((float) $metric->baseline_mean, 2),
            $metric->metric_unit ?? 'units',
            $changeSign,
            number_format((float) $metric->percent_change_vs_baseline, 2),
            $metric->direction,
            $metric->persistence_weeks,
            $metric->independent_source_count
        );
    }

    protected function buildWhatMayHappenNext(TrendCategory $category, TrendWeeklyMetric $metric, int $horizonMonths): string
    {
        return match ($metric->direction) {
            'increasing' => sprintf(
                'Over the next %d months, if the observed %s%% above-baseline expansion continues without macroeconomic or budget reversal, organizations should prepare for sustained upward pressure in %s. This projection remains a conditional scenario pending post-horizon outcome evaluation.',
                $horizonMonths,
                number_format((float) $metric->percent_change_vs_baseline, 2),
                strtolower($category->name)
            ),
            'decreasing' => sprintf(
                'Over the next %d months, continuation of the observed %s%% contraction relative to historical baseline indicates reduced activity or tightening conditions in %s. Decision-makers should monitor whether subsequent weekly measurements stabilize or continue declining.',
                $horizonMonths,
                number_format((float) $metric->percent_change_vs_baseline, 2),
                strtolower($category->name)
            ),
            'stable' => sprintf(
                'Over the next %d months, %s is projected to remain near its historical baseline (%s %s), as recent weekly variations (%s%%) remain within the ±5.0%% stability band.',
                $horizonMonths,
                strtolower($category->name),
                number_format((float) $metric->baseline_mean, 2),
                $metric->metric_unit ?? 'units',
                number_format((float) $metric->percent_change_vs_baseline, 2)
            ),
            'contradictory' => sprintf(
                'Over the next %d months, the trajectory for %s remains contested due to contradictory empirical measurements across tracked sources. No single directional commitment is warranted until diverging series converge.',
                $horizonMonths,
                strtolower($category->name)
            ),
            default => sprintf(
                'No directional %d-month projection is issued for %s because current empirical baseline requirements are not met (Insufficient evidence). Additional verified quantitative datasets are required before forecasting.',
                $horizonMonths,
                strtolower($category->name)
            ),
        };
    }

    protected function buildWhyGenerated(TrendCategory $category, TrendWeeklyMetric $metric, int $horizonMonths, int $evidenceCount): string
    {
        return sprintf(
            'Generated deterministically under methodology %s for the %d-month horizon using %d stored supporting observation(s) in %s (Week %s). Rule evaluation recorded direction="%s", persistence=%d week(s), independent_sources=%d, and internal rule index=%s (note: internal index is not a statistical probability).',
            self::METHODOLOGY_VERSION,
            $horizonMonths,
            $evidenceCount,
            $category->name,
            $metric->year_week,
            $metric->direction,
            $metric->persistence_weeks,
            $metric->independent_source_count,
            $metric->trend_score !== null ? number_format($metric->trend_score, 2) : 'N/A (Insufficient evidence)'
        );
    }

    protected function buildUncertainties(TrendCategory $category, TrendWeeklyMetric $metric, int $horizonMonths): string
    {
        $parts = [
            "1. Horizon sensitivity: {$horizonMonths}-month projections are subject to enterprise budget cycles, interest-rate shifts, regulatory changes, and vendor pricing adjustments.",
            '2. Measurement scope: Publicly accessible datasets may lag private enterprise procurement or internal engineering telemetry.',
            '3. Alternative explanation: Short-term changes can reflect seasonal reporting boundaries or isolated catalog updates rather than structural industry transformation.',
        ];

        if ($metric->contradiction_summary) {
            $parts[] = '4. Contradictory evidence observed: ' . $metric->contradiction_summary;
        }

        return implode("\n", $parts);
    }
}

