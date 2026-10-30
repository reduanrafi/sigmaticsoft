<?php

namespace App\Services\TrendIntelligence\Connectors;

use App\Models\TrendSource;

interface TrendConnectorInterface
{
    /**
     * Unique connector identifier (e.g. 'hn_algolia', 'public_json_api', 'rss_feed').
     */
    public function getType(): string;

    /**
     * Fetch and normalize candidate observations from the given source.
     *
     * Returns an array with:
     * - 'http_status' => int|null
     * - 'items' => array<int, array<string, mixed>>
     * - 'errors' => array<int, array{error_type: string, error_code?: string|null, message: string, context?: array}>
     */
    public function fetch(TrendSource $source): array;
}

