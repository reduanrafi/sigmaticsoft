<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'connector_type',
        'endpoint_url',
        'source_domain',
        'default_category_id',
        'description',
        'terms_summary',
        'rate_limit_per_minute',
        'fetch_interval_minutes',
        'trust_weight',
        'allows_direct_metric_proof',
        'config',
        'is_active',
        'last_collected_at',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'allows_direct_metric_proof' => 'boolean',
        'rate_limit_per_minute' => 'integer',
        'fetch_interval_minutes' => 'integer',
        'trust_weight' => 'float',
        'last_collected_at' => 'datetime',
    ];

    public function defaultCategory()
    {
        return $this->belongsTo(TrendCategory::class, 'default_category_id');
    }

    public function collectionRuns()
    {
        return $this->hasMany(TrendCollectionRun::class)->orderByDesc('started_at');
    }

    public function collectionErrors()
    {
        return $this->hasMany(TrendCollectionError::class)->orderByDesc('occurred_at');
    }

    public function observations()
    {
        return $this->hasMany(TrendObservation::class)->orderByDesc('published_at');
    }

    /**
     * Ensure the initial verified connector source exists.
     */
    public static function ensureDefaultSourcesExist(): void
    {
        TrendCategory::ensureDefaultsExist();

        $securityCategory = TrendCategory::where('slug', 'software-maintenance-modernization-security-integration')->first();
        $aiCategory = TrendCategory::where('slug', 'ai-adoption-software-development')->first();

        if ($aiCategory) {
            self::firstOrCreate(
                ['slug' => 'hn-algolia-software-signals'],
                [
                    'name' => 'Hacker News Algolia Public Search API',
                    'connector_type' => 'hn_algolia',
                    'endpoint_url' => 'https://hn.algolia.com/api/v1/search_by_date',
                    'source_domain' => 'hn.algolia.com',
                    'default_category_id' => $aiCategory->id,
                    'description' => 'Public Hacker News Algolia REST API providing timestamped software engineering links and community signal metadata. Treated as qualitative/context signal, not direct proof of industry-wide change.',
                    'terms_summary' => 'Publicly accessible REST API by Algolia/Y Combinator; rate limit up to 10,000 requests/hour per IP; no authentication required; public links and titles only.',
                    'rate_limit_per_minute' => 15,
                    'fetch_interval_minutes' => 360,
                    'trust_weight' => 0.70,
                    'allows_direct_metric_proof' => false,
                    'config' => [
                        'query' => 'software engineering Legacy modernization OR AI coding',
                        'tags' => 'story',
                        'hitsPerPage' => 20,
                    ],
                    'is_active' => true,
                ]
            );
        }

        if ($securityCategory) {
            self::firstOrCreate(
                ['slug' => 'cisa-known-exploited-vulnerabilities'],
                [
                    'name' => 'CISA Known Exploited Vulnerabilities Public Catalog (JSON)',
                    'connector_type' => 'public_json_api',
                    'endpoint_url' => 'https://www.cisa.gov/sites/default/files/feeds/known_exploited_vulnerabilities.json',
                    'source_domain' => 'cisa.gov',
                    'default_category_id' => $securityCategory->id,
                    'description' => 'Official US CISA public JSON dataset of known exploited software vulnerabilities with historical dateAdded timestamps and quantitative vulnerability metrics.',
                    'terms_summary' => 'US Government public domain dataset (CC0 / Public Domain); free public access without authentication; polite caching and interval polling enforced.',
                    'rate_limit_per_minute' => 5,
                    'fetch_interval_minutes' => 720,
                    'trust_weight' => 0.95,
                    'allows_direct_metric_proof' => true,
                    'config' => [
                        'mode' => 'cisa_kev',
                        'metric_key' => 'exploited_vulnerabilities_added',
                        'metric_unit' => 'count',
                        'evidence_type' => 'empirical_metric',
                    ],
                    'is_active' => true,
                ]
            );
        }
    }
}

