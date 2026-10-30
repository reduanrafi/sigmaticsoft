<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendForecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'forecast_code',
        'trend_category_id',
        'horizon_months',
        'title',
        'slug',
        'trend_direction',
        'internal_trend_score',
        'confidence_level',
        'confidence_justification',
        'what_is_happening_now',
        'what_may_happen_next',
        'why_generated',
        'uncertainties_and_alternatives',
        'data_limitations',
        'supporting_evidence',
        'baseline_snapshot',
        'target_date',
        'methodology_version',
        'status',
        'generated_at',
        'approved_by',
        'approved_at',
        'published_by',
        'published_at',
        'unpublished_at',
        'archived_at',
        'editorial_notes',
    ];

    protected $hidden = [
        'editorial_notes',
    ];

    protected $casts = [
        'horizon_months' => 'integer',
        'internal_trend_score' => 'float',
        'supporting_evidence' => 'array',
        'baseline_snapshot' => 'array',
        'target_date' => 'date',
        'generated_at' => 'datetime',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
        'unpublished_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(TrendCategory::class, 'trend_category_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function evaluations()
    {
        return $this->hasMany(TrendForecastEvaluation::class)->orderByDesc('evaluated_at');
    }

    public function publicEvaluations()
    {
        return $this->hasMany(TrendForecastEvaluation::class)
            ->where('is_public', true)
            ->orderByDesc('evaluated_at');
    }

    public function latestEvaluation()
    {
        return $this->hasOne(TrendForecastEvaluation::class)->latestOfMany('evaluated_at');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at !== null;
    }

    public function hasBeenEvaluated(): bool
    {
        return $this->evaluations()
            ->whereIn('outcome_status', ['verified_accurate', 'partially_accurate', 'inaccurate', 'inconclusive'])
            ->exists();
    }
}

