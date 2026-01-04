@extends('products.layout')

@section('title', 'Keranjang Belanja')

@section('content')

<h1 class="mb-4">Keranjang Belanja</h1>

{{-- Pesan Sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- REVISI: Tambahkan Pesan Error (Untuk Stok Habis) --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        @if($cartItems->isEmpty())
            <div class="text-center my-5">
                <h4>Keranjang kamu masih kosong 😢</h4>
                <p class="text-muted">Yuk, isi dengan karya seni favoritmu!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                    &laquo; Belanja Sekarang
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th style="width: 15%;">Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cartItems as $item)
                            @php 
                                $subtotal = $item->product->price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- Gambar Produk --}}
                                        <img src="{{ asset('images/products/' . $item->product->id . '.jpg') }}" 
                                             alt="" 
                                             style="width: 60px; height: 60px; object-fit: cover;" 
                                             class="me-3 rounded border">
                                    
                                        <div>
                                            <span class="fw-bold">{{ $item->product->name }}</span>
                                            <br>
                                            <small class="text-muted">{{ $item->product->category->name ?? 'Art' }}</small>
                                            {{-- Tampilkan sisa stok di keranjang juga biar informatif --}}
                                            <br>
                                            <small class="text-danger">Sisa Stok: {{ $item->product->stock }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                <td>
                                    {{-- FORM UPDATE QUANTITY --}}
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                               min="1" max="{{ $item->product->stock }}" 
                                               class="form-control form-control-sm me-2 text-center" style="width: 60px;">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Update Jumlah">
                                            Update
                                        </button>
                                    </form>
                                </td>
                                <td class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td>
                                    {{-- FORM DELETE --}}
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold fs-5">Total Belanja:</td>
                            <td class="fw-bold fs-5 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</td> 
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    &laquo; Lanjut Belanja
                </a>
                
                {{-- TOMBOL CHECKOUT --}}
                <a href="{{ route('checkout') }}" class="btn btn-success px-4 py-2 fw-bold">
                    Checkout Sekarang &raquo;
                </a>
            </div>
        @endif
    </div>
</div>

@endsection