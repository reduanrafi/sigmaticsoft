<?php

namespace Tests\Feature;

use App\Models\TrendCategory;
use App\Models\TrendObservation;
use App\Models\TrendSource;
use App\Services\TrendIntelligence\TrendAnalysisService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrendIntelligenceAnalysisTest extends TestCase
{
    use RefreshDatabase;

    protected TrendCategory $category;
    protected TrendSource $empiricalSourceA;
    protected TrendSource $empiricalSourceB;
    protected TrendSource $signalOnlySource;

    protected function setUp(): void
    {
        parent::setUp();
        TrendCategory::ensureDefaultsExist();

        $this->category = TrendCategory::where('slug', 'ai-adoption-software-development')->firstOrFail();

        $this->empiricalSourceA = TrendSource::create([
            'name' => 'Enterprise Dev Benchmark A',
            'slug' => 'enterprise-dev-benchmark-a',
            'connector_type' => 'public_json_api',
            'endpoint_url' => 'https://benchmarks-a.example.org/data.json',
            'source_domain' => 'benchmarks-a.example.org',
            'default_category_id' => $this->category->id,
            'allows_direct_metric_proof' => true,
            'trust_weight' => 0.90,
            'is_active' => true,
        ]);

        $this->empiricalSourceB = TrendSource::create([
            'name' => 'Independent Telemetry Index B',
            'slug' => 'independent-telemetry-index-b',
            'connector_type' => 'public_json_api',
            'endpoint_url' => 'https://telemetry-b.example.org/data.json',
            'source_domain' => 'telemetry-b.example.org',
            'default_category_id' => $this->category->id,
            'allows_direct_metric_proof' => true,
            'trust_weight' => 0.85,
            'is_active' => true,
        ]);

        $this->signalOnlySource = TrendSource::create([
            'name' => 'Community Discussion Feed',
            'slug' => 'community-discussion-feed',
            'connector_type' => 'hn_algolia',
            'endpoint_url' => 'https://hn.algolia.com/api/v1/search_by_date',
            'source_domain' => 'hn.algolia.com',
            'default_category_id' => $this->category->id,
            'allows_direct_metric_proof' => false,
            'trust_weight' => 0.70,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function it_returns_insufficient_evidence_when_category_has_no_observations()
    {
        $service = app(TrendAnalysisService::class);
        $metrics = $service->analyzeCategory($this->category);

        $this->assertCount(1, $metrics);
        $latest = $metrics->last();
        $this->assertEquals('insufficient_evidence', $latest->direction);
        $this->assertEquals('Insufficient evidence', $latest->direction_label);
        $this->assertNull($latest->trend_score);
        $this->assertStringContainsString('Insufficient evidence', $latest->data_limitations);
    }

    /** @test */
    public function it_does_not_treat_article_counts_or_discussion_or_repo_activity_as_direct_proof()
    {
        // Insert 10 weeks of article/discussion/repository observations with high numbers
        $baseMonday = Carbon::parse('2026-08-03 10:00:00');

        for ($w = 0; $w < 6; $w++) {
            $pubDate = $baseMonday->copy()->addWeeks($w);
            TrendObservation::create([
                'trend_source_id' => $this->signalOnlySource->id,
                'trend_category_id' => $this->category->id,
                'source_name' => $this->signalOnlySource->name,
                'original_url' => "https://news.ycombinator.com/item?id=100{$w}",
                'external_id' => "sig_{$w}",
                'duplicate_hash' => hash('sha256', "sig_{$w}"),
                'title' => "Week {$w} AI coding discussion surge",
                'published_at' => $pubDate,
                'collected_at' => $pubDate,
                'metric_key' => 'discussion_points',
                'metric_value' => 500 + ($w * 150),
                'metric_unit' => 'points',
                'evidence_type' => 'discussion_activity',
                'is_direct_metric' => false,
                'evidence_quality_score' => 0.65,
                'quality_status' => 'provisional',
                'relevance_status' => 'relevant',
            ]);
        }

        $service = app(TrendAnalysisService::class);
        $metrics = $service->analyzeCategory($this->category);

        foreach ($metrics as $metric) {
            $this->assertEquals('insufficient_evidence', $metric->direction);
            $this->assertEquals('signal_only_no_direct_proof', $metric->evidence_sufficiency);
            $this->assertNull($metric->trend_score);
            $this->assertStringContainsString('never treated as direct proof', $metric->data_limitations);
        }
    }

    /** @test */
    public function it_handles_zero_baseline_safely_without_division_by_zero()
    {
        $week1 = Carbon::parse('2026-09-07 12:00:00');
        $week2 = Carbon::parse('2026-09-14 12:00:00');
        $week3 = Carbon::parse('2026-09-21 12:00:00');

        // Week 1 & 2 have 0.0 baseline value
        foreach ([$week1, $week2] as $idx => $date) {
            TrendObservation::create([
                'trend_source_id' => $this->empiricalSourceA->id,
                'trend_category_id' => $this->category->id,
                'source_name' => $this->empiricalSourceA->name,
                'original_url' => "https://benchmarks-a.example.org/w{$idx}",
                'external_id' => "zero_{$idx}",
                'duplicate_hash' => hash('sha256', "zero_{$idx}"),
                'title' => "Zero baseline measurement {$idx}",
                'published_at' => $date,
                'collected_at' => $date,
                'metric_key' => 'adoption_rate',
                'metric_value' => 0.0,
                'metric_unit' => 'percentage',
                'evidence_type' => 'empirical_metric',
                'is_direct_metric' => true,
                'evidence_quality_score' => 0.85,
                'quality_status' => 'verified',
                'relevance_status' => 'relevant',
            ]);
        }

        // Week 3 has positive value, but prior baseline mean is 0.0
        TrendObservation::create([
            'trend_source_id' => $this->empiricalSourceA->id,
            'trend_category_id' => $this->category->id,
            'source_name' => $this->empiricalSourceA->name,
            'original_url' => 'https://benchmarks-a.example.org/w3',
            'external_id' => 'zero_3',
            'duplicate_hash' => hash('sha256', 'zero_3'),
            'title' => 'Positive measurement after zero baseline',
            'published_at' => $week3,
            'collected_at' => $week3,
            'metric_key' => 'adoption_rate',
            'metric_value' => 25.0,
            'metric_unit' => 'percentage',
            'evidence_type' => 'empirical_metric',
            'is_direct_metric' => true,
            'evidence_quality_score' => 0.85,
            'quality_status' => 'verified',
            'relevance_status' => 'relevant',
        ]);

        $service = app(TrendAnalysisService::class);
        $metrics = $service->analyzeCategory($this->category);
        $last = $metrics->last();

        $this->assertEquals('insufficient_evidence', $last->direction);
        $this->assertNull($last->percent_change_vs_baseline);
        $this->assertNull($last->trend_score);
        $this->assertStringContainsString('zero', strtolower($last->data_limitations));
    }

    /** @test */
    public function it_identifies_persistent_increase_and_calculates_transparent_score_across_independent_sources()
    {
        $baseMonday = Carbon::parse('2026-08-03 12:00:00');
        // 4 baseline weeks around 40.0, followed by 3 increasing weeks (46.0, 52.0, 58.0)
        $weeklyValues = [40.0, 40.5, 39.5, 40.0, 46.0, 52.0, 58.0];

        foreach ($weeklyValues as $w => $val) {
            $pubDate = $baseMonday->copy()->addWeeks($w);
            TrendObservation::create([
                'trend_source_id' => $this->empiricalSourceA->id,
                'trend_category_id' => $this->category->id,
                'source_name' => $this->empiricalSourceA->name,
                'original_url' => "https://benchmarks-a.example.org/report-{$w}",
                'external_id' => "emp_a_{$w}",
                'duplicate_hash' => hash('sha256', "emp_a_{$w}"),
                'title' => "Enterprise AI Adoption Benchmark Week {$w}",
                'published_at' => $pubDate,
                'collected_at' => $pubDate,
                'metric_key' => 'adoption_rate',
                'metric_value' => $val,
                'metric_unit' => 'percentage',
                'evidence_type' => 'empirical_metric',
                'is_direct_metric' => true,
                'evidence_quality_score' => 0.90,
                'quality_status' => 'verified',
                'relevance_status' => 'relevant',
            ]);

            // Add corroborating second source on the last 2 weeks
            if ($w >= 5) {
                TrendObservation::create([
                    'trend_source_id' => $this->empiricalSourceB->id,
                    'trend_category_id' => $this->category->id,
                    'source_name' => $this->empiricalSourceB->name,
                    'original_url' => "https://telemetry-b.example.org/report-{$w}",
                    'external_id' => "emp_b_{$w}",
                    'duplicate_hash' => hash('sha256', "emp_b_{$w}"),
                    'title' => "Independent Telemetry Survey Week {$w}",
                    'published_at' => $pubDate->copy()->addHours(4),
                    'collected_at' => $pubDate->copy()->addHours(4),
                    'metric_key' => 'adoption_rate',
                    'metric_value' => $val + 1.0,
                    'metric_unit' => 'percentage',
                    'evidence_type' => 'survey_benchmark',
                    'is_direct_metric' => true,
                    'evidence_quality_score' => 0.88,
                    'quality_status' => 'verified',
                    'relevance_status' => 'relevant',
                ]);
            }
        }

        $service = app(TrendAnalysisService::class);
        $metrics = $service->analyzeCategory($this->category);
        $latest = $metrics->last();

        $this->assertEquals('increasing', $latest->direction);
        $this->assertEquals('sufficient', $latest->evidence_sufficiency);
        $this->assertEquals(3, $latest->persistence_weeks);
        $this->assertEquals(2, $latest->independent_source_count);
        $this->assertGreaterThan(20.0, $latest->trend_score);
        $this->assertIsArray($latest->score_breakdown);
        $this->assertArrayHasKey('magnitude_component', $latest->score_breakdown);
        $this->assertArrayHasKey('persistence_component', $latest->score_breakdown);
        $this->assertArrayHasKey('corroboration_component', $latest->score_breakdown);
    }
}

