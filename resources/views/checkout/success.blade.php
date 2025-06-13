@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center border border-gray-200">
        <svg class="mx-auto h-24 w-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mt-6 mb-4 leading-tight">Pesanan Berhasil Dibuat!</h1>
        <p class="text-xl md:text-2xl text-gray-700 mb-8">Terima kasih atas pesanan Anda. Detail pesanan Anda adalah sebagai berikut:</p>

        <div class="text-left mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Detail Pesanan #{{ $order->id }}</h2>
            <p class="text-lg text-gray-700 mb-2"><strong>Nama Pelanggan:</strong> {{ $order->customer_name }}</p>
            <p class="text-lg text-gray-700 mb-2"><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p class="text-lg text-gray-700 mb-2"><strong>Nomor Telepon:</strong> {{ $order->customer_phone ?? '-' }}</p>
            <p class="text-lg text-gray-700 mb-2"><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}</p>
            <p class="text-lg text-gray-700 mb-2"><strong>Status Pesanan:</strong> <span class="font-semibold text-blue-600">{{ ucfirst($order->status) }}</span></p>
            <p class="text-lg text-gray-700 font-bold mb-4"><strong>Total Pembayaran:</strong> <span class="text-green-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">Item Pesanan:</h3>
            <ul class="list-disc pl-5">
                @foreach($order->items as $item)
                    <li class="text-lg text-gray-700">{{ $item->product_name }} - {{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }} = Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</li>
                @endforeach
            </ul>
        </div>

        <a href="{{ url('/') }}" class="inline-block bg-blue-600 text-white px-10 py-4 rounded-full text-lg md:text-xl font-bold hover:bg-blue-700 transition duration-300 shadow-md">Kembali ke Beranda</a>
        {{-- Anda bisa menambahkan link ke halaman riwayat pesanan jika ada --}}
        {{-- <a href="{{ route('orders.show', $order->id) }}" class="ml-4 inline-block bg-gray-300 text-gray-800 px-10 py-4 rounded-full text-lg md:text-xl font-bold hover:bg-gray-400 transition duration-300 shadow-md">Lihat Detail Pesanan</a> --}}
    </div>
</div>
@endsection