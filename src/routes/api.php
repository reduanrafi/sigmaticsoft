<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('products')->group(function () {
    Route::get('/', [\App\Http\Controllers\API\ProTravellersProductsController::class, 'index']);
    Route::get('/by-category', [\App\Http\Controllers\API\ProTravellersProductsController::class, 'categoryProducts']);
    Route::get('/{id}', [\App\Http\Controllers\API\ProTravellersProductsController::class, 'detail']);

});
Route::post('/order-save', [\App\Http\Controllers\API\PtOrderController::class, 'store']);

Route::prefix('categories')->group(function () {
    Route::get('/', [\App\Http\Controllers\API\PtCategoryController::class, 'index']);

});
