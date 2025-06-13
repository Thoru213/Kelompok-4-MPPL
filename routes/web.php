<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController; // <-- BARIS INI HARUS DITAMBAHKAN!

// Halaman Utama: Menampilkan daftar produk dari database
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Halaman Detail Produk
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Rute untuk menampilkan form tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Rute untuk memproses data dari form tambah produk
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

/* Original Cart Routes - sudah benar dikomentari
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.index');
Route::post('/cart/update/{cartKey}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{cartKey}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
*/

// New Cart Routes - ini sudah benar, tinggal tambahkan use statement di atas
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

// Rute untuk checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CartController::class, 'success'])->name('checkout.success');
