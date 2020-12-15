<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
Route::prefix('/categories')->group(function(){
	Route::get('','App\Http\Controllers\CategoryController@index');
	Route::post('','App\Http\Controllers\CategoryController@store');
	Route::get('/{category}','App\Http\Controllers\CategoryController@show' );
	Route::put('/{category}','App\Http\Controllers\CategoryController@update');
	Route::delete('/{category}','App\Http\Controllers\CategoryController@destroy' );
});


//Product
Route::prefix('/products')->group(function(){
	Route::get('','App\Http\Controllers\ProductController@index' );
	Route::post('','App\Http\Controllers\ProductController@store' );
	Route::get('/{product}','App\Http\Controllers\ProductController@show' );
	Route::put('/{product}','App\Http\Controllers\ProductController@update' );
	Route::delete('/{product}','App\Http\Controllers\ProductController@destroy' );
});
