<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\TrendCategory;
use App\Models\TrendCollectionError;
use App\Models\TrendCollectionRun;
use App\Models\TrendForecast;
use App\Models\TrendForecastEvaluation;
use App\Models\TrendObservation;
use App\Models\TrendSource;
use App\Models\TrendWeeklyMetric;
use App\Services\TrendIntelligence\TrendAnalysisService;
use App\Services\TrendIntelligence\TrendCollectionService;
use App\Services\TrendIntelligence\TrendForecastEvaluationService;
use App\Services\TrendIntelligence\TrendForecastService;
use App\Services\TrendIntelligence\UrlSafetyValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TrendIntelligenceAdminController extends Controller
{
    public function __construct(
        protected TrendCollectionService $collectionService,
        protected TrendAnalysisService $analysisService,
        protected TrendForecastService $forecastService,
        protected TrendForecastEvaluationService $evaluationService,
        protected UrlSafetyValidator $urlValidator
    ) {
    }

    /**
     * Render the Trend Intelligence Admin workspace.
     */
    public function index(Request $request)
    {
        TrendCategory::ensureDefaultsExist();
        TrendSource::ensureDefaultSourcesExist();

        $categories = TrendCategory::with(['latestWeeklyMetric', 'weeklyMetrics'])
            ->orderBy('display_order')
            ->get();

        $sources = TrendSource::with('defaultCategory')
            ->withCount(['observations', 'collectionRuns', 'collectionErrors'])
            ->orderBy('name')
            ->get();

        $recentRuns = TrendCollectionRun::with(['source', 'triggeredByUser'])
            ->orderByDesc('started_at')
            ->limit(15)
            ->get();

        $recentErrors = TrendCollectionError::with(['source', 'run'])
            ->orderByDesc('occurred_at')
            ->limit(20)
            ->get();

        $observationsQuery = TrendObservation::with(['source', 'category'])
            ->orderByDesc('published_at');

        if ($request->filled('category_id')) {
            $observationsQuery->where('trend_category_id', (int) $request->input('category_id'));
        }
        if ($request->filled('direct_only') && $request->input('direct_only') === '1') {
            $observationsQuery->where('is_direct_metric', true);
        }

        $observations = $observationsQuery->paginate(15, ['*'], 'obs_page');

        $forecastsQuery = TrendForecast::with(['category', 'approver', 'publisher', 'latestEvaluation'])
            ->orderByDesc('generated_at')
            ->orderByDesc('id');

        if ($request->filled('forecast_status')) {
            $forecastsQuery->where('status', $request->input('forecast_status'));
        }

        $forecasts = $forecastsQuery->paginate(15, ['*'], 'fc_page');

        $evaluations = TrendForecastEvaluation::with(['forecast.category', 'evaluator'])
            ->orderByDesc('evaluated_at')
            ->limit(15)
            ->get();

        $stats = [
            'categories_count' => $categories->count(),
            'active_sources_count' => $sources->where('is_active', true)->count(),
            'observations_count' => TrendObservation::count(),
            'empirical_observations_count' => TrendObservation::where('is_direct_metric', true)->count(),
            'draft_forecasts_count' => TrendForecast::where('status', 'draft')->count(),
            'approved_forecasts_count' => TrendForecast::where('status', 'approved')->count(),
            'published_forecasts_count' => TrendForecast::where('status', 'published')->count(),
            'recent_errors_count' => TrendCollectionError::count(),
        ];

        $connectorTypes = $this->collectionService->getSupportedConnectorTypes();

        return view('admin_portal.trend_intelligence.index', compact(
            'categories',
            'sources',
            'recentRuns',
            'recentErrors',
            'observations',
            'forecasts',
            'evaluations',
            'stats',
            'connectorTypes'
        ));
    }

    /**
     * Store a new Trend Source after validating endpoint URL safety.
     */
    public function storeSource(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'connector_type' => 'required|in:hn_algolia,public_json_api,rss_feed',
            'endpoint_url' => 'required|url|max:1000',
            'default_category_id' => 'required|exists:trend_categories,id',
            'description' => 'nullable|string|max:1000',
            'terms_summary' => 'nullable|string|max:1000',
            'rate_limit_per_minute' => 'required|integer|min:1|max:120',
            'fetch_interval_minutes' => 'required|integer|min:5|max:10080',
            'trust_weight' => 'required|numeric|min:0.10|max:1.00',
            'allows_direct_metric_proof' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $safeUrl = $this->urlValidator->assertSafeForFetch($validated['endpoint_url']);
        } catch (InvalidArgumentException $e) {
            return redirect()->back()
                ->withErrors(['endpoint_url' => 'Unsafe or disallowed endpoint URL: ' . $e->getMessage()])
                ->withInput();
        }

        $slug = Str::slug($validated['name']);
        $count = TrendSource::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $host = parse_url($safeUrl, PHP_URL_HOST) ?: null;

        // Discussion feeds (hn_algolia) can never be direct metric proof per Phase 3 rules
        $allowsDirectProof = $validated['connector_type'] === 'hn_algolia'
            ? false
            : $request->boolean('allows_direct_metric_proof');

        $source = TrendSource::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'connector_type' => $validated['connector_type'],
            'endpoint_url' => $safeUrl,
            'source_domain' => $host,
            'default_category_id' => $validated['default_category_id'],
            'description' => $validated['description'] ?? null,
            'terms_summary' => $validated['terms_summary'] ?? null,
            'rate_limit_per_minute' => $validated['rate_limit_per_minute'],
            'fetch_interval_minutes' => $validated['fetch_interval_minutes'],
            'trust_weight' => $validated['trust_weight'],
            'allows_direct_metric_proof' => $allowsDirectProof,
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLog::log('trend_source_created', "Created trend source: {$source->name}", $source);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Trend source '{$source->name}' configured successfully.");
    }

    /**
     * Update an existing Trend Source.
     */
    public function updateSource(Request $request, TrendSource $source)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'endpoint_url' => 'required|url|max:1000',
            'default_category_id' => 'required|exists:trend_categories,id',
            'terms_summary' => 'nullable|string|max:1000',
            'rate_limit_per_minute' => 'required|integer|min:1|max:120',
            'fetch_interval_minutes' => 'required|integer|min:5|max:10080',
            'trust_weight' => 'required|numeric|min:0.10|max:1.00',
            'allows_direct_metric_proof' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $safeUrl = $this->urlValidator->assertSafeForFetch($validated['endpoint_url']);
        } catch (InvalidArgumentException $e) {
            return redirect()->back()
                ->withErrors(['endpoint_url' => 'Unsafe or disallowed endpoint URL: ' . $e->getMessage()]);
        }

        $allowsDirectProof = $source->connector_type === 'hn_algolia'
            ? false
            : $request->boolean('allows_direct_metric_proof');

        $source->update([
            'name' => $validated['name'],
            'endpoint_url' => $safeUrl,
            'source_domain' => parse_url($safeUrl, PHP_URL_HOST) ?: $source->source_domain,
            'default_category_id' => $validated['default_category_id'],
            'terms_summary' => $validated['terms_summary'] ?? $source->terms_summary,
            'rate_limit_per_minute' => $validated['rate_limit_per_minute'],
            'fetch_interval_minutes' => $validated['fetch_interval_minutes'],
            'trust_weight' => $validated['trust_weight'],
            'allows_direct_metric_proof' => $allowsDirectProof,
            'is_active' => $request->boolean('is_active'),
        ]);

        ActivityLog::log('trend_source_updated', "Updated trend source: {$source->name}", $source);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Trend source '{$source->name}' updated.");
    }

    /**
     * Update a Trend Category configuration.
     */
    public function updateCategory(Request $request, TrendCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'primary_metric_unit' => 'required|string|max:64',
            'min_observations_required' => 'required|integer|min:2|max:100',
            'min_independent_sources' => 'required|integer|min:1|max:20',
            'baseline_weeks' => 'required|integer|min:1|max:52',
            'recent_weeks' => 'required|integer|min:1|max:52',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'primary_metric_unit' => $validated['primary_metric_unit'],
            'min_observations_required' => $validated['min_observations_required'],
            'min_independent_sources' => $validated['min_independent_sources'],
            'baseline_weeks' => $validated['baseline_weeks'],
            'recent_weeks' => $validated['recent_weeks'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLog::log('trend_category_updated', "Updated trend category: {$category->name}", $category);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Category '{$category->name}' updated.");
    }

    /**
     * Run manual collection for one source or all active sources.
     */
    public function collect(Request $request)
    {
        $sourceId = $request->input('trend_source_id');

        if ($sourceId) {
            $source = TrendSource::findOrFail($sourceId);
            $run = $this->collectionService->collectSource($source, 'manual', auth()->id(), false);

            ActivityLog::log('trend_collection_manual', "Ran collection for {$source->name} (Status: {$run->status}, Stored: {$run->items_stored})", $source);

            if ($run->status === 'failed') {
                return redirect()->route('admin.trend-intelligence.index')
                    ->with('error', "Collection failed for '{$source->name}'. Review collection errors for details.");
            }

            return redirect()->route('admin.trend-intelligence.index')
                ->with('success', "Collected '{$source->name}': {$run->items_stored} stored, {$run->items_skipped_duplicate} duplicates skipped.");
        }

        $runs = $this->collectionService->collectAllActive('manual', auth()->id(), false);
        $totalStored = collect($runs)->sum('items_stored');

        ActivityLog::log('trend_collection_all', "Ran collection for all active sources (Total stored: {$totalStored})");

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', sprintf('Executed %d source collection run(s); %d new observation(s) stored.', count($runs), $totalStored));
    }

    /**
     * Trigger weekly metric aggregation across categories.
     */
    public function aggregate(Request $request)
    {
        if ($request->filled('trend_category_id')) {
            $category = TrendCategory::findOrFail($request->input('trend_category_id'));
            $metrics = $this->analysisService->analyzeCategory($category);
            ActivityLog::log('trend_metrics_aggregated', "Aggregated weekly metrics for {$category->name}", $category);

            return redirect()->route('admin.trend-intelligence.index')
                ->with('success', "Aggregated {$metrics->count()} weekly metric record(s) for '{$category->name}'.");
        }

        $results = $this->analysisService->analyzeAllCategories();
        ActivityLog::log('trend_metrics_aggregated_all', 'Aggregated weekly metrics for all active categories');

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', sprintf('Aggregated weekly metrics across %d active categories.', count($results)));
    }

    /**
     * Generate draft forecast(s) for a category and horizon.
     */
    public function generateForecast(Request $request)
    {
        $validated = $request->validate([
            'trend_category_id' => 'required|exists:trend_categories,id',
            'horizon_months' => 'required|in:3,6,12,all',
        ]);

        $category = TrendCategory::findOrFail($validated['trend_category_id']);

        if ($validated['horizon_months'] === 'all') {
            $forecasts = $this->forecastService->generateAllHorizonsForCategory($category);
            ActivityLog::log('trend_forecast_generated_all', "Generated 3, 6, and 12 month draft forecasts for {$category->name}", $category);

            return redirect()->route('admin.trend-intelligence.index')
                ->with('success', "Generated 3, 6, and 12-month draft forecasts for '{$category->name}'.");
        }

        $forecast = $this->forecastService->generateDraftForecast($category, (int) $validated['horizon_months']);
        ActivityLog::log('trend_forecast_generated', "Generated {$forecast->horizon_months}m draft forecast {$forecast->forecast_code}", $forecast);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Draft forecast {$forecast->forecast_code} ({$forecast->horizon_months} months) generated.");
    }

    /**
     * Edit an existing forecast's narrative and editorial notes.
     */
    public function updateForecast(Request $request, TrendForecast $forecast)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'what_is_happening_now' => 'required|string',
            'what_may_happen_next' => 'required|string',
            'why_generated' => 'required|string',
            'uncertainties_and_alternatives' => 'required|string',
            'data_limitations' => 'nullable|string',
            'editorial_notes' => 'nullable|string',
        ]);

        $forecast->update($validated);
        ActivityLog::log('trend_forecast_updated', "Updated forecast {$forecast->forecast_code}", $forecast);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Forecast {$forecast->forecast_code} updated.");
    }

    /**
     * Approve a draft or unpublished forecast for publication readiness.
     */
    public function approveForecast(TrendForecast $forecast)
    {
        if (!in_array($forecast->status, ['draft', 'unpublished'], true)) {
            return redirect()->route('admin.trend-intelligence.index')
                ->with('error', "Only draft or unpublished forecasts can be marked approved.");
        }

        $forecast->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        ActivityLog::log('trend_forecast_approved', "Approved forecast {$forecast->forecast_code}", $forecast);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Forecast {$forecast->forecast_code} approved for publication.");
    }

    /**
     * Publish an approved forecast to the public website.
     * Protects against accidental publication by requiring prior 'approved' status and confirmation flag.
     */
    public function publishForecast(Request $request, TrendForecast $forecast)
    {
        $request->validate([
            'confirm_publish' => 'required|accepted',
        ]);

        if ($forecast->status !== 'approved') {
            return redirect()->route('admin.trend-intelligence.index')
                ->with('error', "Accidental publication prevented: Forecast {$forecast->forecast_code} must be in 'approved' state before publishing.");
        }

        if (empty($forecast->supporting_evidence) || count($forecast->supporting_evidence) === 0) {
            return redirect()->route('admin.trend-intelligence.index')
                ->with('error', "Cannot publish forecast {$forecast->forecast_code} without supporting evidence citations.");
        }

        $forecast->update([
            'status' => 'published',
            'published_by' => auth()->id(),
            'published_at' => now(),
        ]);

        ActivityLog::log('trend_forecast_published', "Published forecast {$forecast->forecast_code} to public outlook", $forecast);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Forecast {$forecast->forecast_code} is now published on /software-industry-outlook.");
    }

    /**
     * Unpublish a published forecast (removes from public display while preserving record).
     */
    public function unpublishForecast(TrendForecast $forecast)
    {
        $forecast->update([
            'status' => 'unpublished',
            'unpublished_at' => now(),
        ]);

        ActivityLog::log('trend_forecast_unpublished', "Unpublished forecast {$forecast->forecast_code}", $forecast);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Forecast {$forecast->forecast_code} has been unpublished and hidden from public view.");
    }

    /**
     * Archive a forecast (preserves in historical archive).
     */
    public function archiveForecast(TrendForecast $forecast)
    {
        $forecast->update([
            'status' => 'archived',
            'archived_at' => now(),
        ]);

        ActivityLog::log('trend_forecast_archived', "Archived forecast {$forecast->forecast_code}", $forecast);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Forecast {$forecast->forecast_code} archived.");
    }

    /**
     * Evaluate a forecast against subsequent outcomes.
     */
    public function evaluateForecast(Request $request, TrendForecast $forecast)
    {
        $validated = $request->validate([
            'methodology_notes' => 'nullable|string|max:1000',
        ]);

        $evaluation = $this->evaluationService->evaluateForecast(
            $forecast,
            auth()->id(),
            $validated['methodology_notes'] ?? null
        );

        ActivityLog::log('trend_forecast_evaluated', "Evaluated forecast {$forecast->forecast_code}: {$evaluation->outcome_status}", $forecast);

        return redirect()->route('admin.trend-intelligence.index')
            ->with('success', "Forecast {$forecast->forecast_code} evaluation recorded ({$evaluation->outcome_status}).");
    }
}

