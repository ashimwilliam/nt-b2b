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

Route::post('/login', 'Api\AuthController@login');
Route::middleware('auth:api')->get('/logout', 'Api\AuthController@logout');
Route::post('/refresh-token', 'Api\AuthController@refreshToken');
Route::post('/register', 'Api\AuthController@register');

Route::get('/brands', 'Api\ProductController@getBrands');
Route::post('/products-by-brand', 'Api\ProductController@getProductsByBrand');

Route::get('/categories', 'Api\ProductController@getCategories');
Route::post('/subcategories', 'Api\ProductController@getSubCategories');
Route::post('/products-by-category', 'Api\ProductController@getProductsByCategory');
Route::post('/products-by-subcategory', 'Api\ProductController@getProductsBySubCategory');

Route::get('/send-otp', 'Api\AuthController@sendOTP');
Route::post('/verify-otp', 'Api\AuthController@verifyOTP');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user-details', 'UserController@userDetails');
});*/
