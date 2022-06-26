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

        'description_en',
        'description_bn',
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
        'slug',

    ];
    protected $appends = [
        'count',
        'quantity_unit',
        'image_with_base_url',

    ];
    public $product = [];

    /****************************
     * Model Relation area
     *****************************/

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function productDetail() {
        return $this->hasOne(ProductDetail::Class);
    }

    public function productImages() {
        return $this->hasMany(ProductImage::Class);
    }

    public function productReviews() {
        return $this->hasMany(ProductReview::Class);
    }

    public function topType() {
        return $this->belongsToMany('App\Models\TopType');
    }

    public function wishList() {
        return $this->belongsTo(WishList::class);
    }
    public function bundleItems() {
        return $this->belongsToMany('App\Models\Bundle');
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
            $data['featured_image'] = $this->UploadImage($data['featured_image'], 'products');
        }

        $data['slug'] = $this->GenerateSlug($data['name']);

        return $data;
    }
}
