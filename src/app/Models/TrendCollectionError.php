<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendCollectionError extends Model
{
    use HasFactory;

    protected $fillable = [
        'trend_collection_run_id',
        'trend_source_id',
        'error_type',
        'error_code',
        'message',
        'context',
        'occurred_at',
    ];

    protected $casts = [
        'context' => 'array',
        'occurred_at' => 'datetime',
    ];

    public function run()
    {
        return $this->belongsTo(TrendCollectionRun::class, 'trend_collection_run_id');
    }

    public function source()
    {
        return $this->belongsTo(TrendSource::class, 'trend_source_id');
    }
}

