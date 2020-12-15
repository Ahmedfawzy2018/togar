<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Category 
Route::get('categories','App\Http\Controllers\CategoryController@index') ;
Route::post('new-category','App\Http\Controllers\CategoryController@store')->name('new-category') ;
Route::get('show-category/{id}','App\Http\Controllers\CategoryController@show') ;
Route::get('edit-category/{id}','App\Http\Controllers\CategoryController@edit') ;
Route::post('update-category/{id}','App\Http\Controllers\CategoryController@update')->name('update-category') ;
Route::delete('delete-category/{id}','App\Http\Controllers\CategoryController@destroy') ;



//Product
Route::get('products','App\Http\Controllers\ProductController@index') ;
Route::post('new-product','App\Http\Controllers\ProductController@store')->name('new-product') ;
Route::get('show-product/{id}','App\Http\Controllers\ProductController@show') ;
Route::get('edit-product/{id}','App\Http\Controllers\ProductController@edit') ;
Route::post('update-product/{id}','App\Http\Controllers\ProductController@update')->name('update-product') ;
Route::delete('delete-product/{id}','App\Http\Controllers\ProductController@destroy') ;
