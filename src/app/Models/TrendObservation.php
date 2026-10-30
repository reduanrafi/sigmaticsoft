<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trend_source_id',
        'trend_collection_run_id',
        'trend_category_id',
        'source_name',
        'original_url',
        'external_id',
        'duplicate_hash',
        'title',
        'summary',
        'published_at',
        'collected_at',
        'metric_key',
        'metric_value',
        'metric_unit',
        'evidence_type',
        'is_direct_metric',
        'evidence_quality_score',
        'quality_status',
        'relevance_status',
        'is_contradictory',
        'contradiction_notes',
        'raw_metadata',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'collected_at' => 'datetime',
        'metric_value' => 'float',
        'is_direct_metric' => 'boolean',
        'evidence_quality_score' => 'float',
        'is_contradictory' => 'boolean',
        'raw_metadata' => 'array',
    ];

    /**
     * Evidence types that represent social/article/repository activity and must NEVER
     * be treated as direct proof of industry-wide change per Phase 3 rules.
     */
    public const NON_PROOF_EVIDENCE_TYPES = [
        'article_signal',
        'discussion_activity',
        'repository_activity',
    ];

    public function source()
    {
        return $this->belongsTo(TrendSource::class, 'trend_source_id');
    }

    public function collectionRun()
    {
        return $this->belongsTo(TrendCollectionRun::class, 'trend_collection_run_id');
    }

    public function category()
    {
        return $this->belongsTo(TrendCategory::class, 'trend_category_id');
    }

    /**
     * Compute a deterministic SHA-256 duplicate-detection hash.
     */
    public static function computeDuplicateHash(
        int $sourceId,
        ?string $externalId,
        string $originalUrl,
        ?string $metricKey,
        string $publishedDate
    ): string {
        $normalizedUrl = strtolower(trim(preg_replace('/#.*$/', '', $originalUrl)));
        $payload = implode('|', [
            $sourceId,
            trim((string) $externalId),
            $normalizedUrl,
            trim((string) $metricKey),
            substr(trim($publishedDate), 0, 10),
        ]);

        return hash('sha256', $payload);
    }

    /**
     * Check whether this observation qualifies as direct empirical industry evidence.
     */
    public function qualifiesAsDirectEmpiricalEvidence(): bool
    {
        if (in_array($this->evidence_type, self::NON_PROOF_EVIDENCE_TYPES, true)) {
            return false;
        }

        return (bool) $this->is_direct_metric && $this->metric_value !== null;
    }
}

