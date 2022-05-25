<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    return redirect()->back();
});

Route::view('/', 'website.layouts.master');

Route::view('products', 'website.pages.heroSection');
Route::view('product-details', 'website.pages.productDetails');
Route::view('login-register', 'website.pages.login-register');
Route::view('profile', 'website.pages.profile');


Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'private-panel', 'middleware' => ['auth']], function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::view('dashboard', 'admin.layouts.master');
});
