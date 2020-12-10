<?php

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

Auth::routes();

Route::get('/', 'Admin\DashboardController@index')->name('home');

// ADMIN PANEL ROUTES---------------------------------------
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {

    // DASHBOARD
    // Route::get('/', function () {
    //     return view('admin.layouts.master');
    // })->name('home');

    // blade indexes
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/user/rider', 'Admin\UserController@getRiders')->name('rider');
    Route::get('/user/staff', 'Admin\UserController@index')->name('staff');

    // api resources
    Route::apiResources(['user'=>'Admin\UserController']);
    Route::apiResources(['customer'=>'Admin\CustomerController']);
    Route::apiResources(['area'=>'Admin\AreaController']);
    Route::apiResources(['market'=>'Admin\MarketController']);
    Route::apiResources(['category'=>'Admin\CategoryController']);
    Route::apiResources(['brand'=>'Admin\BrandController']);
    Route::apiResources(['unit'=>'Admin\UnitController']);
    Route::apiResources(['product'=>'Admin\ProductController']);

    // search routes
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_customers', 'Admin\CustomerController@search_customers')->name('search_customers');
    Route::get('/search_products', 'Admin\ProductController@search_products')->name('search_products');

    // helpers
    Route::get('/fetch_specific_markets', 'Admin\MarketController@fetch_specific_markets')->name('fetch_specific_markets');
    Route::get('/create_category', 'Admin\ProductController@create_category')->name('create_category');
    Route::get('/create_brand', 'Admin\ProductController@create_brand')->name('create_brand');
    Route::get('/create_unit', 'Admin\ProductController@create_unit')->name('create_unit');
});
