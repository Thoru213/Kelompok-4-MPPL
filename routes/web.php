<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Halaman Utama: Menampilkan daftar produk dari database
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Halaman Detail Produk
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Rute untuk menampilkan form tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Rute untuk memproses data dari form tambah produk
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Rute-rute Keranjang
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.index');
Route::post('/cart/update/{cartKey}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{cartKey}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
