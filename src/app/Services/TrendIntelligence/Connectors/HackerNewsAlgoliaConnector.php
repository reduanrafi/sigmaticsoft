<?php

namespace App\Services\TrendIntelligence\Connectors;

use App\Models\TrendSource;
use App\Services\TrendIntelligence\UrlSafetyValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Throwable;

class HackerNewsAlgoliaConnector implements TrendConnectorInterface
{
    public function __construct(
        protected UrlSafetyValidator $urlValidator
    ) {
    }

    public function getType(): string
    {
        return 'hn_algolia';
    }

    public function fetch(TrendSource $source): array
    {
        $items = [];
        $errors = [];
        $httpStatus = null;

        try {
            $safeEndpoint = $this->urlValidator->assertSafeForFetch($source->endpoint_url);
        } catch (Throwable $e) {
            return [
                'http_status' => null,
                'items' => [],
                'errors' => [[
                    'error_type' => 'ssrf_blocked',
                    'error_code' => 'UNSAFE_ENDPOINT',
                    'message' => $e->getMessage(),
                ]],
            ];
        }

        $config = $source->config ?? [];
        $queryParams = [
            'query' => $config['query'] ?? 'software engineering',
            'tags' => $config['tags'] ?? 'story',
            'hitsPerPage' => min((int) ($config['hitsPerPage'] ?? 20), 50),
        ];

        if (!empty($config['numericFilters'])) {
            $queryParams['numericFilters'] = $config['numericFilters'];
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'SigmaticSoft-TrendIntelligence/1.0 (+https://sigmaticsoft.com/software-industry-outlook)',
                'Accept' => 'application/json',
            ])
                ->timeout(15)
                ->get($safeEndpoint, $queryParams);

            $httpStatus = $response->status();

            if (in_array($httpStatus, [401, 402, 403], true)) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [[
                        'error_type' => 'auth_or_paywall',
                        'error_code' => (string) $httpStatus,
                        'message' => "Source returned HTTP {$httpStatus} (authentication/paywall/access restriction). Respecting restriction and halting.",
                    ]],
                ];
            }

            if ($httpStatus === 429) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [[
                        'error_type' => 'rate_limit',
                        'error_code' => '429',
                        'message' => 'Source rate limit reached (HTTP 429). Backing off.',
                    ]],
                ];
            }

            if (!$response->successful()) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [[
                        'error_type' => 'network',
                        'error_code' => (string) $httpStatus,
                        'message' => "Unexpected HTTP status {$httpStatus} from Hacker News Algolia endpoint.",
                    ]],
                ];
            }

            $payload = $response->json();
            if (!is_array($payload) || !isset($payload['hits']) || !is_array($payload['hits'])) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [[
                        'error_type' => 'parse',
                        'error_code' => 'INVALID_JSON_SCHEMA',
                        'message' => 'Response payload did not contain a valid hits array.',
                    ]],
                ];
            }

            foreach ($payload['hits'] as $hit) {
                if (!is_array($hit)) {
                    continue;
                }

                $objectId = isset($hit['objectID']) ? (string) $hit['objectID'] : null;
                $title = trim((string) ($hit['title'] ?? $hit['story_title'] ?? ''));
                if ($title === '' || $objectId === null) {
                    continue;
                }

                $rawUrl = trim((string) ($hit['url'] ?? ''));
                if ($rawUrl === '' || !$this->urlValidator->isSafeCitationUrl($rawUrl)) {
                    $rawUrl = "https://news.ycombinator.com/item?id={$objectId}";
                }

                $publishedAt = isset($hit['created_at'])
                    ? Carbon::parse($hit['created_at'])
                    : (isset($hit['created_at_i']) ? Carbon::createFromTimestamp((int) $hit['created_at_i']) : now());

                $points = isset($hit['points']) && is_numeric($hit['points']) ? (float) $hit['points'] : null;
                $numComments = isset($hit['num_comments']) && is_numeric($hit['num_comments']) ? (int) $hit['num_comments'] : 0;

                $summary = sprintf(
                    'Public technical discussion signal (%s points, %d comments) recorded via Hacker News Algolia index.',
                    $points !== null ? (string) (int) $points : '0',
                    $numComments
                );

                // Note: Per Phase 3 rules, discussion/article/social activity is NEVER treated as direct proof of industry-wide change.
                $items[] = [
                    'external_id' => 'hn_' . $objectId,
                    'original_url' => $rawUrl,
                    'title' => mb_substr($title, 0, 500),
                    'summary' => $summary,
                    'published_at' => $publishedAt->toIso8601String(),
                    'metric_key' => 'discussion_points',
                    'metric_value' => $points,
                    'metric_unit' => 'points',
                    'evidence_type' => 'discussion_activity',
                    'is_direct_metric' => false,
                    'raw_metadata' => [
                        'object_id' => $objectId,
                        'points' => $points,
                        'num_comments' => $numComments,
                        'author' => $hit['author'] ?? null,
                    ],
                ];
            }
        } catch (Throwable $e) {
            $errors[] = [
                'error_type' => 'network',
                'error_code' => 'EXCEPTION',
                'message' => 'Failed to fetch from Hacker News Algolia API: ' . $e->getMessage(),
            ];
        }

        return [
            'http_status' => $httpStatus,
            'items' => $items,
            'errors' => $errors,
        ];
    }
}

