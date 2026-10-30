<?php

namespace App\Services\TrendIntelligence\Connectors;

use App\Models\TrendSource;
use App\Services\TrendIntelligence\UrlSafetyValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Throwable;

class RssAtomFeedConnector implements TrendConnectorInterface
{
    public function __construct(
        protected UrlSafetyValidator $urlValidator
    ) {
    }

    public function getType(): string
    {
        return 'rss_feed';
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
                'errors' => [
                    [
                        'error_type' => 'ssrf_blocked',
                        'error_code' => 'UNSAFE_ENDPOINT',
                        'message' => $e->getMessage(),
                    ]
                ],
            ];
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'SigmaticSoft-TrendIntelligence/1.0 (+https://sigmaticsoft.com/software-industry-outlook)',
                'Accept' => 'application/rss+xml, application/atom+xml, application/xml, text/xml',
            ])
                ->timeout(15)
                ->get($safeEndpoint);

            $httpStatus = $response->status();

            if (in_array($httpStatus, [401, 402, 403], true)) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [
                        [
                            'error_type' => 'auth_or_paywall',
                            'error_code' => (string) $httpStatus,
                            'message' => "RSS feed returned HTTP {$httpStatus} (access restricted).",
                        ]
                    ],
                ];
            }

            if ($httpStatus === 429) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [
                        [
                            'error_type' => 'rate_limit',
                            'error_code' => '429',
                            'message' => 'RSS feed rate limit reached (HTTP 429).',
                        ]
                    ],
                ];
            }

            if (!$response->successful()) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [
                        [
                            'error_type' => 'network',
                            'error_code' => (string) $httpStatus,
                            'message' => "RSS feed returned HTTP {$httpStatus}.",
                        ]
                    ],
                ];
            }

            $body = $response->body();
            $previousUseErrors = libxml_use_internal_errors(true);
            $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NONET | LIBXML_NOCDATA);
            libxml_clear_errors();
            libxml_use_internal_errors($previousUseErrors);

            if ($xml === false) {
                return [
                    'http_status' => $httpStatus,
                    'items' => [],
                    'errors' => [
                        [
                            'error_type' => 'parse',
                            'error_code' => 'INVALID_XML',
                            'message' => 'Failed to parse XML/RSS feed response.',
                        ]
                    ],
                ];
            }

            $entries = [];
            if (isset($xml->channel->item)) {
                foreach ($xml->channel->item as $item) {
                    $entries[] = [
                        'title' => (string) $item->title,
                        'link' => (string) $item->link,
                        'guid' => (string) ($item->guid ?: $item->link),
                        'pubDate' => (string) ($item->pubDate ?: ''),
                        'description' => strip_tags((string) ($item->description ?: '')),
                    ];
                }
            } elseif (isset($xml->entry)) {
                foreach ($xml->entry as $entry) {
                    $link = '';
                    if (isset($entry->link['href'])) {
                        $link = (string) $entry->link['href'];
                    } elseif (isset($entry->link)) {
                        $link = (string) $entry->link;
                    }
                    $entries[] = [
                        'title' => (string) $entry->title,
                        'link' => $link,
                        'guid' => (string) ($entry->id ?: $link),
                        'pubDate' => (string) ($entry->published ?: $entry->updated ?: ''),
                        'description' => strip_tags((string) ($entry->summary ?: $entry->content ?: '')),
                    ];
                }
            }

            foreach (array_slice($entries, 0, 30) as $entry) {
                $title = trim($entry['title']);
                if ($title === '') {
                    continue;
                }

                $link = trim($entry['link']);
                if (!$this->urlValidator->isSafeCitationUrl($link)) {
                    $link = $safeEndpoint;
                }

                try {
                    $publishedAt = $entry['pubDate'] !== '' ? Carbon::parse($entry['pubDate']) : now();
                } catch (Throwable $e) {
                    $publishedAt = now();
                }

                $summary = trim(preg_replace('/\s+/', ' ', $entry['description']));
                $summary = mb_substr($summary, 0, 350);

                $items[] = [
                    'external_id' => mb_substr(trim($entry['guid']), 0, 250),
                    'original_url' => $link,
                    'title' => mb_substr($title, 0, 500),
                    'summary' => $summary !== '' ? $summary : null,
                    'published_at' => $publishedAt->toIso8601String(),
                    'metric_key' => null,
                    'metric_value' => null,
                    'metric_unit' => null,
                    'evidence_type' => 'article_signal',
                    'is_direct_metric' => false,
                ];
            }
        } catch (Throwable $e) {
            $errors[] = [
                'error_type' => 'network',
                'error_code' => 'EXCEPTION',
                'message' => 'RSS feed collection error: ' . $e->getMessage(),
            ];
        }

        return [
            'http_status' => $httpStatus,
            'items' => $items,
            'errors' => $errors,
        ];
    }
}

