<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');

Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

Route::post('/products/update/{id}', [ProductController::class, 'update'])
    ->name('products.update');

Route::get('/products/delete/{id}', [ProductController::class, 'delete'])
    ->name('products.delete');
