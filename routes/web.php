<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Halaman Utama: Menampilkan daftar produk dari database
Route::get('/', [ProductController::class, 'index'])->name('products.index'); // <-- Ini yang akan jadi halaman utama Anda

// Halaman Detail Produk
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Rute untuk menampilkan form tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Rute untuk memproses data dari form tambah produk
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Rute-rute keranjang (jika Anda ingin mengaktifkannya nanti)
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart']);
Route::get('/cart', [ProductController::class, 'viewCart']);
Route::post('/cart/update/{id}', [ProductController::class, 'updateCart']);
Route::post('/cart/remove/{id}', [ProductController::class, 'removeFromCart']);
