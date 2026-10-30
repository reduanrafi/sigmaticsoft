<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendCollectionRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'trend_source_id',
        'triggered_by',
        'triggered_by_user_id',
        'status',
        'started_at',
        'finished_at',
        'items_fetched',
        'items_stored',
        'items_skipped_duplicate',
        'items_rejected_irrelevant',
        'error_count',
        'http_status',
        'duration_ms',
        'summary_notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'items_fetched' => 'integer',
        'items_stored' => 'integer',
        'items_skipped_duplicate' => 'integer',
        'items_rejected_irrelevant' => 'integer',
        'error_count' => 'integer',
        'http_status' => 'integer',
        'duration_ms' => 'integer',
    ];

    public function source()
    {
        return $this->belongsTo(TrendSource::class, 'trend_source_id');
    }

    public function triggeredByUser()
    {
        return $this->belongsTo(User::class, 'triggered_by_user_id');
    }

    public function errors()
    {
        return $this->hasMany(TrendCollectionError::class);
    }

    public function observations()
    {
        return $this->hasMany(TrendObservation::class);
    }
}

