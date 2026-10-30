<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendForecastEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trend_forecast_id',
        'evaluated_by',
        'evaluated_at',
        'outcome_status',
        'actual_baseline_value',
        'actual_outcome_value',
        'actual_percent_change',
        'actual_direction',
        'evaluation_summary',
        'supporting_outcome_evidence',
        'methodology_notes',
        'is_public',
    ];

    protected $casts = [
        'evaluated_at' => 'datetime',
        'actual_baseline_value' => 'float',
        'actual_outcome_value' => 'float',
        'actual_percent_change' => 'float',
        'supporting_outcome_evidence' => 'array',
        'is_public' => 'boolean',
    ];

    public function forecast()
    {
        return $this->belongsTo(TrendForecast::class, 'trend_forecast_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }

    public function getOutcomeLabelAttribute(): string
    {
        return match ($this->outcome_status) {
            'verified_accurate' => 'Direction Verified vs Subsequent Outcome',
            'partially_accurate' => 'Partially Consistent with Subsequent Outcome',
            'inaccurate' => 'Did Not Match Subsequent Outcome',
            'inconclusive' => 'Inconclusive Subsequent Data',
            default => 'Pending Horizon Completion',
        };
    }
}

