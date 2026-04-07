<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PtCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('site_name','pro_travellers')->get();

        return response()->json( $categories);
    }
}
