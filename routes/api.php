<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IngredientProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\TableController;
use App\Models\Category;
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
Route::post('/userLogin' , [AuthenticationController::class , 'login']); // postman , tested
Route::post('/employeeLogin' , [AuthenticationController::class , 'loginEmployee']); // postman , tested
Route::post('/supplierLogin' , [AuthenticationController::class , 'loginSupplier']); // postman , tested

Route::middleware(['auth:sanctum'])->group(function (){
    ///// Profile
    Route::get('/userProfile' , [ProfileController::class , 'userProfile']); //postman
    Route::get('/employeeProfile' , [ProfileController::class , 'employeeProfile']); //postman
    Route::get('/supplierProfile' , [ProfileController::class , 'supplierProfile']); //postman

    ////// Users
    Route::get('/users' , [UserController::class , 'index']);//postman
    Route::post('/users' , [UserController::class , 'store']);//postman
    Route::get('/users/{user}' , [UserController::class , 'show']);//postman
    Route::patch('/users/{user}' , [UserController::class  , 'update']);//postman
    Route::delete('/users/{user}' , [UserController::class  , 'destroy']);//postman

    /////  Suppliers
    Route::get('/suppliers' , [SupplierController::class , 'indexAll']);//postman
    Route::get('/{branchID}/suppliers' , [SupplierController::class , 'index'])->whereNumber('branchID');//postman
    Route::post('/suppliers' , [SupplierController::class , 'store']);//postman
    Route::get('/suppliers/{supplier}' , [SupplierController::class , 'show']);//postman
    Route::post('/suppliers/{supplier}' , [SupplierController::class  , 'update']);//postman
    Route::delete('/suppliers/{supplier}' , [SupplierController::class  , 'destroy']);//postman
    Route::post('/supply' , [SupplierController::class  , 'supply']);//postman

    Route::get('/lastfivesuppliers/{branchID}', [SupplierController::class , 'lastfivesuppliers']);//postman

    Route::get('/{branchID}/ingredients-supplied' , [SupplierController::class , 'ingredientsSupplied'])->whereNumber('branchID');//postman

    ///// Product
    Route::get('/{branchID}/products' , [ProductController::class , 'index'])->whereNumber('branchID');//postman
    Route::post('/products' , [ProductController::class , 'store']);//postman
    Route::get('/products/{product}' , [ProductController::class , 'show']);//postman
    Route::post('/products/{product}' , [ProductController::class  , 'update']);//postman
    Route::delete('/products/{product}' , [ProductController::class  , 'destroy']);//postman
    Route::get('/lastfiveproduct/{branchID}', [ProductController::class, 'lastfiveproduct']); //postman

    //////  Categories
    Route::get('/categories' , [CategoryController::class , 'indexAll']);//postman , tested
    Route::get('/{branchID}/categories' , [CategoryController::class , 'index'])->whereNumber('branchID');//postman , tested
    Route::post('/categories' , [CategoryController::class , 'store']);//postman , tested
    Route::get('/categories/{category}' , [CategoryController::class , 'show']);//postman , tested
    Route::post('/categories/{category}' , [CategoryController::class  , 'update']);//postman , tested
    Route::delete('/categories/{category}' , [CategoryController::class  , 'destroy']);//postman , tested
    Route::get('/lastfivecategory/{branchID}', [CategoryController::class , 'lastfivecategory']);//postman ,tested

    ////// Branch
    Route::get('/branches' , [BranchController::class , 'index']);//postman, tested
    Route::post('/branches' , [BranchController::class , 'store']);//postman, tested
    Route::get('/branches/{branch}' , [BranchController::class , 'show']);//postman, tested
    Route::patch('/branches/{branch}' , [BranchController::class  , 'update']);//postman, tested
    Route::delete('/branches/{branch}' , [BranchController::class  , 'destroy']);//postman, tested
    Route::get('/supplier-branches' , [BranchController::class , 'supplierBranches']);//postman, tested
    Route::get('/last5SupplierSupply/{branchID}' , [SupplierController::class , 'last5SupplierSupply']);//postman
    Route::get('/supplierSupply/{branchID}' , [SupplierController::class , 'SupplierSupply']);//postman

    //////  Employees
    Route::get('/employees' , [EmployeeController::class , 'index']);//postman
    Route::get('/{branchID}/employees' , [EmployeeController::class , 'indexByBranch']);//postman
    Route::post('/employees' , [EmployeeController::class , 'store']);//postman
    Route::get('/employees/{employee}' , [EmployeeController::class , 'show']);//postman
    Route::post('/employees/{employee}' , [EmployeeController::class  , 'update']);//postman
    Route::delete('/employees/{employee}' , [EmployeeController::class  , 'destroy']);//postman

    ///// Table
    Route::get('/{branchID}/tables' , [TableController::class , 'indexByBranch'])->whereNumber('branchID');//postman , tested
    Route::get('/tables' , [TableController::class , 'index']);//postman, tested
    Route::post('/tables' , [TableController::class , 'store']);//postman, tested
    Route::get('/tables/{table}' , [TableController::class , 'show']);//postman, tested
    Route::delete('/tables/{table}' , [TableController::class , 'delete']);//postman, tested
    Route::get('/available_table' , [TableController::class , 'available_table']);//postman, tested
    Route::get('/not_available/{branchID}' , [TableController::class , 'not_available']); // //postman, tested

    ///// Orders
    Route::get('/orders' , [OrderController::class , 'index']);//postman
    Route::post('/orders' , [OrderItemController::class , 'store']);//postman
    Route::get('/orders/{subOrder}' , [OrderController::class , 'show']);//postman
    Route::get('/{branchID}/orders' , [OrderController::class , 'indexByBranch'])->whereNumber('branchID');//postman
    Route::get('/readyOrders' , [OrderController::class , 'readyOrders']);//postman
    Route::get('/{branchID}/readyOrders' , [OrderController::class , 'readyOrdersByBranch'])->whereNumber('branchID');//postman
    Route::get('/newOrders' , [OrderController::class , 'newOrders']);//postman
    Route::get('/{branchID}/newOrders' , [OrderController::class , 'newOrdersByBranch'])->whereNumber('branchID');//postman
    Route::get('/waitingOrders' , [OrderController::class , 'waitingOrders']);//postman
    Route::get('/{branchID}/waitingOrders' , [OrderController::class , 'waitingOrdersByBranch'])->whereNumber('branchID');//postman
    Route::get('/preparingOrders' , [OrderController::class , 'preparingOrders']);//postman
    Route::get('/{branchID}/preparingOrders' , [OrderController::class , 'preparingOrdersByBranch'])->whereNumber('branchID');//postman
    Route::get('/pastOrders' , [OrderController::class , 'pastOrders']);//postman
    Route::get('/{branchID}/pastOrders' , [OrderController::class , 'pastOrdersByBranch'])->whereNumber('branchID');//postman
    Route::patch('/accept_order/{subOrder}' , [OrderController::class , 'acceptOrder']);//postman
    Route::patch('/start_preparing/{subOrder}' , [OrderController::class , 'startPreparing']);//postman
    Route::patch('/make_order_ready/{subOrder}' , [OrderController::class , 'toReady']);//postman
    Route::patch('/close-table/{table}' , [TableController::class , 'closeTable']);//postman
    Route::patch('/order_review/{order}' , [OrderController::class , 'order_review']);//postman
    Route::get('/ordersRate' , [OrderController::class , 'calculateAverages']);//postman
    Route::get('/ordersDelay' , [OrderController::class , 'calculateDelays']);//postman
    Route::get('/lastfiveorder/{branchID}',[OrderController::class,'lastfiveorder']); //postman

    Route::get('/ingredients',[IngredientController::class, 'index']);//postman
    Route::get('/{branchID}/ingredients',[IngredientController::class, 'indexByBranch'])->whereNumber('branchID');//postman
    Route::post('/ingredients',[IngredientController::class, 'store']);//postman
    Route::patch('/ingredients/{ingredient}',[IngredientController::class, 'update']);//postman
    Route::get('/ingredients/{ingredient}',[IngredientController::class, 'show']);//postman
    Route::get('/last5Ingredients/{branchID}' ,  [IngredientController::class , 'last5']); //postman
    Route::delete('/ingredients/{ingredient}',[IngredientController::class, 'delete']);//postman

    Route::patch('/ingredient-product/{ingredientProduct}' , [IngredientProductController::class , 'update']);
    Route::delete('/ingredient-product/{ingredientProduct}' , [IngredientProductController::class , 'destroy']);//postman

    Route::get('/notifications/{branchID}' , [NotificationController::class , 'index']);//postman
    Route::patch('/mark-all-as-read/{branchID}' , [NotificationController::class , 'markAllAsRead']);//postman

    Route::get('/getTops/{branchID}' , [StatisticsController::class , 'getTops']); //postman
});

