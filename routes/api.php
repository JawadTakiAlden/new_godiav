<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;
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

    Route::get('/suppliers' , [SupplierController::class , 'indexall']);
    Route::get('/{branchID}/suppliers' , [SupplierController::class , 'index'])->whereNumber('branchID');
    Route::post('/suppliers' , [SupplierController::class , 'store']);
    Route::get('/suppliers/{supplier}' , [SupplierController::class , 'show'])->whereNumber('branchID');
    Route::patch('/suppliers/{supplier}' , [SupplierController::class  , 'update']);
    Route::delete('/suppliers/{supplier}' , [SupplierController::class  , 'destroy']);

    Route::get('/{branchID}/products' , [ProductController::class , 'index'])->whereNumber('branchID');
    Route::post('/products' , [ProductController::class , 'store']);
    Route::get('/products/{product}' , [ProductController::class , 'show'])->whereNumber('branchID');
    Route::post('/products/{product}' , [ProductController::class  , 'update']);
    Route::delete('/products/{product}' , [ProductController::class  , 'destroy']);

    Route::get('/categories' , [CategoryController::class , 'index']);
    Route::post('/categories' , [CategoryController::class , 'store']);
    Route::get('/categories/{category}' , [CategoryController::class , 'show']);
    Route::post('/categories/{category}' , [CategoryController::class  , 'update']);
    Route::delete('/categories/{category}' , [CategoryController::class  , 'destroy']);


    Route::get('/branches' , [BranchController::class , 'index']);
    Route::post('/branches' , [BranchController::class , 'store']);
    Route::get('/branches/{branch}' , [BranchController::class , 'show']);
    Route::patch('/branches/{branch}' , [BranchController::class  , 'update']);
    Route::delete('/branches/{branch}' , [BranchController::class  , 'destroy']);

    Route::get('/employees' , [EmployeeController::class , 'index']);
    Route::get('/{branchID}/employees' , [EmployeeController::class , 'indexByBranch']);
    Route::post('/employees' , [EmployeeController::class , 'store']);
    Route::get('/employees/{employee}' , [EmployeeController::class , 'show']);
    Route::post('/employees/{employee}' , [EmployeeController::class  , 'update']);
    Route::delete('/employees/{employee}' , [EmployeeController::class  , 'destroy']);
});

