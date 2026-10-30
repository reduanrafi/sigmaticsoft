<?php

namespace Tests\Feature;

use App\Models\TrendCategory;
use App\Models\TrendForecast;
use App\Models\TrendObservation;
use App\Models\TrendSource;
use App\Models\TrendWeeklyMetric;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrendIntelligenceAdminAndPublicTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $clientUser;
    protected TrendCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        TrendCategory::ensureDefaultsExist();
        TrendSource::ensureDefaultSourcesExist();

        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->clientUser = User::factory()->create(['role' => 'client']);
        $this->category = TrendCategory::where('slug', 'ai-adoption-software-development')->firstOrFail();
    }

    /** @test */
    public function guests_and_non_admin_users_cannot_access_admin_trend_intelligence_routes()
    {
        $this->get(route('admin.trend-intelligence.index'))->assertRedirect('/login');
        $this->post(route('admin.trend-intelligence.collect'))->assertRedirect('/login');

        $this->actingAs($this->clientUser)
            ->get(route('admin.trend-intelligence.index'))
            ->assertStatus(403);

        $this->actingAs($this->clientUser)
            ->post(route('admin.trend-intelligence.collect'))
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->get(route('admin.trend-intelligence.index'))
            ->assertStatus(200)
            ->assertSee('Global Software Industry Trend Intelligence');
    }

    /** @test */
    public function admin_cannot_save_a_source_with_ssrf_or_unsafe_url()
    {
        $response = $this->actingAs($this->adminUser)->post(route('admin.trend-intelligence.sources.store'), [
            'name' => 'Internal SSRF Probe',
            'connector_type' => 'public_json_api',
            'endpoint_url' => 'http://127.0.0.1/internal-config.json',
            'default_category_id' => $this->category->id,
            'rate_limit_per_minute' => 10,
            'fetch_interval_minutes' => 60,
            'trust_weight' => 0.80,
        ]);

        $response->assertSessionHasErrors('endpoint_url');
        $this->assertDatabaseMissing('trend_sources', ['name' => 'Internal SSRF Probe']);
    }

    /** @test */
    public function draft_and_approved_forecasts_remain_private_and_accidental_publication_is_blocked()
    {
        $draft = TrendForecast::create([
            'forecast_code' => 'FC-PRIV-DRAFT',
            'trend_category_id' => $this->category->id,
            'horizon_months' => 3,
            'title' => 'Private Unapproved Draft Forecast Secret Title',
            'slug' => 'private-unapproved-draft',
            'trend_direction' => 'increasing',
            'internal_trend_score' => 28.0,
            'confidence_level' => 'moderate',
            'confidence_justification' => 'Moderate confidence.',
            'what_is_happening_now' => 'Current baseline.',
            'what_may_happen_next' => 'Next 3 months.',
            'why_generated' => 'Rule generated.',
            'uncertainties_and_alternatives' => 'Uncertainties.',
            'editorial_notes' => 'Confidential internal admin note XYZ987',
            'supporting_evidence' => [
                [
                    'title' => 'Verified Public Benchmark',
                    'source_name' => 'Benchmark Org',
                    'url' => 'https://example.org/benchmark-1',
                    'published_at' => '2026-10-20',
                    'metric_value' => 45.0,
                    'metric_unit' => 'percentage',
                    'evidence_type' => 'empirical_metric',
                    'is_direct_metric' => true,
                ],
            ],
            'target_date' => now()->addMonths(3)->toDateString(),
            'methodology_version' => 'v1.0-deterministic',
            'status' => 'draft',
            'generated_at' => now(),
        ]);

        // Public outlook must NOT show draft
        $this->get(route('trend-intelligence.outlook'))
            ->assertStatus(200)
            ->assertDontSee('Private Unapproved Draft Forecast Secret Title')
            ->assertDontSee('Confidential internal admin note XYZ987');

        // Attempting to publish directly from 'draft' without 'approved' status must fail
        $this->actingAs($this->adminUser)
            ->post(route('admin.trend-intelligence.forecasts.publish', $draft->id), [
                'confirm_publish' => '1',
            ]);

        $this->assertEquals('draft', $draft->fresh()->status);

        // Approve first
        $this->actingAs($this->adminUser)
            ->post(route('admin.trend-intelligence.forecasts.approve', $draft->id));

        $this->assertEquals('approved', $draft->fresh()->status);

        // Approved is still not public until published
        $this->get(route('trend-intelligence.outlook'))
            ->assertStatus(200)
            ->assertDontSee('Private Unapproved Draft Forecast Secret Title');

        // Publish with confirmation
        $this->actingAs($this->adminUser)
            ->post(route('admin.trend-intelligence.forecasts.publish', $draft->id), [
                'confirm_publish' => '1',
            ]);

        $this->assertEquals('published', $draft->fresh()->status);

        // Now visible on public page, but private editorial_notes are still never exposed
        $this->get(route('trend-intelligence.outlook'))
            ->assertStatus(200)
            ->assertSee('Private Unapproved Draft Forecast Secret Title')
            ->assertDontSee('Confidential internal admin note XYZ987');

        // Unpublish removes it from public page
        $this->actingAs($this->adminUser)
            ->post(route('admin.trend-intelligence.forecasts.unpublish', $draft->id));

        $this->assertEquals('unpublished', $draft->fresh()->status);
        $this->get(route('trend-intelligence.outlook'))
            ->assertStatus(200)
            ->assertDontSee('Private Unapproved Draft Forecast Secret Title');
    }

    /** @test */
    public function thin_category_pages_without_sufficient_evidence_and_published_forecasts_return_404()
    {
        // Category has no published forecasts and no sufficient weekly metrics -> 404
        $this->get(route('trend-intelligence.category', $this->category->slug))
            ->assertStatus(404);

        // Now populate sufficient observations, weekly metric, and a published forecast
        $source = TrendSource::first();
        for ($i = 1; $i <= 4; $i++) {
            TrendObservation::create([
                'trend_source_id' => $source->id,
                'trend_category_id' => $this->category->id,
                'source_name' => $source->name,
                'original_url' => "https://example.org/obs-{$i}",
                'external_id' => "obs_{$i}",
                'duplicate_hash' => hash('sha256', "obs_{$i}"),
                'title' => "Verified Empirical Observation {$i}",
                'published_at' => now()->subDays($i),
                'collected_at' => now(),
                'metric_key' => 'adoption_rate',
                'metric_value' => 50.0 + $i,
                'metric_unit' => 'percentage',
                'evidence_type' => 'empirical_metric',
                'is_direct_metric' => true,
                'evidence_quality_score' => 0.90,
                'quality_status' => 'verified',
                'relevance_status' => 'relevant',
            ]);
        }

        TrendWeeklyMetric::create([
            'trend_category_id' => $this->category->id,
            'year_week' => '2026-W44',
            'week_start_date' => '2026-10-26',
            'week_end_date' => '2026-11-01',
            'observation_count' => 4,
            'empirical_observation_count' => 4,
            'signal_only_count' => 0,
            'independent_source_count' => 2,
            'contradictory_observation_count' => 0,
            'primary_metric_mean' => 52.5,
            'baseline_mean' => 45.0,
            'percent_change_vs_baseline' => 16.67,
            'direction' => 'increasing',
            'persistence_weeks' => 3,
            'trend_score' => 38.0,
            'evidence_sufficiency' => 'sufficient',
            'methodology_version' => 'v1.0-deterministic',
            'aggregated_at' => now(),
        ]);

        TrendForecast::create([
            'forecast_code' => 'FC-CAT-PUB1',
            'trend_category_id' => $this->category->id,
            'horizon_months' => 6,
            'title' => 'Published 6-Month AI Adoption Outlook',
            'slug' => 'published-6m-ai-adoption-outlook',
            'trend_direction' => 'increasing',
            'internal_trend_score' => 38.0,
            'confidence_level' => 'moderate',
            'confidence_justification' => 'Moderate confidence.',
            'what_is_happening_now' => 'Current mean is 52.5%.',
            'what_may_happen_next' => 'Continued adoption over 6 months.',
            'why_generated' => 'Rule based.',
            'uncertainties_and_alternatives' => 'Budget cycles.',
            'supporting_evidence' => [
                [
                    'title' => 'Verified Empirical Observation 1',
                    'source_name' => $source->name,
                    'url' => 'https://example.org/obs-1',
                    'published_at' => '2026-10-29',
                    'metric_value' => 51.0,
                    'metric_unit' => 'percentage',
                    'evidence_type' => 'empirical_metric',
                    'is_direct_metric' => true,
                ],
            ],
            'target_date' => now()->addMonths(6)->toDateString(),
            'methodology_version' => 'v1.0-deterministic',
            'status' => 'published',
            'generated_at' => now(),
            'published_at' => now(),
        ]);

        // Category page now loads with 200 and displays the published forecast and evidence
        $this->get(route('trend-intelligence.category', $this->category->slug))
            ->assertStatus(200)
            ->assertSee('Published 6-Month AI Adoption Outlook')
            ->assertSee('Verified Empirical Observation 1');
    }
}

