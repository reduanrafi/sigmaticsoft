<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProTravellersProductsController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::where('site_name','pro_travellers')->get();

        return response()->json(ProductResource::collection($products));
    }
    public function detail($id): JsonResponse
    {
        $product = Product::findOrFail($id);

        return  response()->json(new ProductDetailResource($product));
    }
    public function categoryProducts(Request $request): JsonResponse
    {
        $products = Product::where('site_name','pro_travellers')
            ->where('category_id',$request->id)
            ->get();

        return response()->json(ProductResource::collection($products));
    }
}
