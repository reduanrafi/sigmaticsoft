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
Route::prefix('v1')->group(function () {
    // Auth
    Route::post('/register', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user/profile', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'profile']);
        Route::post('/logout', [\App\Http\Controllers\Api\V1\Auth\AuthController::class, 'logout']);
        
        // Bedtime Stories - Authenticated
        Route::post('/stories/{id}/favorite', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'toggleFavorite']);
        Route::get('/user/favorites', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'favorites']);
        Route::post('/stories/{id}/progress', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'updateProgress']);
        Route::get('/user/history', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'history']);
    });

    // Bedtime Stories - Public
    Route::get('/categories', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'categories']);
    Route::get('/stories', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'index']);
    Route::get('/stories/recommended', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'recommended']);
    Route::get('/stories/{id}', [\App\Http\Controllers\Api\V1\BedtimeStories\StoryController::class, 'show']);
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

/*
|--------------------------------------------------------------------------
| Problem Radar Leads Routes
|--------------------------------------------------------------------------
*/
Route::prefix('radar-leads')->group(function () {
    Route::get('/', [\App\Http\Controllers\RadarLeadController::class, 'index']);
    Route::get('/stats', [\App\Http\Controllers\RadarLeadController::class, 'stats']);
    Route::patch('/{id}/status', [\App\Http\Controllers\RadarLeadController::class, 'updateStatus']);
    Route::patch('/{id}/notes', [\App\Http\Controllers\RadarLeadController::class, 'updateNotes']);
    Route::delete('/{id}', [\App\Http\Controllers\RadarLeadController::class, 'destroy']);
});

