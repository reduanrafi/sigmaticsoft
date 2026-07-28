<?php

namespace App\Models\BedtimeStories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedtimeCategory extends Model
{
    use HasFactory;

    protected $table = 'bedtime_categories';

    protected $fillable = ['name'];

    public function stories()
    {
        return $this->hasMany(BedtimeStory::class, 'category_id');
    }
}
