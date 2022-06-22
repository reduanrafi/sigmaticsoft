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
        'owner_id',
        'brand_id',
        'unique_id',

        'name',
        'description',

        'delivery_area',

        'featured_image',
        'price',

        'sold_amount',
        'vat_percent',
        'discount',

        'quantity',
        'unit',
        'is_sold_out',
        'is_featured',
        'slug'

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

        if (isset($data['featured_image'])) {

            $data['featured_image'] = $this->UploadImage($data['featured_image'], 'products',500,500);

        }
        $data['slug'] = $this->GenerateSlug($data['name']);

        return $data;
    }
}
