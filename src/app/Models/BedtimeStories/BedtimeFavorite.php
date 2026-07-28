<?php

namespace App\Models\BedtimeStories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BedtimeFavorite extends Model
{
    protected $table = 'bedtime_favorites';

    protected $fillable = ['user_id', 'story_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function story()
    {
        return $this->belongsTo(BedtimeStory::class, 'story_id');
    }
}
