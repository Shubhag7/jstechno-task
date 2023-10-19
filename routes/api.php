<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/register',[RegisterLoginController::class,'register']);

Route::post('/category-store',[CategoryController::class,'store']);

Route::get('/categories',[CategoryController::class,'index']);

Route::put('/categories/{category}',[CategoryController::class,'update']);

Route::delete('/categories/{category}',[CategoryController::class,'destory']);


Route::post('/product-store',[ProductController::class,'store']);

Route::get('/products',[ProductController::class,'index']);

Route::post('/products/{product}',[ProductController::class,'update']);

Route::delete('/products/{product}',[ProductController::class,'destory']);









