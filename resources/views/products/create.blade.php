@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Tombol Kembali ke Daftar Produk --}}
    <a href="{{ route('products.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-8 font-semibold transition duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Produk
    </a>

    <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 max-w-3xl mx-auto border border-gray-200">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center leading-tight">Formulir Tambah Produk Baru</h1>

        {{-- Menampilkan pesan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg relative mb-8" role="alert">
                <strong class="font-bold text-xl block mb-2">Oops! Ada beberapa masalah:</strong>
                <ul class="mt-3 list-disc list-inside text-lg">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- Token CSRF untuk keamanan --}}

            <div class="mb-6">
                <label for="name" class="block text-gray-800 text-xl font-semibold mb-3">Nama Produk</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-3 focus:ring-blue-400 focus:border-transparent text-gray-900 text-lg placeholder-gray-500 transition duration-200 ease-in-out"
                    placeholder="Contoh: Semen Tiga Roda 50kg" required>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-800 text-xl font-semibold mb-3">Deskripsi Produk</label>
                <textarea id="description" name="description" rows="6"
                        class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-3 focus:ring-blue-400 focus:border-transparent text-gray-900 text-lg placeholder-gray-500 transition duration-200 ease-in-out"
                        placeholder="Deskripsi lengkap tentang produk ini..." required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="image" class="block text-gray-800 text-xl font-semibold mb-3">Gambar Produk</label>
                <input type="file" id="image" name="image"
                    class="w-full text-gray-900 text-lg file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-lg file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer transition duration-200 ease-in-out">
                <p class="text-sm text-gray-600 mt-2">Format yang disarankan: JPG, PNG. Maks: 2MB.</p>
            </div>

            <div class="mb-6">
                <label for="price" class="block text-gray-800 text-xl font-semibold mb-3">Harga (Rp)</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-3 focus:ring-blue-400 focus:border-transparent text-gray-900 text-lg placeholder-gray-500 transition duration-200 ease-in-out"
                    placeholder="Contoh: 75000" required>
            </div>

            <div class="mb-8">
                <label for="stock" class="block text-gray-800 text-xl font-semibold mb-3">Stok</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0"
                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-3 focus:ring-blue-400 focus:border-transparent text-gray-900 text-lg placeholder-gray-500 transition duration-200 ease-in-out"
                    placeholder="Contoh: 100" required>
            </div>

            <div class="flex justify-center gap-6 mt-8">
                <button type="submit"
                        class="bg-blue-600 text-white px-10 py-4 rounded-full text-xl font-bold hover:bg-blue-700 transition duration-300 shadow-lg transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Simpan Produk
                </button>
                <a href="{{ route('products.index') }}"
                class="bg-gray-300 text-gray-800 px-10 py-4 rounded-full text-xl font-bold hover:bg-gray-400 transition duration-300 shadow-lg transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection