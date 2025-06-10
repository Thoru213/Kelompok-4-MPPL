@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-20 px-8 rounded-2xl text-center mb-12 shadow-2xl">
        <h1 class="text-6xl font-extrabold mb-5 leading-tight tracking-tight">Membangun Impian Anda Dimulai di Sini</h1>
        <p class="text-xl font-light opacity-90 mb-10">Temukan bahan bangunan berkualitas tinggi dengan harga terbaik untuk setiap proyek Anda.</p>
        <a href="#products-list" class="inline-block bg-white text-blue-800 px-10 py-4 rounded-full text-lg font-bold hover:bg-gray-200 transition duration-300 shadow-xl transform hover:scale-105">Jelajahi Produk</a>
    </section>

    <form method="GET" action="{{ url('/') }}" class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-4xl font-bold text-gray-800" id="products-list">Daftar Produk</h2>
        <div class="relative w-full md:w-auto flex items-center gap-2">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="sort" onchange="this.form.submit()"
                    class="block appearance-none w-full bg-white border-2 border-gray-200 text-gray-700 py-3 px-5 pr-10 rounded-full leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent font-medium text-base shadow-sm">
                <option value="">Sortir Produk</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga (Termurah)</option>
                <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok (Terbanyak)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
    </form>

    @if(empty($products))
        <p class="text-center text-gray-600 text-xl mt-10">Produk tidak ditemukan.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-gray-200 transform hover:-translate-y-1">
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover object-center">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-2 truncate">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-blue-700 font-bold text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <a href="{{ url('/product/' . $product->id) }}" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition duration-300 text-base font-semibold shadow-md">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
