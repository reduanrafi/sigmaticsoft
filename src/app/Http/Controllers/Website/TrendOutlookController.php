<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\TrendCategory;
use App\Models\TrendForecast;
use App\Models\TrendObservation;
use App\Services\TrendIntelligence\UrlSafetyValidator;
use Illuminate\Http\Request;
use Throwable;

class TrendOutlookController extends Controller
{
    public function __construct(
        protected UrlSafetyValidator $urlValidator
    ) {
    }

    /**
     * Public Global Software Industry Outlook page (/software-industry-outlook).
     */
    public function index(Request $request)
    {
        $selectedHorizon = $request->query('horizon');
        if ($selectedHorizon !== null && !in_array((int) $selectedHorizon, [3, 6, 12], true)) {
            $selectedHorizon = null;
        } else {
            $selectedHorizon = $selectedHorizon !== null ? (int) $selectedHorizon : null;
        }

        $qualifyingCategorySlugs = [];

        try {
            TrendCategory::ensureDefaultsExist();

            $categories = TrendCategory::where('is_active', true)
                ->with(['weeklyMetrics', 'latestWeeklyMetric'])
                ->orderBy('display_order')
                ->get();

            // Only published forecasts are ever retrieved for public pages
            $publishedQuery = TrendForecast::published()
                ->with(['category', 'publicEvaluations'])
                ->orderByDesc('published_at')
                ->orderByDesc('id');

            if ($selectedHorizon !== null) {
                $publishedQuery->where('horizon_months', $selectedHorizon);
            }

            $publishedForecasts = $publishedQuery->get();

            // Sanitize supporting evidence links
            foreach ($publishedForecasts as $forecast) {
                $forecast->supporting_evidence = $this->sanitizeEvidenceList($forecast->supporting_evidence ?? []);
            }

            // Determine which categories have enough useful evidence & published forecasts to warrant a standalone page
            foreach ($categories as $cat) {
                if ($this->categoryHasSufficientPublicEvidence($cat)) {
                    $qualifyingCategorySlugs[$cat->slug] = true;
                }
            }

            // Previous predictions & evaluations log (published or previously published then archived)
            $previousPredictions = TrendForecast::whereIn('status', ['published', 'archived'])
                ->whereNotNull('published_at')
                ->with(['category', 'publicEvaluations'])
                ->orderByDesc('published_at')
                ->limit(20)
                ->get();
        } catch (Throwable $e) {
            // Fallback if DB is not yet migrated or temporarily offline so public page still renders cleanly
            $categories = collect(TrendCategory::defaultCategories())->map(function (array $cat) {
                $obj = new TrendCategory($cat);
                $obj->setRelation('weeklyMetrics', collect());
                $obj->setRelation('latestWeeklyMetric', null);
                return $obj;
            });
            $publishedForecasts = collect();
            $previousPredictions = collect();
        }

        return view('website.pages.software_industry_outlook', compact(
            'categories',
            'publishedForecasts',
            'previousPredictions',
            'qualifyingCategorySlugs',
            'selectedHorizon'
        ));
    }

    /**
     * Public Category Outlook page (/software-industry-outlook/{slug}).
     * Only accessible when enough useful evidence and published forecasts exist (prevents thin pages).
     */
    public function category(string $slug)
    {
        TrendCategory::ensureDefaultsExist();

        $category = TrendCategory::where('slug', $slug)
            ->where('is_active', true)
            ->with(['weeklyMetrics', 'latestWeeklyMetric'])
            ->firstOrFail();

        if (!$this->categoryHasSufficientPublicEvidence($category)) {
            abort(404, 'Category page unavailable: insufficient verified evidence or published forecasts.');
        }

        $publishedForecasts = TrendForecast::published()
            ->where('trend_category_id', $category->id)
            ->with(['publicEvaluations'])
            ->orderBy('horizon_months')
            ->orderByDesc('published_at')
            ->get();

        foreach ($publishedForecasts as $forecast) {
            $forecast->supporting_evidence = $this->sanitizeEvidenceList($forecast->supporting_evidence ?? []);
        }

        $verifiedObservations = TrendObservation::where('trend_category_id', $category->id)
            ->where('relevance_status', 'relevant')
            ->orderByDesc('is_direct_metric')
            ->orderByDesc('published_at')
            ->limit(15)
            ->get()
            ->filter(fn (TrendObservation $obs) => $this->urlValidator->isSafeCitationUrl($obs->original_url));

        $previousPredictions = TrendForecast::where('trend_category_id', $category->id)
            ->whereIn('status', ['published', 'archived'])
            ->whereNotNull('published_at')
            ->with(['publicEvaluations'])
            ->orderByDesc('published_at')
            ->limit(15)
            ->get();

        return view('website.pages.software_industry_outlook_category', compact(
            'category',
            'publishedForecasts',
            'verifiedObservations',
            'previousPredictions'
        ));
    }

    /**
     * Prevent thin pages: a standalone category page requires at least one published forecast,
     * minimum required relevant observations, and at least one weekly metric with sufficient empirical evidence.
     */
    protected function categoryHasSufficientPublicEvidence(TrendCategory $category): bool
    {
        $hasPublishedForecast = TrendForecast::published()
            ->where('trend_category_id', $category->id)
            ->exists();

        if (!$hasPublishedForecast) {
            return false;
        }

        $relevantObsCount = TrendObservation::where('trend_category_id', $category->id)
            ->where('relevance_status', 'relevant')
            ->count();

        if ($relevantObsCount < max(3, (int) $category->min_observations_required)) {
            return false;
        }

        return $category->weeklyMetrics()
            ->where('evidence_sufficiency', 'sufficient')
            ->exists();
    }

    protected function sanitizeEvidenceList(array $evidence): array
    {
        $clean = [];
        foreach ($evidence as $item) {
            if (!is_array($item)) {
                continue;
            }
            $url = $item['url'] ?? null;
            if (!$this->urlValidator->isSafeCitationUrl($url)) {
                continue;
            }
            $clean[] = [
                'title' => (string) ($item['title'] ?? 'Supporting Source'),
                'source_name' => (string) ($item['source_name'] ?? 'Public Source'),
                'url' => $url,
                'published_at' => $item['published_at'] ?? null,
                'metric_value' => $item['metric_value'] ?? null,
                'metric_unit' => $item['metric_unit'] ?? null,
                'evidence_type' => $item['evidence_type'] ?? 'empirical_metric',
                'is_direct_metric' => (bool) ($item['is_direct_metric'] ?? false),
            ];
        }

        return $clean;
    }
}
