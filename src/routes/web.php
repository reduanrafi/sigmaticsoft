<?php

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

Route::view('/', 'website.layouts.master');

Route::view('products', 'website.pages.heroSection');
Route::view('product-details', 'website.pages.productDetails');
Route::view('login-register', 'website.pages.login-register');
Route::view('profile', 'website.pages.profile');
Route::view('dashboard', 'admin.layouts.master');
