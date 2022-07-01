<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductDetailsController extends Controller {
    public function index($slug) {
        if (Product::where('slug', $slug)->exists()) {
            $product = Product::all();
            return view('website.pages.productDetails', [
                'product' => $product,
            ]);
        }
    }
}
