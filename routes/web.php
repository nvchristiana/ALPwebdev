<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController; // <--- Import Controller Profil

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes (Bisa diakses siapa saja) ---
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');

// Route Detail Produk (PENTING: Taruh di bawah route spesifik lain biar gak bentrok)
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show'); 

// Admin Routes (Create/Store/Update/Delete)
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete'); // Support GET delete
Route::post('/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete'); // Support POST delete


// --- Auth Routes (Login/Register/Logout) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Routes yang butuh Login (Middleware Auth) ---
Route::middleware('auth')->group(function () {
    
    // Fitur Keranjang (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Fitur Checkout & Order
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/history', [OrderController::class, 'history'])->name('orders.history');

    // Fitur Review
    Route::post('/products/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // --- FITUR PROFIL (Ini yang tadi Not Found) ---
    // Pastikan Controller menunjuk ke [ProfileController::class, 'edit']
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});