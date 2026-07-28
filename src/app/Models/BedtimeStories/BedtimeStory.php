<?php

namespace App\Models\BedtimeStories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedtimeStory extends Model
{
    use HasFactory;

    protected $table = 'bedtime_stories';

    protected $fillable = [
        'title',
        'content',
        'audio_url',
        'age_group',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(BedtimeCategory::class, 'category_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'bedtime_favorites', 'story_id', 'user_id');
    }

    public function progress()
    {
        return $this->hasMany(BedtimeProgress::class, 'story_id');
    }
}
