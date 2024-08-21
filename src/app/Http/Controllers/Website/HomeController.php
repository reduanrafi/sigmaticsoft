<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


class HomeController extends Controller {
    public function index() {

        $products = Product::all();
        return view('website.index',['products'=>$products]);
    }

    public function pd_details(Request $request,$slug) {

        $products = Product::limit(5)->get();
        $product = Product::where('slug',$slug)->first();

        return view('website.pages.productDetails',['product'=>$product,'products'=>$products]);

    }
}
