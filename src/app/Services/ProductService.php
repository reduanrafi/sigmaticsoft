<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{

    public function GetProductBySlug($slug)
    {
        return Product::where('slug',$slug)->first();
    }

}