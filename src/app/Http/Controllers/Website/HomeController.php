<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
class HomeController extends Controller {
    public function index() {

        $products = Product::all();
        return view('website.index',['products'=>$products]);
    }

    public function pd_details() {

        return view('website.pages.productDetails');

    }
}
