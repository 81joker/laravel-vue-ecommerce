<?php

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashbaordController;

Route::middleware(['auth:sanctum' ,'admin'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', action: [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::get('/countries', [CustomerController::class, 'countries']);
    Route::apiResource('/products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::get('orders/statuses', [OrderController::class, 'getStatuses']);
    Route::post('orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
    Route::get('/orders/{order}', [OrderController::class, 'view']);

    // Dashbaord Routes
    Route::get('/dashboard/customers-count', [DashbaordController::class, 'activeCustomers']);
    Route::get('/dashboard/products-count', [DashbaordController::class, 'activeProducts']);
    Route::get('/dashboard/orders-count', [DashbaordController::class, 'paidOrders']);
    Route::get('/dashboard/income-count', [DashbaordController::class, 'totalIncome']);
});
Route::post('/login',  [AuthController::class, 'login'])->name('login');

// Route::get('/user', [AuthController::class, 'getUser']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
