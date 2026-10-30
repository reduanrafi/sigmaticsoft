<?php

namespace Tests\Feature;

use App\Models\TrendCategory;
use App\Models\TrendForecast;
use App\Models\TrendObservation;
use App\Models\TrendSource;
use App\Models\TrendWeeklyMetric;
use App\Services\TrendIntelligence\TrendForecastEvaluationService;
use App\Services\TrendIntelligence\TrendForecastService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrendIntelligenceForecastTest extends TestCase
{
    use RefreshDatabase;

    protected TrendCategory $category;
    protected TrendSource $sourceA;
    protected TrendSource $sourceB;

    protected function setUp(): void
    {
        parent::setUp();
        TrendCategory::ensureDefaultsExist();

        $this->category = TrendCategory::where('slug', 'global-software-engineering-job-demand')->firstOrFail();

        $this->sourceA = TrendSource::create([
            'name' => 'Global Hiring Telemetry A',
            'slug' => 'global-hiring-telemetry-a',
            'connector_type' => 'public_json_api',
            'endpoint_url' => 'https://jobs-a.example.org/metrics.json',
            'source_domain' => 'jobs-a.example.org',
            'default_category_id' => $this->category->id,
            'allows_direct_metric_proof' => true,
            'trust_weight' => 0.90,
            'is_active' => true,
        ]);

        $this->sourceB = TrendSource::create([
            'name' => 'Engineering Payroll Index B',
            'slug' => 'engineering-payroll-index-b',
            'connector_type' => 'public_json_api',
            'endpoint_url' => 'https://jobs-b.example.org/metrics.json',
            'source_domain' => 'jobs-b.example.org',
            'default_category_id' => $this->category->id,
            'allows_direct_metric_proof' => true,
            'trust_weight' => 0.85,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function it_preserves_every_forecast_as_a_new_historical_record_and_populates_all_required_fields()
    {
        $baseMonday = Carbon::parse('2026-08-03 10:00:00');
        $values = [100.0, 100.0, 100.0, 100.0, 110.0, 118.0, 125.0];

        foreach ($values as $w => $v) {
            $pubDate = $baseMonday->copy()->addWeeks($w);
            TrendObservation::create([
                'trend_source_id' => $this->sourceA->id,
                'trend_category_id' => $this->category->id,
                'source_name' => $this->sourceA->name,
                'original_url' => "https://jobs-a.example.org/week-{$w}",
                'external_id' => "ja_{$w}",
                'duplicate_hash' => hash('sha256', "ja_{$w}"),
                'title' => "Global Engineering Job Index Week {$w}",
                'published_at' => $pubDate,
                'collected_at' => $pubDate,
                'metric_key' => 'job_demand_index',
                'metric_value' => $v,
                'metric_unit' => 'index_points',
                'evidence_type' => 'empirical_metric',
                'is_direct_metric' => true,
                'evidence_quality_score' => 0.90,
                'quality_status' => 'verified',
                'relevance_status' => 'relevant',
            ]);

            TrendObservation::create([
                'trend_source_id' => $this->sourceB->id,
                'trend_category_id' => $this->category->id,
                'source_name' => $this->sourceB->name,
                'original_url' => "https://jobs-b.example.org/week-{$w}",
                'external_id' => "jb_{$w}",
                'duplicate_hash' => hash('sha256', "jb_{$w}"),
                'title' => "Payroll Hiring Velocity Week {$w}",
                'published_at' => $pubDate->copy()->addHours(2),
                'collected_at' => $pubDate->copy()->addHours(2),
                'metric_key' => 'job_demand_index',
                'metric_value' => $v + 1.0,
                'metric_unit' => 'index_points',
                'evidence_type' => 'empirical_metric',
                'is_direct_metric' => true,
                'evidence_quality_score' => 0.85,
                'quality_status' => 'verified',
                'relevance_status' => 'relevant',
            ]);
        }

        $forecastService = app(TrendForecastService::class);

        $forecast3mFirst = $forecastService->generateDraftForecast($this->category, 3);
        $forecast3mSecond = $forecastService->generateDraftForecast($this->category, 3);
        $forecast6m = $forecastService->generateDraftForecast($this->category, 6);
        $forecast12m = $forecastService->generateDraftForecast($this->category, 12);

        // Must preserve earlier predictions rather than overwriting
        $this->assertNotEquals($forecast3mFirst->id, $forecast3mSecond->id);
        $this->assertEquals(4, TrendForecast::count());

        $this->assertEquals('draft', $forecast3mFirst->status);
        $this->assertEquals(3, $forecast3mFirst->horizon_months);
        $this->assertEquals('increasing', $forecast3mFirst->trend_direction);
        $this->assertEquals('high', $forecast3mFirst->confidence_level);
        $this->assertNotEmpty($forecast3mFirst->what_is_happening_now);
        $this->assertNotEmpty($forecast3mFirst->what_may_happen_next);
        $this->assertNotEmpty($forecast3mFirst->why_generated);
        $this->assertNotEmpty($forecast3mFirst->uncertainties_and_alternatives);
        $this->assertNotEmpty($forecast3mFirst->supporting_evidence);
        $this->assertNotNull($forecast3mFirst->generated_at);
        $this->assertEquals('v1.0-deterministic', $forecast3mFirst->methodology_version);

        // Never present internal trend score as a calibrated probability
        $this->assertStringContainsString('never presented as calibrated statistical probabilities', $forecast3mFirst->confidence_justification);

        // 12-month horizon has lower confidence than 3-month horizon
        $this->assertEquals('low', $forecast12m->confidence_level);
    }

    /** @test */
    public function it_never_claims_accuracy_before_target_horizon_and_evaluates_correctly_after_horizon()
    {
        $forecast = TrendForecast::create([
            'forecast_code' => 'FC-TEST-0001',
            'trend_category_id' => $this->category->id,
            'horizon_months' => 3,
            'title' => 'Test 3-Month Forecast',
            'slug' => 'test-3-month-forecast',
            'trend_direction' => 'increasing',
            'internal_trend_score' => 35.0,
            'confidence_level' => 'moderate',
            'confidence_justification' => 'Moderate confidence under deterministic rules.',
            'what_is_happening_now' => 'Current baseline is 100.0.',
            'what_may_happen_next' => 'Projected increase over 3 months.',
            'why_generated' => 'Rule based.',
            'uncertainties_and_alternatives' => 'Macro shifts.',
            'supporting_evidence' => [],
            'baseline_snapshot' => ['recent_mean' => 100.0],
            'target_date' => now()->addMonths(3)->toDateString(),
            'methodology_version' => 'v1.0-deterministic',
            'status' => 'published',
            'generated_at' => now(),
            'published_at' => now(),
        ]);

        $evalService = app(TrendForecastEvaluationService::class);
        $preEval = $evalService->evaluateForecast($forecast);

        $this->assertEquals('pending_horizon', $preEval->outcome_status);
        $this->assertFalse($forecast->fresh()->hasBeenEvaluated());
        $this->assertStringContainsString('Accuracy is never claimed prior to post-horizon outcome verification', $preEval->evaluation_summary);

        // Now simulate a historical forecast whose target date was last week and subsequent weekly metric exists
        $pastForecast = TrendForecast::create([
            'forecast_code' => 'FC-TEST-0002',
            'trend_category_id' => $this->category->id,
            'horizon_months' => 3,
            'title' => 'Historical 3-Month Forecast',
            'slug' => 'historical-3-month-forecast',
            'trend_direction' => 'increasing',
            'internal_trend_score' => 40.0,
            'confidence_level' => 'high',
            'confidence_justification' => 'High confidence.',
            'what_is_happening_now' => 'Baseline 100.0.',
            'what_may_happen_next' => 'Increase expected.',
            'why_generated' => 'Rule based.',
            'uncertainties_and_alternatives' => 'Macro shifts.',
            'supporting_evidence' => [],
            'baseline_snapshot' => ['recent_mean' => 100.0],
            'target_date' => now()->subDays(5)->toDateString(),
            'methodology_version' => 'v1.0-deterministic',
            'status' => 'published',
            'generated_at' => now()->subMonths(3)->subDays(5),
            'published_at' => now()->subMonths(3)->subDays(5),
        ]);

        TrendWeeklyMetric::create([
            'trend_category_id' => $this->category->id,
            'year_week' => now()->format('o-\WW'),
            'week_start_date' => now()->startOfWeek()->toDateString(),
            'week_end_date' => now()->endOfWeek()->toDateString(),
            'observation_count' => 4,
            'empirical_observation_count' => 4,
            'signal_only_count' => 0,
            'independent_source_count' => 2,
            'contradictory_observation_count' => 0,
            'primary_metric_mean' => 118.5,
            'baseline_mean' => 100.0,
            'percent_change_vs_baseline' => 18.5,
            'direction' => 'increasing',
            'persistence_weeks' => 4,
            'trend_score' => 45.0,
            'evidence_sufficiency' => 'sufficient',
            'methodology_version' => 'v1.0-deterministic',
            'aggregated_at' => now(),
        ]);

        $postEval = $evalService->evaluateForecast($pastForecast);
        $this->assertEquals('verified_accurate', $postEval->outcome_status);
        $this->assertEquals(18.5, $postEval->actual_percent_change);
        $this->assertTrue($pastForecast->fresh()->hasBeenEvaluated());
    }
}

