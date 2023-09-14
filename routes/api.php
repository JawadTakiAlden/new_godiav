<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
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
Route::post('/login' , [AuthenticationController::class , 'login']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/users' , [UserController::class , 'index']);
    Route::post('/users' , [UserController::class , 'store']);
    Route::get('/users/{user}' , [UserController::class , 'show']);
    Route::patch('/users/{user}' , [UserController::class  , 'update']);
    Route::delete('/users/{user}' , [UserController::class  , 'destroy']);

    Route::get('/suppliers' , [SupplierController::class , 'index']);
    Route::post('/suppliers' , [SupplierController::class , 'store']);
    Route::get('/suppliers/{supplier}' , [SupplierController::class , 'show']);
    Route::patch('/suppliers/{supplier}' , [SupplierController::class  , 'update']);
    Route::delete('/suppliers/{supplier}' , [SupplierController::class  , 'destroy']);

    Route::get('/products' , [ProductController::class , 'index']);
    Route::post('/products' , [ProductController::class , 'store']);
    Route::get('/products/{product}' , [ProductController::class , 'show']);
    Route::post('/products/{product}' , [ProductController::class  , 'update']);
    Route::delete('/products/{product}' , [ProductController::class  , 'destroy']);

    Route::get('/categories' , [CategoryController::class , 'index']);
    Route::post('/categories' , [CategoryController::class , 'store']);
    Route::get('/categories/{category}' , [CategoryController::class , 'show']);
    Route::post('/categories/{category}' , [CategoryController::class  , 'update']);
    Route::delete('/categories/{category}' , [CategoryController::class  , 'destroy']);
});

