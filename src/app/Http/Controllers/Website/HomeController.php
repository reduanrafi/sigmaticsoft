<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class HomeController extends Controller {
    public function index() {
        return view('website.index');
    }

    public function pd_details() {

        return view('website.pages.productDetails');

    }
}
