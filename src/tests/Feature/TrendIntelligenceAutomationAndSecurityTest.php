<?php

namespace Tests\Feature;

use App\Jobs\RunTrendIntelligencePipelineJob;
use App\Models\TrendCategory;
use App\Models\TrendForecast;
use App\Models\TrendObservation;
use App\Models\TrendSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrendIntelligenceAutomationAndSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        TrendCategory::ensureDefaultsExist();
        TrendSource::ensureDefaultSourcesExist();
    }

    /** @test */
    public function artisan_commands_and_queue_job_execute_safely_and_prevent_duplicate_scheduled_work()
    {
        Http::fake([
            'hn.algolia.com/*' => Http::response([
                'hits' => [
                    [
                        'objectID' => '555001',
                        'title' => 'AI Coding Adoption in Enterprise Software Engineering',
                        'url' => 'https://example.org/enterprise-ai-1',
                        'points' => 95,
                        'num_comments' => 24,
                        'created_at' => '2026-10-15T10:00:00Z',
                    ],
                ],
            ], 200),
            'www.cisa.gov/*' => Http::response([
                'vulnerabilities' => [
                    [
                        'cveID' => 'CVE-2026-1001',
                        'vendorProject' => 'ExampleVendor',
                        'dateAdded' => '2026-09-10',
                    ],
                    [
                        'cveID' => 'CVE-2026-1002',
                        'vendorProject' => 'ExampleVendor2',
                        'dateAdded' => '2026-09-17',
                    ],
                    [
                        'cveID' => 'CVE-2026-1003',
                        'vendorProject' => 'ExampleVendor3',
                        'dateAdded' => '2026-09-24',
                    ],
                    [
                        'cveID' => 'CVE-2026-1004',
                        'vendorProject' => 'ExampleVendor4',
                        'dateAdded' => '2026-10-01',
                    ],
                    [
                        'cveID' => 'CVE-2026-1005',
                        'vendorProject' => 'ExampleVendor4',
                        'dateAdded' => '2026-10-02',
                    ],
                ],
            ], 200),
        ]);

        // 1. Run trends:collect
        $this->artisan('trends:collect --force')->assertExitCode(0);
        $this->assertGreaterThanOrEqual(5, TrendObservation::count());

        // 2. Run trends:aggregate
        $this->artisan('trends:aggregate')->assertExitCode(0);

        // 3. Run trends:forecast --horizon=3 twice: second run in same week must skip duplicate generation
        $this->artisan('trends:forecast --horizon=3')->assertExitCode(0);
        $countAfterFirst = TrendForecast::where('horizon_months', 3)->count();
        $this->assertEquals(6, $countAfterFirst);

        $this->artisan('trends:forecast --horizon=3')->assertExitCode(0);
        $this->assertEquals(6, TrendForecast::where('horizon_months', 3)->count());

        // 4. Run trends:evaluate
        $this->artisan('trends:evaluate')->assertExitCode(0);

        // 5. Run queue job safely (retry-safe & idempotent)
        $job = new RunTrendIntelligencePipelineJob(false);
        app()->call([$job, 'handle']);
        $this->assertGreaterThanOrEqual(5, TrendObservation::count());
    }

    /** @test */
    public function overlapping_command_is_skipped_when_cache_lock_is_held()
    {
        $lock = Cache::lock('trends:collect:lock', 300);
        $this->assertTrue($lock->get());

        try {
            $this->artisan('trends:collect --force')
                ->expectsOutputToContain('Skipping overlapping execution')
                ->assertExitCode(0);
        } finally {
            $lock->release();
        }
    }

    /** @test */
    public function rss_connector_sanitizes_unsafe_links_and_parses_feed_safely()
    {
        $rssXml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
  <channel>
    <title>Software Engineering Feed</title>
    <item>
      <title>Cloud Cost FinOps Benchmarks in SaaS Engineering</title>
      <link>javascript:alert('xss')</link>
      <guid>rss-item-1</guid>
      <pubDate>Tue, 20 Oct 2026 10:00:00 GMT</pubDate>
      <description>&lt;script&gt;evil()&lt;/script&gt; Enterprise cloud cost optimization insights.</description>
    </item>
  </channel>
</rss>
XML;

        Http::fake([
            'feeds.example.org/*' => Http::response($rssXml, 200, ['Content-Type' => 'application/rss+xml']),
        ]);

        $cat = TrendCategory::where('slug', 'software-company-economics-development-costs')->firstOrFail();
        $rssSource = TrendSource::create([
            'name' => 'Engineering RSS Feed',
            'slug' => 'engineering-rss-feed',
            'connector_type' => 'rss_feed',
            'endpoint_url' => 'https://feeds.example.org/software.xml',
            'default_category_id' => $cat->id,
            'rate_limit_per_minute' => 10,
            'fetch_interval_minutes' => 60,
            'allows_direct_metric_proof' => false,
            'is_active' => true,
        ]);

        $this->artisan("trends:collect --source={$rssSource->slug} --force")->assertExitCode(0);

        $obs = TrendObservation::where('trend_source_id', $rssSource->id)->first();
        $this->assertNotNull($obs);
        // Unsafe javascript: link was replaced with safe endpoint fallback URL
        $this->assertEquals('https://feeds.example.org/software.xml', $obs->original_url);
        // HTML tags stripped from summary
        $this->assertStringNotContainsString('<script>', (string) $obs->summary);
        $this->assertFalse($obs->is_direct_metric);
    }
}

