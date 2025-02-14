<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileContrller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;

Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');

    Route::prefix('/cart')->name('cart.')->group(function(){
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove');
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('update-quantity');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile' , [ProfileContrller::class, 'view'])->name('profile');
    Route::post('/profile', [ProfileContrller::class, 'store'])->name('profile.update');
    Route::post('/profile/password-update', [ProfileContrller::class, 'passwordUpdate'])->name('profile_password.update');
    Route::post('/cart/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout/success',  action: [CheckoutController::class, 'success'])->name('cart.success');
    Route::post('/cart/checkout/cancel',  action: [CheckoutController::class, 'cancel'])->name('cart.cancel');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    // Route::middleware('auth')->group(function () {
    //     Route::get('/profiles', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profiles', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profiles', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
