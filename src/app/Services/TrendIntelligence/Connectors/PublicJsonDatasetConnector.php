<?php

namespace App\Services\TrendIntelligence\Connectors;

use App\Models\TrendSource;
use App\Services\TrendIntelligence\UrlSafetyValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Throwable;

class PublicJsonDatasetConnector implements TrendConnectorInterface
{
    public function __construct(
        protected UrlSafetyValidator $urlValidator
    ) {
    }

    public function getType(): string
    {
        return 'public_json_api';
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

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'SigmaticSoft-TrendIntelligence/1.0 (+https://sigmaticsoft.com/software-industry-outlook)',
                'Accept' => 'application/json',
            ])
                ->timeout(20)
                ->get($safeEndpoint);

            $httpStatus = $response->status();

            if (in_array($httpStatus, [401, 402, 403], true)) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [[
                        'error_type' => 'auth_or_paywall',
                        'error_code' => (string) $httpStatus,
                        'message' => "Source returned HTTP {$httpStatus} (access restricted). Halting collection.",
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
                        'message' => 'Rate limit exceeded (HTTP 429).',
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
                        'message' => "HTTP request failed with status {$httpStatus}.",
                    ]],
                ];
            }

            $payload = $response->json();
            if (!is_array($payload)) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [[
                        'error_type' => 'parse',
                        'error_code' => 'INVALID_JSON',
                        'message' => 'Endpoint did not return a valid JSON object or array.',
                    ]],
                ];
            }

            $config = $source->config ?? [];
            $mode = $config['mode'] ?? 'standard';

            if ($mode === 'cisa_kev' && isset($payload['vulnerabilities']) && is_array($payload['vulnerabilities'])) {
                $items = $this->parseCisaKev($payload['vulnerabilities'], $source, $safeEndpoint);
            } else {
                $records = $payload['observations'] ?? $payload['items'] ?? $payload['data'] ?? $payload;
                if (!is_array($records)) {
                    return [
                        'http_status' => $httpStatus,
                        'items' => [],
                        'errors' => [[
                            'error_type' => 'parse',
                            'error_code' => 'MISSING_RECORDS_ARRAY',
                            'message' => 'Could not locate observations/items/data array in JSON response.',
                        ]],
                    ];
                }

                $items = $this->parseStandardRecords($records, $source, $safeEndpoint);
            }
        } catch (Throwable $e) {
            $errors[] = [
                'error_type' => 'network',
                'error_code' => 'EXCEPTION',
                'message' => 'Public JSON dataset fetch error: ' . $e->getMessage(),
            ];
        }

        return [
            'http_status' => $httpStatus,
            'items' => $items,
            'errors' => $errors,
        ];
    }

    /**
     * Parse CISA Known Exploited Vulnerabilities catalog into weekly empirical counts.
     */
    protected function parseCisaKev(array $vulnerabilities, TrendSource $source, string $fallbackUrl): array
    {
        $byWeek = [];
        foreach ($vulnerabilities as $vuln) {
            if (!is_array($vuln) || empty($vuln['dateAdded'])) {
                continue;
            }
            try {
                $date = Carbon::parse($vuln['dateAdded']);
            } catch (Throwable $e) {
                continue;
            }
            $weekStart = $date->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
            $yearWeek = $date->format('o-\WW');
            if (!isset($byWeek[$yearWeek])) {
                $byWeek[$yearWeek] = [
                    'week_start' => $weekStart,
                    'year_week' => $yearWeek,
                    'count' => 0,
                    'vendors' => [],
                    'cves' => [],
                ];
            }
            $byWeek[$yearWeek]['count']++;
            if (!empty($vuln['vendorProject'])) {
                $byWeek[$yearWeek]['vendors'][$vuln['vendorProject']] = true;
            }
            if (!empty($vuln['cveID']) && count($byWeek[$yearWeek]['cves']) < 5) {
                $byWeek[$yearWeek]['cves'][] = $vuln['cveID'];
            }
        }

        ksort($byWeek);
        // Take the most recent 16 weeks of historical coverage
        $recentWeeks = array_slice($byWeek, -16, 16, true);
        $items = [];

        foreach ($recentWeeks as $yearWeek => $bucket) {
            $cveList = implode(', ', $bucket['cves']);
            $vendorCount = count($bucket['vendors']);
            $items[] = [
                'external_id' => 'cisa_kev_' . $yearWeek,
                'original_url' => $fallbackUrl,
                'title' => "CISA Known Exploited Vulnerabilities Added ({$yearWeek}): {$bucket['count']} Advisories",
                'summary' => "CISA recorded {$bucket['count']} newly cataloged exploited vulnerabilities across {$vendorCount} vendors during week {$yearWeek}" . ($cveList ? " (including {$cveList})." : '.'),
                'published_at' => Carbon::parse($bucket['week_start'])->endOfWeek(Carbon::SUNDAY)->toIso8601String(),
                'metric_key' => 'exploited_vulnerabilities_added',
                'metric_value' => (float) $bucket['count'],
                'metric_unit' => 'count',
                'evidence_type' => 'empirical_metric',
                'is_direct_metric' => (bool) $source->allows_direct_metric_proof,
                'raw_metadata' => [
                    'year_week' => $yearWeek,
                    'vendor_count' => $vendorCount,
                    'sample_cves' => $bucket['cves'],
                ],
            ];
        }

        return $items;
    }

    /**
     * Parse standard structured JSON observations.
     */
    protected function parseStandardRecords(array $records, TrendSource $source, string $fallbackUrl): array
    {
        $config = $source->config ?? [];
        $defaultMetricKey = $config['metric_key'] ?? 'indicator_value';
        $defaultMetricUnit = $config['metric_unit'] ?? 'index_points';
        $defaultEvidenceType = $config['evidence_type'] ?? ($source->allows_direct_metric_proof ? 'empirical_metric' : 'article_signal');

        $items = [];
        foreach ($records as $record) {
            if (!is_array($record)) {
                continue;
            }

            $title = trim((string) ($record['title'] ?? $record['name'] ?? $record['label'] ?? ''));
            if ($title === '') {
                continue;
            }

            $rawUrl = trim((string) ($record['url'] ?? $record['original_url'] ?? $fallbackUrl));
            if (!$this->urlValidator->isSafeCitationUrl($rawUrl)) {
                $rawUrl = $fallbackUrl;
            }

            $publishedRaw = $record['published_at'] ?? $record['date'] ?? $record['timestamp'] ?? null;
            try {
                $publishedAt = $publishedRaw ? Carbon::parse($publishedRaw) : now();
            } catch (Throwable $e) {
                $publishedAt = now();
            }

            $metricValue = isset($record['metric_value']) && is_numeric($record['metric_value'])
                ? (float) $record['metric_value']
                : (isset($record['value']) && is_numeric($record['value']) ? (float) $record['value'] : null);

            $evidenceType = (string) ($record['evidence_type'] ?? $defaultEvidenceType);
            $isDirectMetric = (bool) ($record['is_direct_metric'] ?? ($source->allows_direct_metric_proof && $metricValue !== null));

            $items[] = [
                'external_id' => isset($record['id']) ? (string) $record['id'] : (isset($record['external_id']) ? (string) $record['external_id'] : null),
                'original_url' => $rawUrl,
                'title' => mb_substr($title, 0, 500),
                'summary' => isset($record['summary']) ? mb_substr(trim((string) $record['summary']), 0, 500) : null,
                'published_at' => $publishedAt->toIso8601String(),
                'metric_key' => (string) ($record['metric_key'] ?? $defaultMetricKey),
                'metric_value' => $metricValue,
                'metric_unit' => (string) ($record['metric_unit'] ?? $defaultMetricUnit),
                'evidence_type' => $evidenceType,
                'is_direct_metric' => $isDirectMetric,
                'is_contradictory' => (bool) ($record['is_contradictory'] ?? false),
                'contradiction_notes' => $record['contradiction_notes'] ?? null,
                'category_slug' => $record['category_slug'] ?? null,
                'raw_metadata' => $record['metadata'] ?? null,
            ];
        }

        return $items;
    }
}

