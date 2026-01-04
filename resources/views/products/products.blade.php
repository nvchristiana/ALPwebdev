@extends('products.layout')

@section('title', 'Daftar Produk')

@section('content')

<h1 class="mb-4">Daftar Produk</h1>

<a href="{{ route('products.create') }}" class="btn btn-primary mb-4">
    + Tambah Produk
</a>

{{-- Pesan Sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- REVISI: Pesan Error (Untuk Stok Habis saat Add to Cart) --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Form Filter --}}
<form method="GET" action="{{ route('products.index') }}" class="row g-3 mb-4">

    <div class="col-md-4">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari produk..."
               value="{{ request('search') }}">
    </div>

    <div class="col-md-2">
        <input type="number"
               name="min_price"
               class="form-control"
               placeholder="Harga min"
               value="{{ request('min_price') }}">
    </div>

    <div class="col-md-2">
        <input type="number"
               name="max_price"
               class="form-control"
               placeholder="Harga max"
               value="{{ request('max_price') }}">
    </div>

    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="">Urutkan...</option>
            <option value="name_asc"  {{ request('sort')=='name_asc' ? 'selected' : '' }}>Nama A-Z</option>
            <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Nama Z-A</option>
            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga termurah</option>
            <option value="price_desc"{{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga termahal</option>
        </select>
    </div>

    <div class="col-md-1">
        <button type="submit" class="btn btn-primary w-100">
            Filter
        </button>
    </div>

</form>

{{-- List Produk --}}
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    @forelse ($products as $product)
        <div class="col">
            <div class="card h-100 shadow-sm">

                {{-- REVISI: Gambar Produk Bisa Diklik ke Halaman Detail --}}
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset('images/products/' . $product->id . '.jpg') }}"
                         class="card-img-top"
                         alt="{{ $product->name }}"
                         style="height: 200px; object-fit: cover;">
                </a>

                <div class="card-body">
                    {{-- REVISI: Judul Produk Bisa Diklik --}}
                    <h5 class="card-title">
                        <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-white">
                            {{ $product->name }}
                        </a>
                    </h5>

                    <p class="mb-1 fw-bold">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <p class="mb-1 text-warning small">
                        {{ $product->category->name ?? '-' }}
                    </p>

                    <p class="card-text small mb-2">
                        {{ $product->description }}
                    </p>

                    {{-- Tampilkan Sisa Stok --}}
                    <p class="mb-1 small {{ $product->stock > 0 ? 'text-success' : 'text-danger fw-bold' }}">
                        Sisa Stok: {{ $product->stock }}
                    </p>

                    {{-- Logika Tombol Cart --}}
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                + Add to Cart
                            </button>
                        </form>
                    @else
                        <div class="mt-3">
                            <button class="btn btn-secondary w-100" disabled>
                                Stok Habis
                            </button>
                        </div>
                    @endif
                    
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('products.edit', $product->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('products.delete', $product->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus produk ini?')">
                        @csrf
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p>Belum ada produk.</p>
        </div>
    @endforelse
</div>

@endsection