<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Insight extends Model
{
    use HasFactory, CommonFunctions;
    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'featured_image', 'meta_title', 'meta_description', 'meta_keywords'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($insight) {
            $insight->slug = Str::slug($insight->title);
        });
    }

    public function GetData($data) {
        if (isset($data['featured_image'])) {
            $data['featured_image'] = $this->UploadImage($data['featured_image'],'insights');
        }

        return $data;
    }
}
