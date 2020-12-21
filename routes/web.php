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

    // all() routes
    Route::get('/order/all', 'Admin\OrderController@all')->name('order.all');
    Route::get('/product/all', 'Admin\ProductController@all')->name('product.all');
    Route::get('/customer/all', 'Admin\CustomerController@all')->name('customer.all');

    // api resources
    Route::apiResources(['user'=>'Admin\UserController']);
    Route::apiResources(['customer'=>'Admin\CustomerController']);
    Route::apiResources(['area'=>'Admin\AreaController']);
    Route::apiResources(['market'=>'Admin\MarketController']);
    Route::apiResources(['category'=>'Admin\CategoryController']);
    Route::apiResources(['brand'=>'Admin\BrandController']);
    Route::apiResources(['unit'=>'Admin\UnitController']);
    Route::apiResources(['product'=>'Admin\ProductController']);
    Route::apiResources(['ledger'=>'Admin\LedgerController']);
    Route::apiResources(['stock_in'=>'Admin\StockInController']);
    Route::apiResources(['stock_out'=>'Admin\StockOutController']);
    Route::apiResources(['order'=>'Admin\OrderController']);

    // search routes
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_customers', 'Admin\CustomerController@search_customers')->name('search_customers');
    Route::get('/search_products', 'Admin\ProductController@search_products')->name('search_products');
    Route::get('/search_ledgers', 'Admin\LedgerController@search_ledgers')->name('search_ledgers');
    Route::get('/search_stockIns', 'Admin\StockInController@search_stockIns')->name('search_stockIns');
    Route::get('/search_stockOuts', 'Admin\StockOutController@search_stockOuts')->name('search_stockOuts');
    Route::get('/search_orders', 'Admin\OrderController@search_orders')->name('search_orders');

    // helpers
    Route::get('/fetch_specific_markets', 'Admin\MarketController@fetch_specific_markets')->name('fetch_specific_markets');
    Route::get('/create_category', 'Admin\ProductController@create_category')->name('create_category');
    Route::get('/create_brand', 'Admin\ProductController@create_brand')->name('create_brand');
    Route::get('/create_unit', 'Admin\ProductController@create_unit')->name('create_unit');
    Route::get('/fetch_product_labels', 'Admin\ProductController@fetch_product_labels')->name('fetch_product_labels');
    Route::get('/fetch_customer_labels', 'Admin\CustomerController@fetch_customer_labels')->name('fetch_customer_labels');
});
