<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Throwable;

class TrendCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'primary_metric_unit',
        'display_order',
        'min_observations_required',
        'min_independent_sources',
        'baseline_weeks',
        'recent_weeks',
        'keywords',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'min_observations_required' => 'integer',
        'min_independent_sources' => 'integer',
        'baseline_weeks' => 'integer',
        'recent_weeks' => 'integer',
    ];

    public function sources()
    {
        return $this->hasMany(TrendSource::class, 'default_category_id');
    }

    public function observations()
    {
        return $this->hasMany(TrendObservation::class);
    }

    public function weeklyMetrics()
    {
        return $this->hasMany(TrendWeeklyMetric::class)->orderBy('week_start_date', 'asc');
    }

    public function latestWeeklyMetric()
    {
        return $this->hasOne(TrendWeeklyMetric::class)->latestOfMany('week_start_date');
    }

    public function forecasts()
    {
        return $this->hasMany(TrendForecast::class);
    }

    public function publishedForecasts()
    {
        return $this->hasMany(TrendForecast::class)
            ->where('status', 'published')
            ->orderByDesc('published_at');
    }

    /**
     * Initial 6 configurable categories required by Phase 3.
     */
    public static function defaultCategories(): array
    {
        return [
            [
                'name' => 'AI adoption in software development',
                'slug' => 'ai-adoption-software-development',
                'description' => 'Empirical evidence on enterprise and engineering team adoption of AI coding assistants, code review automation, and software lifecycle AI tooling.',
                'primary_metric_unit' => 'percentage',
                'display_order' => 1,
                'min_observations_required' => 3,
                'min_independent_sources' => 1,
                'baseline_weeks' => 4,
                'recent_weeks' => 4,
                'keywords' => ['copilot', 'ai coding', 'llm', 'codegen', 'ai adoption', 'developer ai'],
                'is_active' => true,
            ],
            [
                'name' => 'Global software engineering job demand',
                'slug' => 'global-software-engineering-job-demand',
                'description' => 'Measured shifts in software engineering job openings, hiring velocity, role specialization, and regional demand across global markets.',
                'primary_metric_unit' => 'index_points',
                'display_order' => 2,
                'min_observations_required' => 3,
                'min_independent_sources' => 1,
                'baseline_weeks' => 4,
                'recent_weeks' => 4,
                'keywords' => ['hiring', 'software engineer jobs', 'job openings', 'tech layoffs', 'engineering demand'],
                'is_active' => true,
            ],
            [
                'name' => 'AI-built applications and low-code development',
                'slug' => 'ai-built-applications-low-code',
                'description' => 'Quantitative indicators tracking production deployment of AI-generated applications, low-code/no-code platforms, and citizen developer workflows.',
                'primary_metric_unit' => 'percentage',
                'display_order' => 3,
                'min_observations_required' => 3,
                'min_independent_sources' => 1,
                'baseline_weeks' => 4,
                'recent_weeks' => 4,
                'keywords' => ['low-code', 'no-code', 'ai app builder', 'scaffold', 'rapid application'],
                'is_active' => true,
            ],
            [
                'name' => 'Software maintenance, modernization, security, and integration',
                'slug' => 'software-maintenance-modernization-security-integration',
                'description' => 'Indicators covering legacy system modernization, CVE/security advisory volumes, technical debt remediation, and enterprise API integration.',
                'primary_metric_unit' => 'count',
                'display_order' => 4,
                'min_observations_required' => 3,
                'min_independent_sources' => 1,
                'baseline_weeks' => 4,
                'recent_weeks' => 4,
                'keywords' => ['modernization', 'legacy', 'cve', 'vulnerability', 'security advisory', 'api integration', 'technical debt'],
                'is_active' => true,
            ],
            [
                'name' => 'Developer productivity and engineering team structure',
                'slug' => 'developer-productivity-engineering-team-structure',
                'description' => 'Measurements of engineering cycle time, DORA metrics, team topologies, senior-to-junior ratios, and platform engineering adoption.',
                'primary_metric_unit' => 'index_points',
                'display_order' => 5,
                'min_observations_required' => 3,
                'min_independent_sources' => 1,
                'baseline_weeks' => 4,
                'recent_weeks' => 4,
                'keywords' => ['dora metrics', 'developer productivity', 'cycle time', 'platform engineering', 'team topology'],
                'is_active' => true,
            ],
            [
                'name' => 'Software company economics and development costs',
                'slug' => 'software-company-economics-development-costs',
                'description' => 'Benchmarks on cloud infrastructure spend, R&D cost ratios, SaaS margins, and total cost of software ownership.',
                'primary_metric_unit' => 'index_points',
                'display_order' => 6,
                'min_observations_required' => 3,
                'min_independent_sources' => 1,
                'baseline_weeks' => 4,
                'recent_weeks' => 4,
                'keywords' => ['cloud cost', 'finops', 'saas economics', 'r&d spend', 'development cost'],
                'is_active' => true,
            ],
        ];
    }

    /**
     * Ensure the tables and 6 default categories exist in the database.
     */
    public static function ensureDefaultsExist(): void
    {
        try {
            if (!Schema::hasTable('trend_categories')) {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/2026_10_30_000001_create_trend_intelligence_tables.php',
                    '--force' => true,
                ]);
            }

            foreach (self::defaultCategories() as $cat) {
                self::firstOrCreate(
                    ['slug' => $cat['slug']],
                    $cat
                );
            }
        } catch (Throwable $e) {
            // Handled gracefully by callers if DB is offline
        }
    }
}
