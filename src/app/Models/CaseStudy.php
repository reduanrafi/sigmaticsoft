<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CaseStudy extends Model
{
    use HasFactory, CommonFunctions;

    protected $table = 'case_studies';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'tag',
        'icon_class',
        'excerpt',
        'client_context',
        'existing_environment',
        'business_problem',
        'solution',
        'node1_title',
        'node1_desc',
        'node2_title',
        'node2_desc',
        'node3_title',
        'node3_desc',
        'implementation',
        'outcome',
        'lessons_learned',
        'category',
        'timeline',
        'stack',
        'status',
        'capability_1',
        'capability_2',
        'capability_3',
        'capability_4',
        'cta_title',
        'cta_description',
        'cta_button_text',
        'cta_link',
        'is_active',
        'is_featured'
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($caseStudy) {
            if (empty($caseStudy->slug)) {
                $caseStudy->slug = Str::slug($caseStudy->title);
            }
        });
    }

    public function GetData($data)
    {
        return $data;
    }
}
