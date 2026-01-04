@extends('products.layout')

@section('title', $product->name)

@section('content')

<div class="container py-4">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mb-4">
        &laquo; Kembali ke Daftar Produk
    </a>

    {{-- Pesan Sukses/Error (jika ada) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- BAGIAN 1: DETAIL PRODUK --}}
    <div class="card shadow-sm mb-5">
        <div class="row g-0">
            {{-- Kolom Kiri: Gambar --}}
            <div class="col-md-5">
                <img src="{{ asset('images/products/' . $product->image) }}" 
                     class="img-fluid rounded-start w-100 h-100" 
                     style="object-fit: cover; min-height: 400px;"
                     alt="{{ $product->name }}">
            </div>
            
            {{-- Kolom Kanan: Info & Tombol Beli --}}
            <div class="col-md-7">
                <div class="card-body p-4">
                    <div class="mb-2">
                        <span class="badge bg-secondary">{{ $product->category->name ?? 'Art' }}</span>
                    </div>

                    <h1 class="card-title fw-bold">{{ $product->name }}</h1>
                    
                    <h2 class="text-primary fw-bold my-3">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </h2>

                    {{-- Info Stok --}}
                    <p class="fs-5 {{ $product->stock > 0 ? 'text-success' : 'text-danger fw-bold' }}">
                        Status: {{ $product->stock > 0 ? 'Tersedia' : 'Stok Habis' }} 
                        (Sisa: {{ $product->stock }})
                    </p>

                    <p class="card-text text-muted mb-4" style="line-height: 1.8;">
                        {{ $product->description }}
                    </p>

                    <hr>

                    {{-- Tombol Beli (Logic Stok) --}}
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                + Masukkan Keranjang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg w-100 py-3" disabled>
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: REVIEW & RATING --}}
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4 border-bottom pb-2">Ulasan Pembeli ({{ $product->reviews->count() }})</h3>
        </div>

        {{-- Daftar Review Orang Lain --}}
        <div class="col-md-7">
            @forelse($product->reviews as $review)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold">{{ $review->user->name }}</h6>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        
                        {{-- Bintang Rating --}}
                        <div class="text-warning mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}">★</i>
                            @endfor
                            <span class="text-muted small">({{ $review->rating }}/5)</span>
                        </div>

                        <p class="card-text">{{ $review->comment }}</p>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    Belum ada ulasan untuk produk ini. Jadilah yang pertama mereview!
                </div>
            @endforelse
        </div>

        {{-- Form Tulis Review (Hanya muncul jika Login) --}}
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Tulis Ulasan Kamu</h5>

                    @auth
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <select name="rating" class="form-select" required>
                                    <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                    <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                    <option value="3">⭐⭐⭐ (Biasa)</option>
                                    <option value="2">⭐⭐ (Kurang)</option>
                                    <option value="1">⭐ (Buruk)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Komentar</label>
                                <textarea name="comment" class="form-control" rows="3" placeholder="Ceritakan pengalamanmu..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-dark w-100">Kirim Ulasan</button>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <p>Silakan login untuk memberikan ulasan.</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login Disini</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

</div>

@endsection