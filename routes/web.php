<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
