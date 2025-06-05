@extends('layouts.app')

@section('content')
    <a href="{{ url('/') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6 transition duration-200">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Produk
    </a>

    <div class="bg-white rounded-lg shadow-xl p-6 flex flex-col md:flex-row gap-8">
        <div class="md:w-1/2">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg shadow-md">
        </div>
        <div class="md:w-1/2 flex flex-col justify-between">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-800 mb-4">{{ $product->name }}</h1>
                <p class="text-2xl text-blue-600 font-bold mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-gray-700 leading-relaxed mb-6">{{ $product->description }}</p>
                <div class="flex items-center text-gray-700 text-lg mb-4">
                    <span class="font-semibold mr-2">Stok Tersedia:</span> {{ $product->stock }} unit
                </div>
            </div>
            <button class="bg-blue-600 text-white px-8 py-4 rounded-lg text-xl font-bold hover:bg-blue-700 transition duration-300 w-full md:w-auto">
                Tambah ke Keranjang
            </button>
        </div>
    </div>
@endsection