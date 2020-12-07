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

Route::get('/home', 'HomeController@index')->name('home');

// ADMIN PANEL ROUTES---------------------------------------
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {

    // DASHBOARD
    Route::get('/', function () {
        return view('admin.layouts.master');
    })->name('home');

    // blade indexes
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/user/rider', 'Admin\UserController@getRiders')->name('rider');
    Route::get('/user/staff', 'Admin\UserController@index')->name('staff');

    // api resources
    Route::apiResources(['user'=>'Admin\UserController']);
    Route::apiResources(['customer'=>'Admin\CustomerController']);
    Route::apiResources(['area'=>'Admin\AreaController']);
    Route::apiResources(['market'=>'Admin\MarketController']);

    // search routes
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
    Route::get('/search_customers', 'Admin\CustomerController@search_customers')->name('search_customers');

    // helpers
    Route::get('/fetch_specific_markets', 'Admin\MarketController@fetch_specific_markets')->name('fetch_specific_markets');
});
