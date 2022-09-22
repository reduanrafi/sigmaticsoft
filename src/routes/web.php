<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\StaticPageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    return redirect()->back();
});

Route::get('/', [HomeController::class, 'index'])->name('website.index');
Route::get('product-details', [HomeController::class, 'pd_details'])->name('details');
Route::get('/learning', [StaticPageController::class, 'learning'])->name('learning');
Route::get('/about', [StaticPageController::class, 'about'])->name('website.about');

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['prefix' => 'private-panel', 'middleware' => ['auth']], function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::view('dashboard', 'admin.layouts.master');
    Route::resource('category', CategoryController::class);
    Route::resource('products', ProductsController::class);
});
