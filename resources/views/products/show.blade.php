@extends('layouts.app')

@section('content')
<a href="{{ url('/') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-8 font-semibold transition duration-200">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    Kembali ke Daftar Produk
</a>

<div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col md:flex-row gap-10">
    <div class="md:w-1/2">
        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto max-h-96 object-contain object-center rounded-lg shadow-md border border-gray-200">
    </div>
    <div class="md:w-1/2 flex flex-col justify-between">
        <div>
            <h1 class="text-5xl font-extrabold text-gray-800 mb-4 leading-tight">{{ $product->name }}</h1>
            <p class="text-3xl text-blue-700 font-bold mb-8">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-gray-700 text-lg leading-relaxed mb-8">{{ $product->description }}</p>
            <div class="flex items-center text-gray-700 text-xl mb-6">
                <span class="font-semibold mr-3">Stok Tersedia:</span> <span id="productStock">{{ $product->stock }}</span> unit
            </div>
        </div>
        
        <button id="openAddToCartModal"
                class="bg-blue-600 text-white px-10 py-5 rounded-full text-xl font-bold hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300"
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->price }}"
                data-product-image="{{ asset('images/' . $product->image) }}"
                data-product-stock="{{ $product->stock }}">
            Tambah ke Keranjang
        </button>
    </div>
</div>
@endsection
