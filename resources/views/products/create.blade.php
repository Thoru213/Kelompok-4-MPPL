@extends('layouts.app')

@section('content')
<h2>Tambah Produk Baru</h2>
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-2">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-2">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-2">
        <label>Harga</label>
        <input type="number" name="price" class="form-control">
    </div>
    <div class="mb-2">
        <label>Stok</label>
        <input type="number" name="stock" class="form-control">
    </div>
    <div class="mb-2">
        <label>Nama File Gambar (cth: semen.jpg)</label>
        <input type="text" name="image" class="form-control">
    </div>
    <button class="btn btn-success">Simpan</button>
</form>
@endsection