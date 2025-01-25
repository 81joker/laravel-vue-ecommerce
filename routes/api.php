<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum' , 'admin'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
