@extends('products.layout')

@section('title', 'Products')

@section('content')

<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
    + Tambah Produk
</a>

<h1 class="mb-4">Daftar Produk</h1>

<div class="row">
    @foreach ($products as $p)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">

                <img src="{{ asset('images/products/' . $p['image']) }}"
                     class="card-img-top"
                     style="height: 200px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title">{{ $p['name'] }}</h5>

                    <p class="card-text text-muted">
                        Rp {{ number_format($p['price']) }}
                    </p>

                    <a href="{{ route('products.edit', $p['id']) }}" 
                       class="btn btn-warning btn-sm me-2">
                       Edit
                    </a>

                    <a href="{{ route('products.delete', $p['id']) }}" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin hapus produk ini?')">
                       Delete
                    </a>
                </div>

            </div>
        </div>
    @endforeach
</div>

@endsection


