@extends('products.layout')

@section('title', 'Edit Produk')

@section('content')

<h1 class="mb-4">Edit Produk #{{ $product['id'] }}</h1>

<div class="card p-4 shadow-sm">

    <form action="{{ route('products.update', $product['id']) }}" method="POST">
        @csrf
        @method('POST') {{-- karena AFL1 belum pakai PUT --}}

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" value="{{ $product['name'] }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" value="{{ $product['price'] }}" class="form-control">
        </div>

        <button class="btn btn-warning">Update Produk</button>
    </form>

</div>

@endsection
