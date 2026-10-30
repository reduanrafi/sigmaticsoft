<?php

namespace Tests\Feature;

use App\Models\TrendCategory;
use App\Models\TrendObservation;
use App\Models\TrendSource;
use App\Services\TrendIntelligence\TrendCollectionService;
use App\Services\TrendIntelligence\UrlSafetyValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Tests\TestCase;

class TrendIntelligenceCollectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        TrendCategory::ensureDefaultsExist();
        TrendSource::ensureDefaultSourcesExist();
    }

    /** @test */
    public function it_creates_the_six_default_trend_categories_and_default_sources()
    {
        $this->assertEquals(6, TrendCategory::count());
        $this->assertGreaterThanOrEqual(2, TrendSource::count());

        $slugs = TrendCategory::pluck('slug')->toArray();
        $this->assertContains('ai-adoption-software-development', $slugs);
        $this->assertContains('global-software-engineering-job-demand', $slugs);
        $this->assertContains('ai-built-applications-low-code', $slugs);
        $this->assertContains('software-maintenance-modernization-security-integration', $slugs);
        $this->assertContains('developer-productivity-engineering-team-structure', $slugs);
        $this->assertContains('software-company-economics-development-costs', $slugs);
    }

    /** @test */
    public function url_safety_validator_blocks_ssrf_and_unsafe_urls()
    {
        $validator = new UrlSafetyValidator();

        $blockedUrls = [
            'http://127.0.0.1/admin',
            'http://localhost:8000/secret',
            'http://169.254.169.254/latest/meta-data/',
            'http://10.0.0.1/internal',
            'http://192.168.1.1/router',
            'http://172.16.5.4/private',
            'javascript:alert(1)',
            'file:///etc/passwd',
            'https://user:pass@example.com/feed',
            'https://example.com:8443/api',
            'http://service.internal/metrics',
        ];

        foreach ($blockedUrls as $unsafeUrl) {
            $this->assertFalse($validator->isSafeCitationUrl($unsafeUrl), "Expected URL to be blocked: {$unsafeUrl}");
        }

        $this->assertTrue($validator->isSafeCitationUrl('https://hn.algolia.com/api/v1/search_by_date'));
        $this->assertTrue($validator->isSafeCitationUrl('https://www.cisa.gov/known-exploited-vulnerabilities'));
    }

    /** @test */
    public function it_collects_from_hackernews_algolia_and_prevents_duplicates_and_marks_as_non_direct_proof()
    {
        Http::fake([
            'hn.algolia.com/*' => Http::response([
                'hits' => [
                    [
                        'objectID' => '991001',
                        'title' => 'Enterprise AI Coding Adoption Reaches New Milestone in Software Teams',
                        'url' => 'https://example.org/ai-coding-adoption-report',
                        'points' => 142,
                        'num_comments' => 65,
                        'created_at' => '2026-10-20T12:00:00Z',
                        'author' => 'eng_lead',
                    ],
                    [
                        'objectID' => '991002',
                        'title' => 'Legacy Modernization Strategies for Enterprise API Integration',
                        'url' => 'https://example.org/legacy-modernization-api',
                        'points' => 88,
                        'num_comments' => 31,
                        'created_at' => '2026-10-21T15:30:00Z',
                        'author' => 'arch_dev',
                    ],
                ],
            ], 200),
        ]);

        $source = TrendSource::where('slug', 'hn-algolia-software-signals')->firstOrFail();
        $service = app(TrendCollectionService::class);

        $run1 = $service->collectSource($source, 'manual');

        $this->assertEquals('completed', $run1->status);
        $this->assertEquals(2, $run1->items_fetched);
        $this->assertEquals(2, $run1->items_stored);
        $this->assertEquals(0, $run1->items_skipped_duplicate);

        $obs = TrendObservation::where('external_id', 'hn_991001')->first();
        $this->assertNotNull($obs);
        $this->assertFalse($obs->is_direct_metric, 'Discussion activity must never be marked as direct industry proof');
        $this->assertEquals('discussion_activity', $obs->evidence_type);

        // Run second time with identical data -> should skip duplicates
        $run2 = $service->collectSource($source, 'manual');
        $this->assertEquals(2, $run2->items_skipped_duplicate);
        $this->assertEquals(0, $run2->items_stored);
        $this->assertEquals(2, TrendObservation::count());
    }

    /** @test */
    public function it_logs_collection_errors_when_source_returns_paywall_or_ssrf_is_attempted()
    {
        Http::fake([
            'example.com/*' => Http::response('Paywall / Unauthorized', 403),
        ]);

        $category = TrendCategory::first();
        $paywalledSource = TrendSource::create([
            'name' => 'Restricted Source',
            'slug' => 'restricted-source',
            'connector_type' => 'public_json_api',
            'endpoint_url' => 'https://example.com/restricted.json',
            'default_category_id' => $category->id,
            'rate_limit_per_minute' => 10,
            'fetch_interval_minutes' => 60,
            'is_active' => true,
        ]);

        $service = app(TrendCollectionService::class);
        $run = $service->collectSource($paywalledSource, 'manual');

        $this->assertEquals('failed', $run->status);
        $this->assertEquals(1, $run->error_count);
        $this->assertDatabaseHas('trend_collection_errors', [
            'trend_collection_run_id' => $run->id,
            'error_type' => 'auth_or_paywall',
            'error_code' => '403',
        ]);

        // Test SSRF blocked source
        $ssrfSource = TrendSource::create([
            'name' => 'Internal Metadata Attempt',
            'slug' => 'ssrf-attempt',
            'connector_type' => 'public_json_api',
            'endpoint_url' => 'http://169.254.169.254/latest/meta-data/',
            'default_category_id' => $category->id,
            'rate_limit_per_minute' => 10,
            'fetch_interval_minutes' => 60,
            'is_active' => true,
        ]);

        $ssrfRun = $service->collectSource($ssrfSource, 'manual');
        $this->assertEquals('failed', $ssrfRun->status);
        $this->assertDatabaseHas('trend_collection_errors', [
            'trend_collection_run_id' => $ssrfRun->id,
            'error_type' => 'ssrf_blocked',
        ]);
    }
}
