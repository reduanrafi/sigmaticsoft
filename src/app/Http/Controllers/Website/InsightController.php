<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Insight;
use Illuminate\Http\Request;

class InsightController extends Controller {

    public function index()
    {
        $insights = Insight::latest()->paginate(10);
        $categories = Category::all();
//        dd($insights);
        return view('website.pages.insight', compact('insights','categories'));
    }

    public function show($slug)
    {
        $categories = Category::all();
        $insight = Insight::where('slug', $slug)->firstOrFail();
        return view('website.pages.show_insight', compact('insight','categories'));
    }
}
