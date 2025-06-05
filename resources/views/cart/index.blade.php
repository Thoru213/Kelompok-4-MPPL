@extends('layouts.app')

@section('content')
<h2>Keranjang Belanja</h2>

@if(count($items) == 0)
    <p>Keranjang kosong.</p>
    <a href="/" class="btn btn-secondary">Kembali ke Produk</a>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item['product']->name }}</td>
                <td>Rp {{ number_format($item['product']->price) }}</td>
                <td>
                    <form action="/cart/update/{{ $item['product']->id }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width:60px;">
                        <button class="btn btn-sm btn-outline-secondary">Ubah</button>
                    </form>
                </td>
                <td>Rp {{ number_format($item['subtotal']) }}</td>
                <td>
                    <form action="/cart/remove/{{ $item['product']->id }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: Rp {{ number_format($total) }}</h4>
    <button class="btn btn-success" disabled>Checkout (Dummy)</button>
    <a href="/" class="btn btn-secondary">Lanjut Belanja</a>
@endif
@endsection