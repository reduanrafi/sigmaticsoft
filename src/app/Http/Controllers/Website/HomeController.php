<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\portfolio;
use App\Models\CaseStudy;
use Illuminate\Http\Request;


class HomeController extends Controller {
    public function index() {
        $products = Product::all();
        $portfolios = portfolio::where('is_active', 1)->latest()->get();
        $featuredCaseStudies = CaseStudy::where('is_active', 1)->where('is_featured', 1)->orderBy('id', 'desc')->get();
        return view('website.index', [
            'products' => $products,
            'portfolios' => $portfolios,
            'featuredCaseStudies' => $featuredCaseStudies
        ]);
    }

    public function pd_details(Request $request,$slug) {

        $products = Product::limit(5)->get();
        $product = Product::where('slug',$slug)->first();

        return view('website.pages.productDetails',['product'=>$product,'products'=>$products]);

    }
}
