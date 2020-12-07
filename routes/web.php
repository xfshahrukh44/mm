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
    });

    // blade indexes
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/users/rider', 'API\UserController@getRiders')->name('rider');
    Route::get('/users/staff', 'API\UserController@index')->name('staff');

    // api resources
    Route::apiResources(['user'=>'Admin\UserController']);

    // search routes
    Route::get('/search_users', 'Admin\UserController@search_users')->name('search_users');
});
