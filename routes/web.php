<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');

    Route::prefix('/cart')->name('cart.')->group(function(){
        Route::get('/', [ProductController::class, 'cart'])->name('index');
        Route::post('/add/{product:slug}', [ProductController::class, 'addToCart'])->name('add');
        Route::post('/update/{product:slug}', [ProductController::class, 'updateCart'])->name('update');
        Route::post('/remove/{product:slug}', [ProductController::class, 'removeFromCart'])->name('remove');
        Route::post('/updated-quantity', [ProductController::class, 'updateQuantity'])->name('update-quantity');
        // Route::post('/clear', [ProductController::class, 'clearCart'])->name('clear');
    });
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
