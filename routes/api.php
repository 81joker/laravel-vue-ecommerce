<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductController;




Route::middleware(['auth:sanctum' ,'admin'])->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', action: [AuthController::class, 'logout']);
    Route::apiResource('/products', ProductController::class);
});
Route::post('/login',  [AuthController::class, 'login'])->name('login');

// Route::get('/user', [AuthController::class, 'getUser']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
