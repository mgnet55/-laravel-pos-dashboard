<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/', fn() => redirect()->route('dashboard.index'));

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Start Localization Prefix Routes
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Auth::routes();

    // Start Dashboard Routes
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'auth'], function () {

        Route::get('', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');

        Route::resource('users', \App\Http\Controllers\Dashboard\UserController::class);
        Route::resource('categories', \App\Http\Controllers\Dashboard\CategoryController::class)->except('show');
        Route::resource('products', \App\Http\Controllers\Dashboard\ProductController::class);
        Route::resource('clients', \App\Http\Controllers\Dashboard\ClientController::class);
        Route::scopeBindings()->group(function () {
            Route::resource('clients.orders', \App\Http\Controllers\Dashboard\ClientOrderController::class)->only(['create', 'store', 'index']);
        });
        Route::resource('orders', \App\Http\Controllers\Dashboard\OrderController::class)->except(['create', 'store']);


    });
    //End Dashboard Routes

});//End localization Prefix Routes

