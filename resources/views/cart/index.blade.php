@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-8 text-center leading-tight">Keranjang Belanja Anda</h1>

    {{-- Tambahkan bagian untuk menampilkan pesan sukses atau error --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Perubahan utama: menggunakan $cartItems bukan $items --}}
    @if($cartItems->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center border border-gray-200">
            <p class="text-xl md:text-2xl text-gray-600 mb-6">Keranjang Anda kosong. Ayo mulai belanja sekarang!</p>
            <a href="{{ url('/') }}" class="inline-block bg-blue-600 text-white px-10 py-4 rounded-full text-lg md:text-xl font-bold hover:bg-blue-700 transition duration-300 shadow-md">Lanjut Belanja</a>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-gray-200">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-left text-sm md:text-base font-semibold uppercase tracking-wider">
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4 text-center">Jumlah</th>
                        <th class="px-6 py-4 text-right">Subtotal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0; // Inisialisasi total di sini
                    @endphp
                    {{-- Perubahan utama: menggunakan $cartItems bukan $items --}}
                    @foreach($cartItems as $item)
                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-gray-900 text-lg">
                            <div class="flex items-center">
                                {{-- Pastikan path gambar sesuai dengan struktur Anda --}}
                                @if($item->product->image) {{-- Mengakses properti image dari relasi product --}}
                                    <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-lg mr-4 shadow-sm">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg mr-4 flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                @endif
                                <div>
                                    <span class="font-semibold">{{ $item->product->name }}</span> {{-- Mengakses properti name dari relasi product --}}
                                    {{-- Bagian varian di sini perlu disesuaikan jika tidak ada di tabel carts atau products Anda --}}
                                    {{-- Jika tidak ada varian, baris ini bisa dihapus atau disesuaikan --}}
                                    @if(isset($item->variant) && $item->variant != 'Unit') {{-- Asumsi 'variant' ada sebagai kolom di carts atau bisa diakses --}}
                                         <p class="text-sm text-gray-500">Varian: {{ $item->variant }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-900 text-lg">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td> {{-- Mengakses harga dari relasi product --}}
                        <td class="px-6 py-4 text-gray-900 text-lg text-center">
                            {{-- Perubahan utama: menggunakan $item untuk Route Model Binding --}}
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center justify-center">
                                @csrf
                                @method('PUT') {{-- Penting untuk metode PUT --}}
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                    class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-center text-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    max="{{ $item->product->stock }}"> {{-- Batasi max sesuai stok produk --}}
                                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition-colors duration-200 shadow-sm">Ubah</button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-gray-900 text-lg text-right">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td> {{-- Hitung subtotal --}}
                        <td class="px-6 py-4 text-gray-900 text-lg text-center">
                            {{-- Perubahan utama: menggunakan $item untuk Route Model Binding --}}
                            <form action="{{ route('cart.remove', $item) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus produk ini dari keranjang?');">
                                @csrf
                                @method('DELETE') {{-- Penting untuk metode DELETE --}}
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition-colors duration-200 shadow-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @php
                        $grandTotal += ($item->product->price * $item->quantity); // Menghitung total keseluruhan
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end items-center bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
            <h3 class="text-4xl md:text-5xl font-extrabold text-gray-800 mr-6">Total:</h3>
            {{-- Perubahan utama: menggunakan $grandTotal yang dihitung di dalam loop --}}
            <span class="text-blue-700 font-bold text-4xl md:text-5xl">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="{{ url('/') }}" class="inline-block bg-gray-300 text-gray-800 px-8 py-3 rounded-full text-lg font-bold hover:bg-gray-400 transition duration-300 shadow-md transform hover:scale-105">Lanjut Belanja</a>
            <a href="{{ route('checkout.index') }}" class="bg-green-600 text-white px-8 py-3 rounded-full text-lg font-bold hover:bg-green-700 transition duration-300 shadow-md transform hover:scale-105">
                Lanjut ke Pembayaran
            </a>
        </div>
    @endif
</div>
@endsection