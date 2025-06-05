@extends('layouts.app')

@section('content')
    <section class="bg-blue-600 text-white py-16 rounded-lg text-center mb-8 shadow-lg">
        <h1 class="text-5xl font-extrabold mb-4">Membangun Impian Anda Dimulai di Sini</h1>
        <p class="text-xl">Temukan bahan bangunan berkualitas tinggi dengan harga terbaik.</p>
        <a href="#products-list" class="mt-8 inline-block bg-white text-blue-600 px-8 py-3 rounded-full text-lg font-bold hover:bg-gray-200 transition duration-300 shadow-md">Jelajahi Produk</a>
    </section>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800" id="products-list">Daftar Produk</h2>
        <div class="relative">
            <select name="sort" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                <option value="">Sortir Produk</option>
                <option value="name_asc">Nama (A-Z)</option>
                <option value="price_asc">Harga (Termurah)</option>
                <option value="stock_desc">Stok (Terbanyak)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @php
            $products = [
                ['id' => 1, 'name' => 'Semen Tiga Roda 50kg', 'price' => 75000, 'image' => 'semen.jpg', 'description' => 'Semen berkualitas tinggi untuk konstruksi kokoh.'],
                ['id' => 2, 'name' => 'Pasir Cor Kualitas A', 'price' => 30000, 'image' => 'pasir.jpg', 'description' => 'Pasir pilihan untuk adukan beton dan plesteran.'],
                ['id' => 3, 'name' => 'Batu Split 1/2', 'price' => 25000, 'image' => 'batu_split.jpg', 'description' => 'Batu pecah untuk campuran beton dan pondasi.'],
                ['id' => 4, 'name' => 'Paku Beton 5cm', 'price' => 5000, 'image' => 'paku.jpg', 'description' => 'Paku kuat untuk kebutuhan pemasangan material berat.'],
                ['id' => 5, 'name' => 'Cat Tembok Putih 5kg', 'price' => 120000, 'image' => 'cat.jpg', 'description' => 'Cat interior berkualitas dengan daya tutup sempurna.'],
                ['id' => 6, 'name' => 'Pipa PVC 2 Inci', 'price' => 45000, 'image' => 'pipa.jpg', 'description' => 'Pipa PVC standar SNI untuk instalasi air bersih.'],
            ];
        @endphp

        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <img src="{{ asset('images/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $product['name'] }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product['description'], 50) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-bold text-lg">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                        <a href="{{ url('/product/' . $product['id']) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 text-sm">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection