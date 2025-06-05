@extends('layouts.app')

@section('content')
    <section class="text-center">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang di GO-BLOCK</h1>
        <p class="text-lg text-gray-700">Temukan berbagai bahan bangunan berkualitas dengan harga terbaik.</p>
    </section>

    <section class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Contoh produk -->
        <div class="bg-white p-4 rounded shadow">
            <img src="{{ asset('images/semen.jpg') }}" alt="Semen" class="w-full h-48 object-cover mb-4">
            <h2 class="text-xl font-semibold">Semen 1 Sak</h2>
            <p class="text-gray-600">Rp10.000</p>
            <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Tambah ke Keranjang</button>
        </div>
        <!-- Tambahkan produk lainnya sesuai kebutuhan -->
    </section>
@endsection
