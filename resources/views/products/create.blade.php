@extends('products.layout')

@section('title', 'Tambah Produk')

@section('content')

<h1 class="mb-4">Tambah Produk</h1>

<div class="card p-4 shadow-sm">

    {{-- Tampilkan error jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        {{-- Nama Produk --}}
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        {{-- FITUR BARU: Stok --}}
        <div class="mb-3">
            <label class="form-label">Stok Barang</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        {{-- Nama File Gambar --}}
        <div class="mb-3">
            <label class="form-label">Nama File Gambar</label>
            <input type="text" name="image" class="form-control" placeholder="contoh: 10.jpg" value="{{ old('image') }}">
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Simpan Produk</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>

</div>

@endsection