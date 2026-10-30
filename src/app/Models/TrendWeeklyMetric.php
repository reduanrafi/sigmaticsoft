<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendWeeklyMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'trend_category_id',
        'year_week',
        'week_start_date',
        'week_end_date',
        'observation_count',
        'empirical_observation_count',
        'signal_only_count',
        'independent_source_count',
        'contradictory_observation_count',
        'primary_metric_mean',
        'primary_metric_median',
        'primary_metric_sum',
        'metric_unit',
        'baseline_mean',
        'percent_change_vs_baseline',
        'direction',
        'persistence_weeks',
        'trend_score',
        'evidence_sufficiency',
        'score_breakdown',
        'data_limitations',
        'contradiction_summary',
        'methodology_version',
        'aggregated_at',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'observation_count' => 'integer',
        'empirical_observation_count' => 'integer',
        'signal_only_count' => 'integer',
        'independent_source_count' => 'integer',
        'contradictory_observation_count' => 'integer',
        'primary_metric_mean' => 'float',
        'primary_metric_median' => 'float',
        'primary_metric_sum' => 'float',
        'baseline_mean' => 'float',
        'percent_change_vs_baseline' => 'float',
        'persistence_weeks' => 'integer',
        'trend_score' => 'float',
        'score_breakdown' => 'array',
        'aggregated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(TrendCategory::class, 'trend_category_id');
    }

    public function getDirectionLabelAttribute(): string
    {
        return match ($this->direction) {
            'increasing' => 'Increasing',
            'decreasing' => 'Decreasing',
            'stable' => 'Stable',
            'contradictory' => 'Contradictory Evidence',
            default => 'Insufficient evidence',
        };
    }
}

