<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TableController;
use App\Models\Order;
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
Route::post('/userLogin' , [AuthenticationController::class , 'login']);
Route::post('/employeeLogin' , [AuthenticationController::class , 'loginEmployee']);
Route::post('/supplierLogin' , [AuthenticationController::class , 'loginSupplier']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/userProfile' , [ProfileController::class , 'userProfile']);
    Route::get('/employeeProfile' , [ProfileController::class , 'employeeProfile']);
    Route::get('/supplierProfile' , [ProfileController::class , 'supplierProfile']);
    Route::get('/users' , [UserController::class , 'index']);
    Route::post('/users' , [UserController::class , 'store']);
    Route::get('/users/{user}' , [UserController::class , 'show']);
    Route::patch('/users/{user}' , [UserController::class  , 'update']);
    Route::delete('/users/{user}' , [UserController::class  , 'destroy']);
    Route::get('/suppliers' , [SupplierController::class , 'indexAll']);
    Route::get('/{branchID}/suppliers' , [SupplierController::class , 'index'])->whereNumber('branchID');
    Route::post('/suppliers' , [SupplierController::class , 'store']);
    Route::get('/suppliers/{supplier}' , [SupplierController::class , 'show']);
    Route::patch('/suppliers/{supplier}' , [SupplierController::class  , 'update']);
    Route::delete('/suppliers/{supplier}' , [SupplierController::class  , 'destroy']);
    Route::post('/supply' , [SupplierController::class  , 'supply']);
    Route::get('/{branchID}/products' , [ProductController::class , 'index'])->whereNumber('branchID');
    Route::post('/products' , [ProductController::class , 'store']);
    Route::get('/products/{product}' , [ProductController::class , 'show']);
    Route::post('/products/{product}' , [ProductController::class  , 'update']);
    Route::delete('/products/{product}' , [ProductController::class  , 'destroy']);
    Route::get('categories' , [CategoryController::class , 'indexAll']);
    Route::get('/{branchID}/categories' , [CategoryController::class , 'index'])->whereNumber('branchID');
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
    Route::get('/{branchID}/tables' , [TableController::class , 'indexByBranch'])->whereNumber('branchID');
    Route::get('/tables' , [TableController::class , 'index']);
    Route::post('/tables' , [TableController::class , 'store']);
    Route::get('/tables/{table}' , [TableController::class , 'show']);
    Route::delete('/tables/{table}' , [TableController::class , 'delete']);
    Route::get('/orders' , [OrderController::class , 'index']);
    Route::post('/orders' , [OrderItemController::class , 'store']);
    Route::get('/orders/{subOrder}' , [OrderController::class , 'show']);
    Route::get('/{branchID}/orders' , [OrderController::class , 'indexByBranch'])->whereNumber('branchID');
    Route::get('/readyOrders' , [OrderController::class , 'readyOrders']);
    Route::get('/{branchID}/readyOrders' , [OrderController::class , 'readyOrdersByBranch'])->whereNumber('branchID');
    Route::get('/newOrders' , [OrderController::class , 'newOrders']);
    Route::get('/{branchID}/newOrders' , [OrderController::class , 'newOrdersByBranch'])->whereNumber('branchID');
    Route::get('/waitingOrders' , [OrderController::class , 'waitingOrders']);
    Route::get('/{branchID}/waitingOrders' , [OrderController::class , 'waitingOrdersByBranch'])->whereNumber('branchID');
    Route::get('/preparingOrders' , [OrderController::class , 'preparingOrders']);
    Route::get('/{branchID}/preparingOrders' , [OrderController::class , 'preparingOrdersByBranch'])->whereNumber('branchID');
    Route::get('/pastOrders' , [OrderController::class , 'pastOrders']);
    Route::get('/{branchID}/pastOrders' , [OrderController::class , 'pastOrdersByBranch'])->whereNumber('branchID');
    Route::patch('/accept_order/{subOrder}' , [OrderController::class , 'acceptOrder']);
    Route::patch('/start_preparing/{subOrder}' , [OrderController::class , 'startPreparing']);
    Route::patch('/make_order_ready/{subOrder}' , [OrderController::class , 'toReady']);
    Route::patch('/close-table/{table}' , [TableController::class , 'closeTable']);
    Route::patch('/order_review/{order}' , [OrderController::class , 'order_review']);
});

