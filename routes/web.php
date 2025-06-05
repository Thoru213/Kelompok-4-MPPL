<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
});


Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/product/create', [ProductController::class, 'create']);
Route::post('/product', [ProductController::class, 'store']);

Route::post('/cart/add/{id}', [ProductController::class, 'addToCart']);
Route::get('/cart', [ProductController::class, 'viewCart']);
Route::post('/cart/update/{id}', [ProductController::class, 'updateCart']);
Route::post('/cart/remove/{id}', [ProductController::class, 'removeFromCart']);
