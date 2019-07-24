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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*****************************************
-------------- ADMIN ROUTES --------------
*****************************************/
Route::get('/admin', 'Auth\AdminLoginController@showLoginForm');
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm');
Route::post('/admin/login', ['as'=>'admin-login','uses'=>'Auth\AdminLoginController@login']);

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/logout', 'Auth\AdminLoginController@logout');
    Route::get('/admin/dashboard', 'Auth\AdminLoginController@dashboard');

    Route::resource('/admin/hsncode', 'HsncodeController');
    Route::resource('/admin/brand', 'BrandController');
    Route::resource('/admin/category', 'CategoryController');
});
