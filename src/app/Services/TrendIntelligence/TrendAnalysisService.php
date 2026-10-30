<?php

namespace App\Services\TrendIntelligence;

use App\Models\TrendCategory;
use App\Models\TrendObservation;
use App\Models\TrendWeeklyMetric;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TrendAnalysisService
{
    public const METHODOLOGY_VERSION = 'v1.0-deterministic';

    /**
     * Aggregate weekly metrics and evaluate trend direction/score for a single category.
     *
     * @return Collection<int, TrendWeeklyMetric>
     */
    public function analyzeCategory(TrendCategory $category): Collection
    {
        $observations = TrendObservation::where('trend_category_id', $category->id)
            ->whereIn('relevance_status', ['relevant', 'marginal'])
            ->with('source')
            ->orderBy('published_at', 'asc')
            ->get();

        if ($observations->isEmpty()) {
            // Record a current-week placeholder showing Insufficient evidence
            $now = Carbon::now();
            $weekStart = $now->copy()->startOfWeek(Carbon::MONDAY);
            $weekEnd = $now->copy()->endOfWeek(Carbon::SUNDAY);
            $yearWeek = $weekStart->format('o-\WW');

            $metric = TrendWeeklyMetric::updateOrCreate(
                [
                    'trend_category_id' => $category->id,
                    'year_week' => $yearWeek,
                ],
                [
                    'week_start_date' => $weekStart->toDateString(),
                    'week_end_date' => $weekEnd->toDateString(),
                    'observation_count' => 0,
                    'empirical_observation_count' => 0,
                    'signal_only_count' => 0,
                    'independent_source_count' => 0,
                    'contradictory_observation_count' => 0,
                    'primary_metric_mean' => null,
                    'primary_metric_median' => null,
                    'primary_metric_sum' => null,
                    'metric_unit' => $category->primary_metric_unit,
                    'baseline_mean' => null,
                    'percent_change_vs_baseline' => null,
                    'direction' => 'insufficient_evidence',
                    'persistence_weeks' => 0,
                    'trend_score' => null,
                    'evidence_sufficiency' => 'insufficient_evidence',
                    'score_breakdown' => [
                        'rule_version' => self::METHODOLOGY_VERSION,
                        'status' => 'Insufficient evidence',
                        'reason' => 'No relevant observations stored for this category.',
                    ],
                    'data_limitations' => 'Insufficient evidence: zero relevant observations recorded for this trend category.',
                    'contradiction_summary' => null,
                    'methodology_version' => self::METHODOLOGY_VERSION,
                    'aggregated_at' => now(),
                ]
            );

            return collect([$metric]);
        }

        // Group observations by ISO week (YYYY-Www)
        $groupedByWeek = $observations->groupBy(function (TrendObservation $obs) {
            return $obs->published_at->copy()->startOfWeek(Carbon::MONDAY)->format('o-\WW');
        })->sortKeys();

        $weeklySnapshots = [];
        foreach ($groupedByWeek as $yearWeek => $weekObs) {
            /** @var Collection<int, TrendObservation> $weekObs */
            $firstDate = $weekObs->first()->published_at->copy();
            $weekStart = $firstDate->copy()->startOfWeek(Carbon::MONDAY);
            $weekEnd = $firstDate->copy()->endOfWeek(Carbon::SUNDAY);

            $empiricalObs = $weekObs->filter(fn(TrendObservation $o) => $o->qualifiesAsDirectEmpiricalEvidence());
            $signalOnlyObs = $weekObs->reject(fn(TrendObservation $o) => $o->qualifiesAsDirectEmpiricalEvidence());
            $contradictoryObs = $weekObs->filter(fn(TrendObservation $o) => (bool) $o->is_contradictory);

            // Filter empirical observations to comparable unit (category primary unit or dominant unit)
            $comparableEmpirical = $empiricalObs->filter(function (TrendObservation $o) use ($category) {
                return !$o->metric_unit || !$category->primary_metric_unit || $o->metric_unit === $category->primary_metric_unit;
            });
            if ($comparableEmpirical->isEmpty() && $empiricalObs->isNotEmpty()) {
                $comparableEmpirical = $empiricalObs;
            }

            $values = $comparableEmpirical->pluck('metric_value')
                ->filter(fn($v) => $v !== null && is_numeric($v))
                ->map(fn($v) => (float) $v)
                ->values();

            $mean = $values->isNotEmpty() ? round($values->avg(), 4) : null;
            $median = $values->isNotEmpty() ? round((float) $values->median(), 4) : null;
            $sum = $values->isNotEmpty() ? round($values->sum(), 4) : null;

            $independentSources = $weekObs->map(function (TrendObservation $o) {
                return $o->source?->source_domain ?: ('source_' . $o->trend_source_id);
            })->unique()->count();

            $weeklySnapshots[$yearWeek] = [
                'year_week' => $yearWeek,
                'week_start_date' => $weekStart->toDateString(),
                'week_end_date' => $weekEnd->toDateString(),
                'observation_count' => $weekObs->count(),
                'empirical_observation_count' => $comparableEmpirical->count(),
                'signal_only_count' => $signalOnlyObs->count(),
                'independent_source_count' => $independentSources,
                'contradictory_observation_count' => $contradictoryObs->count(),
                'contradictory_notes' => $contradictoryObs->pluck('contradiction_notes')->filter()->implode(' | '),
                'primary_metric_mean' => $mean,
                'primary_metric_median' => $median,
                'primary_metric_sum' => $sum,
                'metric_unit' => $category->primary_metric_unit,
            ];
        }

        $baselineWindowSize = max(1, (int) $category->baseline_weeks);
        $minObsRequired = max(2, (int) $category->min_observations_required);
        $minSourcesRequired = max(1, (int) $category->min_independent_sources);

        $keys = array_keys($weeklySnapshots);
        $savedMetrics = collect();
        $priorDirections = [];

        foreach ($keys as $index => $yearWeek) {
            $current = $weeklySnapshots[$yearWeek];

            // Gather prior weeks with empirical measurements as baseline
            $priorEmpiricalWeeks = [];
            $totalEmpiricalObsSoFar = $current['empirical_observation_count'];
            $distinctSourcesWindow = $current['independent_source_count'];

            for ($i = $index - 1; $i >= 0 && count($priorEmpiricalWeeks) < $baselineWindowSize; $i--) {
                $candidate = $weeklySnapshots[$keys[$i]];
                $totalEmpiricalObsSoFar += $candidate['empirical_observation_count'];
                $distinctSourcesWindow = max($distinctSourcesWindow, $candidate['independent_source_count']);
                if ($candidate['primary_metric_mean'] !== null && $candidate['empirical_observation_count'] > 0) {
                    $priorEmpiricalWeeks[] = $candidate['primary_metric_mean'];
                }
            }

            $baselineMean = count($priorEmpiricalWeeks) > 0
                ? round(array_sum($priorEmpiricalWeeks) / count($priorEmpiricalWeeks), 4)
                : null;

            $limitations = [];
            $contradictionSummary = null;

            if ($current['contradictory_observation_count'] > 0) {
                $contradictionSummary = sprintf(
                    '%d observation(s) in week %s reported contradictory or diverging signals.%s',
                    $current['contradictory_observation_count'],
                    $yearWeek,
                    $current['contradictory_notes'] ? ' Notes: ' . $current['contradictory_notes'] : ''
                );
                $limitations[] = 'Contains contradictory evidence across observations.';
            }

            if ($current['signal_only_count'] > 0) {
                $limitations[] = sprintf(
                    '%d indirect signal(s) (article/discussion/repository activity) were excluded from quantitative metric calculation per non-proof policy.',
                    $current['signal_only_count']
                );
            }

            if ($current['independent_source_count'] < 2) {
                $limitations[] = 'Observations in this period originate from a single source domain; independent multi-source corroboration is limited.';
            }

            // Determine sufficiency and direction
            $direction = 'insufficient_evidence';
            $evidenceSufficiency = 'insufficient_evidence';
            $percentChange = null;
            $trendScore = null;
            $persistenceWeeks = 0;
            $scoreBreakdown = [
                'rule_version' => self::METHODOLOGY_VERSION,
            ];

            if ($current['empirical_observation_count'] === 0) {
                if ($current['signal_only_count'] > 0) {
                    $evidenceSufficiency = 'signal_only_no_direct_proof';
                    $limitations[] = 'Insufficient evidence: only article counts, discussion activity, or repository activity were recorded. These are never treated as direct proof of industry-wide change.';
                } else {
                    $limitations[] = 'Insufficient evidence: no quantitative empirical observations recorded in this week.';
                }
                $scoreBreakdown['status'] = 'Insufficient evidence';
                $scoreBreakdown['reason'] = 'Zero direct empirical observations in week.';
            } elseif ($totalEmpiricalObsSoFar < $minObsRequired) {
                $limitations[] = "Insufficient evidence: cumulative empirical observations ({$totalEmpiricalObsSoFar}) are below the minimum required threshold ({$minObsRequired}).";
                $scoreBreakdown['status'] = 'Insufficient evidence';
                $scoreBreakdown['reason'] = 'Below minimum empirical observation threshold.';
            } elseif ($baselineMean === null) {
                $limitations[] = 'Insufficient evidence: no prior historical baseline weeks available for comparison.';
                $scoreBreakdown['status'] = 'Insufficient evidence';
                $scoreBreakdown['reason'] = 'Missing prior historical baseline.';
            } elseif (abs($baselineMean) < 0.000001) {
                $limitations[] = 'Insufficient evidence: historical baseline mean is zero (0.0000); relative percentage change is undefined.';
                $scoreBreakdown['status'] = 'Insufficient evidence';
                $scoreBreakdown['reason'] = 'Zero historical baseline prevents valid relative percentage calculation.';
            } elseif ($distinctSourcesWindow < $minSourcesRequired) {
                $limitations[] = "Insufficient evidence: fewer than {$minSourcesRequired} independent sources.";
                $scoreBreakdown['status'] = 'Insufficient evidence';
                $scoreBreakdown['reason'] = 'Insufficient independent sources.';
            } else {
                $evidenceSufficiency = 'sufficient';
                $percentChange = round((($current['primary_metric_mean'] - $baselineMean) / abs($baselineMean)) * 100, 4);

                $contradictionRatio = $current['observation_count'] > 0
                    ? ($current['contradictory_observation_count'] / $current['observation_count'])
                    : 0.0;

                if ($contradictionRatio >= 0.35 && $current['contradictory_observation_count'] > 0) {
                    $direction = 'contradictory';
                    $persistenceWeeks = 1;
                } elseif ($percentChange >= 5.0) {
                    $direction = 'increasing';
                } elseif ($percentChange <= -5.0) {
                    $direction = 'decreasing';
                } else {
                    $direction = 'stable';
                }

                if (in_array($direction, ['increasing', 'decreasing', 'stable'], true)) {
                    $persistenceWeeks = 1;
                    for ($p = count($priorDirections) - 1; $p >= 0; $p--) {
                        if ($priorDirections[$p] === $direction) {
                            $persistenceWeeks++;
                        } else {
                            break;
                        }
                    }
                }

                // Transparent deterministic score calculation (-100 to +100)
                $sign = $percentChange > 0 ? 1.0 : ($percentChange < 0 ? -1.0 : 0.0);
                $magnitudeComponent = round(max(-60.0, min(60.0, $percentChange * 1.2)), 2);
                $persistenceComponent = $direction === 'stable'
                    ? 0.0
                    : round($sign * min($persistenceWeeks * 6.0, 20.0), 2);
                $corroborationComponent = $direction === 'stable'
                    ? 0.0
                    : round($sign * min(max(0, $current['independent_source_count'] - 1) * 7.5, 15.0), 2);

                $rawScore = $magnitudeComponent + $persistenceComponent + $corroborationComponent;
                $contradictionPenalty = round(min($current['contradictory_observation_count'] * 10.0, 30.0), 2);

                if ($rawScore > 0) {
                    $rawScore = max(0.0, $rawScore - $contradictionPenalty);
                } elseif ($rawScore < 0) {
                    $rawScore = min(0.0, $rawScore + $contradictionPenalty);
                }

                $trendScore = round(max(-100.0, min(100.0, $rawScore)), 2);

                $scoreBreakdown = [
                    'rule_version' => self::METHODOLOGY_VERSION,
                    'status' => 'Calculated',
                    'current_weekly_mean' => $current['primary_metric_mean'],
                    'historical_baseline_mean' => $baselineMean,
                    'baseline_weeks_used' => count($priorEmpiricalWeeks),
                    'percent_change_vs_baseline' => $percentChange,
                    'magnitude_component' => $magnitudeComponent,
                    'persistence_weeks' => $persistenceWeeks,
                    'persistence_component' => $persistenceComponent,
                    'independent_sources' => $current['independent_source_count'],
                    'corroboration_component' => $corroborationComponent,
                    'contradiction_penalty' => $contradictionPenalty,
                    'final_trend_score' => $trendScore,
                    'disclaimer' => 'Deterministic rule-based index (-100 to +100). Never interpret as a calibrated statistical probability.',
                ];
            }

            $priorDirections[] = $direction;

            $metricRecord = TrendWeeklyMetric::updateOrCreate(
                [
                    'trend_category_id' => $category->id,
                    'year_week' => $yearWeek,
                ],
                [
                    'week_start_date' => $current['week_start_date'],
                    'week_end_date' => $current['week_end_date'],
                    'observation_count' => $current['observation_count'],
                    'empirical_observation_count' => $current['empirical_observation_count'],
                    'signal_only_count' => $current['signal_only_count'],
                    'independent_source_count' => $current['independent_source_count'],
                    'contradictory_observation_count' => $current['contradictory_observation_count'],
                    'primary_metric_mean' => $current['primary_metric_mean'],
                    'primary_metric_median' => $current['primary_metric_median'],
                    'primary_metric_sum' => $current['primary_metric_sum'],
                    'metric_unit' => $current['metric_unit'],
                    'baseline_mean' => $baselineMean,
                    'percent_change_vs_baseline' => $percentChange,
                    'direction' => $direction,
                    'persistence_weeks' => $persistenceWeeks,
                    'trend_score' => $trendScore,
                    'evidence_sufficiency' => $evidenceSufficiency,
                    'score_breakdown' => $scoreBreakdown,
                    'data_limitations' => !empty($limitations) ? implode(' ', $limitations) : null,
                    'contradiction_summary' => $contradictionSummary,
                    'methodology_version' => self::METHODOLOGY_VERSION,
                    'aggregated_at' => now(),
                ]
            );

            $savedMetrics->push($metricRecord);
        }

        return $savedMetrics;
    }

    /**
     * Analyze all active trend categories.
     *
     * @return array<string, Collection<int, TrendWeeklyMetric>>
     */
    public function analyzeAllCategories(): array
    {
        TrendCategory::ensureDefaultsExist();

        $results = [];
        $categories = TrendCategory::where('is_active', true)->orderBy('display_order')->get();

        foreach ($categories as $category) {
            $results[$category->slug] = $this->analyzeCategory($category);
        }

        return $results;
    }
}

