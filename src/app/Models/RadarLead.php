<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadarLead extends Model
{
    use HasFactory;

    protected $table = 'radar_leads';

    // Primary key is string (SHA-1 prefix from scraper)
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'source',
        'title',
        'text',
        'url',
        'author',
        'created_at_source',
        'found_at',
        'heuristic_score',
        'ai_score',
        'problem_summary',
        'service_fit',
        'budget_signal',
        'suggested_reply',
        'status',
        'notes',
        'assigned_to',
        'last_action_at',
    ];

    protected $casts = [
        'heuristic_score' => 'integer',
        'ai_score' => 'integer',
        'found_at' => 'datetime',
        'last_action_at' => 'datetime',
    ];

    /**
     * Scope for filtering by status
     */
    public function scopeStatus($query, $status)
    {
        if (!empty($status) && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope for high priority leads (Score 8+)
     */
    public function scopeHighPriority($query)
    {
        return $query->where('ai_score', '>=', 8);
    }

    /**
     * Scope for service fit
     */
    public function scopeServiceFit($query, $service)
    {
        if (!empty($service) && $service !== 'all') {
            return $query->where('service_fit', $service);
        }
        return $query;
    }

    /**
     * Helper to mark lead as initiated
     */
    public function markAsInitiated(?string $notes = null): self
    {
        $this->status = 'initiated';
        $this->last_action_at = now();
        if ($notes) {
            $this->notes = ($this->notes ? $this->notes . "\n" : '') . "[" . now()->format('Y-m-d H:i') . "] " . $notes;
        }
        $this->save();
        return $this;
    }

    /**
     * Helper to mark lead as contacted
     */
    public function markAsContacted(?string $notes = null): self
    {
        $this->status = 'contacted';
        $this->last_action_at = now();
        if ($notes) {
            $this->notes = ($this->notes ? $this->notes . "\n" : '') . "[" . now()->format('Y-m-d H:i') . "] " . $notes;
        }
        $this->save();
        return $this;
    }
}
