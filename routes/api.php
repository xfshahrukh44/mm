<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// open routes
Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@store');

// closed routes
Route::group(['middleware' => ['auth:api', 'cors'], 'prefix' => 'auth'], function() {
    
    // User
    Route::post('logout', 'API\AuthController@logout');
    Route::post('me', 'API\AuthController@me');
    Route::apiResources(['user'=>'API\AuthController']);

    // Customer
    Route::apiResources(['customer'=>'API\CustomerController']);

    // Market
    Route::apiResources(['market'=>'API\MarketController']);

    // Area
    Route::apiResources(['area'=>'API\AreaController']);

    // Category
    Route::apiResources(['category'=>'API\CategoryController']);

    // Brand
    Route::apiResources(['brand'=>'API\BrandController']);

    // Unit
    Route::apiResources(['unit'=>'API\UnitController']);

    // Product
    Route::apiResources(['product'=>'API\ProductController']);

    // Order
    Route::apiResources(['order'=>'API\OrderController']);

    // OrderProduct
    Route::apiResources(['order_product'=>'API\OrderProductController']);

    // helpers
    Route::get('/fetch_specific_markets', 'API\MarketController@fetch_specific_markets');

});
