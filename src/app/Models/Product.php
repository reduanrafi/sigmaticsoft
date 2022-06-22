<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use HasFactory;
    use CommonFunctions;
    use SoftDeletes;
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'price',
        'slug',
    ];
    public $product = [];
    /****************************
     * Model Relation area
     *****************************/

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /****************************
     * Public Methods area
     *****************************/

    /***
     * Method to get data.
     * @param $data
     * @return
     */
    public function GetData($data) {

        if (isset($data['image'])) {
            $data['image'] = $this->UploadImage($data['image'], 'products');

        }
        if (isset($data['icon'])) {
            $data['icon'] = $this->UploadImage($data['icon'], 'icons');

        }
        $data['slug'] = $this->GenerateSlug($data['name']);

        return $data;
    }
}
