<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class StaticPageController extends Controller {

    public function learning() {

        return view('website.pages.learning');

    }

    public function about() {

        return view('website.pages.about');

    }
}
