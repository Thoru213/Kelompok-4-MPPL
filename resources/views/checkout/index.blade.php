@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-8 text-center leading-tight">Detail Pengiriman & Pembayaran</h1>

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
    {{-- Menampilkan error validasi dari controller --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-200">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-left text-sm font-semibold uppercase tracking-wider">
                        <th class="px-4 py-3">Produk</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3 text-right">Harga Satuan</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-3 text-gray-900 text-lg">
                            <div class="w-24 aspect-w-16 aspect-h-9 mr-3">
                                @if($item->product->image)
                                    <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}"
         class="object-cover rounded-md shadow-sm w-full h-full">    
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-md mr-3 flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                @endif
                                <span>{{ $item->product->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-700 text-lg text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 text-gray-700 text-lg text-right">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-gray-900 text-lg text-right">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right text-2xl font-bold text-gray-800">Total:</td>
                        <td class="px-4 py-3 text-right text-blue-700 font-bold text-2xl">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h2 class="text-3xl font-bold text-gray-800 mb-6 mt-10">Informasi Pengiriman</h2>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="customer_name" class="block text-gray-700 text-lg font-semibold mb-2">Nama Lengkap:</label>
                <input type="text" id="customer_name" name="customer_name"
                       value="{{ old('customer_name', $user ? $user->name : '') }}"
                       class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                       required>
            </div>

            <div class="mb-6">
                <label for="customer_email" class="block text-gray-700 text-lg font-semibold mb-2">Email:</label>
                <input type="email" id="customer_email" name="customer_email"
                       value="{{ old('customer_email', $user ? $user->email : '') }}"
                       class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                       required>
            </div>

            <div class="mb-6">
                <label for="customer_phone" class="block text-gray-700 text-lg font-semibold mb-2">Nomor Telepon (Opsional):</label>
                <input type="tel" id="customer_phone" name="customer_phone"
                       value="{{ old('customer_phone') }}"
                       class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg">
            </div>

            <div class="mb-8">
                <label for="shipping_address" class="block text-gray-700 text-lg font-semibold mb-2">Alamat Lengkap Pengiriman:</label>
                <textarea id="shipping_address" name="shipping_address" rows="4"
                          class="w-full px-5 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                          required>{{ old('shipping_address') }}</textarea>
            </div>

            {{-- Bagian Simulasi Pembayaran --}}
            <h2 class="text-3xl font-bold text-gray-800 mb-6 mt-10">Metode Pembayaran</h2>
            <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-700 text-lg mb-4">Untuk tujuan simulasi ini, kita akan menganggap pembayaran berhasil saat Anda menekan tombol "Lakukan Pembayaran".</p>
                <div class="flex items-center mb-4">
                    <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" class="h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                    <label for="bank_transfer" class="ml-3 text-gray-700 text-lg font-medium">Transfer Bank (Simulasi)</label>
                </div>
                {{-- Anda bisa menambahkan opsi pembayaran lain di sini --}}
            </div>


            <div class="flex justify-between items-center mt-10">
                <a href="{{ route('cart.index') }}" class="inline-block bg-gray-300 text-gray-800 px-8 py-4 rounded-full text-lg font-bold hover:bg-gray-400 transition duration-300 shadow-md">Kembali ke Keranjang</a>
                <button type="submit" class="bg-green-600 text-white px-10 py-5 rounded-full text-xl font-bold hover:bg-green-700 transition duration-300 shadow-lg transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300">
                    Lakukan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection