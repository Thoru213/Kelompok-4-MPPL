@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-8 text-center leading-tight">Keranjang Belanja Anda</h1>

    @if(empty($items))
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
                    @foreach($items as $item)
                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4 text-gray-900 text-lg">
                            <div class="flex items-center">
                                @if($item['product']->image)
                                    <img src="{{ asset('images/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-20 h-20 object-cover rounded-lg mr-4 shadow-sm">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg mr-4 flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                @endif
                                <div>
                                    <span class="font-semibold">{{ $item['product']->name }}</span>
                                    @if($item['variant'] && $item['variant'] != 'Unit')
                                        <p class="text-sm text-gray-500">Varian: {{ $item['variant'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-900 text-lg">Rp {{ number_format($item['product']->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-900 text-lg text-center">
                            <form action="{{ route('cart.update', $item['cartKey']) }}" method="POST" class="flex items-center justify-center">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                    class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-center text-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    max="{{ $item['product']->stock }}">
                                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition-colors duration-200 shadow-sm">Ubah</button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-gray-900 text-lg text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-900 text-lg text-center">
                            <form action="{{ route('cart.remove', $item['cartKey']) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition-colors duration-200 shadow-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end items-center bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
            <h3 class="text-4xl md:text-5xl font-extrabold text-gray-800 mr-6">Total:</h3>
            <span class="text-blue-700 font-bold text-4xl md:text-5xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="{{ url('/') }}" class="inline-block bg-gray-300 text-gray-800 px-8 py-3 rounded-full text-lg font-bold hover:bg-gray-400 transition duration-300 shadow-md transform hover:scale-105">Lanjut Belanja</a>
            <button class="bg-green-600 text-white px-8 py-3 rounded-full text-lg font-bold opacity-75 cursor-not-allowed shadow-md">
                Checkout (Simulasi)
            </button>
        </div>
    @endif
</div>
@endsection
