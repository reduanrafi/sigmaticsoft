<?php

namespace App\Models;

use App\Traits\CommonFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use HasFactory;
    use CommonFunctions;
    use SoftDeletes;
    /****************************
     * Property area
     *****************************/
    protected $fillable = [
        'parent_id',
        'slug',
        'name',
        'image',
        'icon',
    ];
    public $category = [];
    /****************************
     * Model Relation area
     *****************************/

    public function products() {
        return $this->hasMany(Product::class, 'category_id')->where('products.is_deleted', '=', 0);
    }
    public function categories() {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function childrenCategories() {
        return $this->hasMany(Category::class, 'parent_id')->with('categories')->where('is_deleted', '=', 0);
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
            $data['image'] = $this->UploadImage($data['image'], 'categories');

        }
        if (isset($data['icon'])) {
            $data['icon'] = $this->UploadImage($data['icon'], 'icons');

        }
        $data['slug'] = $this->GenerateSlug($data['name']);

        return $data;
    }

}
