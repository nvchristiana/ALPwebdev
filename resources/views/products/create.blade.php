@extends('products.layout')

@section('title', 'Tambah Produk')

@section('content')

<h1 class="mb-4">Tambah Produk</h1>

<div class="card p-4 shadow-sm">

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan Produk</button>
    </form>

</div>

@endsection


