<?php

namespace App\Services\TrendIntelligence;

use App\Models\TrendForecast;
use App\Models\TrendForecastEvaluation;
use App\Models\TrendWeeklyMetric;

class TrendForecastEvaluationService
{
    /**
     * Evaluate a forecast against actual subsequent weekly metrics recorded on or after its target horizon.
     * Never claims a forecast is accurate until evaluated against subsequent outcomes.
     */
    public function evaluateForecast(
        TrendForecast $forecast,
        ?int $userId = null,
        ?string $manualNotes = null
    ): TrendForecastEvaluation {
        $snapshot = $forecast->baseline_snapshot ?? [];
        $baselineValue = isset($snapshot['recent_mean']) && is_numeric($snapshot['recent_mean'])
            ? (float) $snapshot['recent_mean']
            : null;

        // Look for weekly metrics at or after the forecast target_date
        $subsequentMetric = TrendWeeklyMetric::where('trend_category_id', $forecast->trend_category_id)
            ->whereDate('week_end_date', '>=', $forecast->target_date)
            ->where('evidence_sufficiency', 'sufficient')
            ->orderBy('week_start_date', 'asc')
            ->first();

        if (!$subsequentMetric || $forecast->target_date->isFuture()) {
            return TrendForecastEvaluation::create([
                'trend_forecast_id' => $forecast->id,
                'evaluated_by' => $userId,
                'evaluated_at' => now(),
                'outcome_status' => 'pending_horizon',
                'actual_baseline_value' => $baselineValue,
                'actual_outcome_value' => null,
                'actual_percent_change' => null,
                'actual_direction' => null,
                'evaluation_summary' => sprintf(
                    'Forecast horizon (%d months, target date %s) has not yet completed or post-horizon empirical measurements are not yet available. Accuracy is never claimed prior to post-horizon outcome verification.',
                    $forecast->horizon_months,
                    $forecast->target_date->toDateString()
                ),
                'supporting_outcome_evidence' => null,
                'methodology_notes' => $manualNotes ?? 'Automated pre-horizon check: outcome verification pending.',
                'is_public' => true,
            ]);
        }

        $outcomeValue = $subsequentMetric->primary_metric_mean;
        $actualDirection = $subsequentMetric->direction;
        $actualPercentChange = null;

        if ($baselineValue !== null && abs($baselineValue) >= 0.000001 && $outcomeValue !== null) {
            $actualPercentChange = round((($outcomeValue - $baselineValue) / abs($baselineValue)) * 100, 4);
            if ($actualPercentChange >= 5.0) {
                $actualDirection = 'increasing';
            } elseif ($actualPercentChange <= -5.0) {
                $actualDirection = 'decreasing';
            } else {
                $actualDirection = 'stable';
            }
        }

        $outcomeStatus = 'inconclusive';
        if (in_array($forecast->trend_direction, ['increasing', 'decreasing', 'stable'], true) && $actualDirection !== null) {
            if ($forecast->trend_direction === $actualDirection) {
                $outcomeStatus = 'verified_accurate';
            } elseif ($actualDirection === 'stable' || $forecast->trend_direction === 'stable') {
                $outcomeStatus = 'partially_accurate';
            } else {
                $outcomeStatus = 'inaccurate';
            }
        }

        $summary = sprintf(
            'Evaluated against Week %s outcome (ending %s). Forecast predicted direction "%s" from baseline %s; actual post-horizon measurement was %s (%s%% change, direction "%s"). Outcome classification: %s.',
            $subsequentMetric->year_week,
            $subsequentMetric->week_end_date->toDateString(),
            $forecast->trend_direction,
            $baselineValue !== null ? number_format($baselineValue, 2) : 'N/A',
            $outcomeValue !== null ? number_format($outcomeValue, 2) : 'N/A',
            $actualPercentChange !== null ? number_format($actualPercentChange, 2) : 'N/A',
            $actualDirection ?? 'unknown',
            $outcomeStatus
        );

        return TrendForecastEvaluation::create([
            'trend_forecast_id' => $forecast->id,
            'evaluated_by' => $userId,
            'evaluated_at' => now(),
            'outcome_status' => $outcomeStatus,
            'actual_baseline_value' => $baselineValue,
            'actual_outcome_value' => $outcomeValue,
            'actual_percent_change' => $actualPercentChange,
            'actual_direction' => $actualDirection,
            'evaluation_summary' => $summary,
            'supporting_outcome_evidence' => [
                'evaluated_year_week' => $subsequentMetric->year_week,
                'week_end_date' => $subsequentMetric->week_end_date->toDateString(),
                'empirical_observation_count' => $subsequentMetric->empirical_observation_count,
                'independent_source_count' => $subsequentMetric->independent_source_count,
            ],
            'methodology_notes' => $manualNotes ?? 'Evaluated deterministically against post-horizon weekly empirical aggregate.',
            'is_public' => true,
        ]);
    }

    /**
     * Evaluate all published or archived forecasts whose target_date has arrived.
     *
     * @return array<int, TrendForecastEvaluation>
     */
    public function evaluateDueForecasts(): array
    {
        $dueForecasts = TrendForecast::whereIn('status', ['published', 'archived'])
            ->whereDate('target_date', '<=', now()->toDateString())
            ->get();

        $evaluations = [];
        foreach ($dueForecasts as $forecast) {
            if (!$forecast->hasBeenEvaluated()) {
                $evaluations[] = $this->evaluateForecast($forecast);
            }
        }

        return $evaluations;
    }
}

