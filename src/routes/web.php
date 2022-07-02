<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\ProductDetailsController;
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

Route::get('/', [IndexController::class, 'index'])->name('website.index');
Route::get('/products', [IndexController::class, 'products'])->name('website.products');


Route::get('product-details/{slug}', [ProductDetailsController::class, 'index'])->name('website.details');
Route::view('login-register', 'website.pages.login-register');
Route::view('profile', 'website.pages.profile');

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'private-panel', 'middleware' => ['auth']], function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::view('dashboard', 'admin.layouts.master');
    Route::resource('category', CategoryController::class);
    Route::resource('products', ProductsController::class);
});
