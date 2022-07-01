<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;


class ProductDetailsController extends Controller {



    public function index($slug) {

            $productService = new ProductService();

            $product = $productService->GetProductBySlug($slug);

            return view($this->publicPath.'productDetails', [

                'product' => $product,
            ]);

    }
}
