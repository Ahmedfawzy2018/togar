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
Route::prefix('/categories')->group(function(){
	Route::get('',[CategoryController::class,'index'] );
	Route::post('',[CategoryController::class,'store'] );
	Route::get('/{category}',[CategoryController::class,'show'] );
	Route::put('/{category}',[CategoryController::class,'update'] );
	Route::delete('/{category}',[CategoryController::class,'destroy'] );
});


//Product
Route::prefix('/products')->group(function(){
	Route::get('',[ProductController::class,'index'] );
	Route::post('',[ProductController::class,'store'] );
	Route::get('/{product}',[ProductController::class,'show'] );
	Route::put('/{product}',[ProductController::class,'update'] );
	Route::delete('/{product}',[ProductController::class,'destroy'] );
});
