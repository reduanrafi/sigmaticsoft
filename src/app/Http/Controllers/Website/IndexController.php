<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class IndexController extends Controller {
    private $globalObject;

    private $retrievedDataList;
    private $singleData;

    public function __construct() {

        $this->globalObject = new Product();
    }

    public function Index() {

        $data['products']   = Product::all();
        $data['categories'] = Category::all();

        return view('website.index', $data);
    }
    public function Products() {

        $data['products']   = Product::all();
        $data['categories'] = Category::all();

        return view($this->publicPath.'products', $data);
    }

}
