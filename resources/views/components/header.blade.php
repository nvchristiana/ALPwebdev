<div class="header-bar mb-4 py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        
        {{-- BAGIAN KIRI: Judul Logo --}}
        <a href="{{ route('products.index') }}" class="text-decoration-none text-white">
            <h1 class="m-0 fw-bold">Artwork</h1>
        </a>

        {{-- BAGIAN KANAN: Menu Cart & User --}}
        <div class="d-flex align-items-center gap-3">
            
            {{-- LOGIKA HITUNG JUMLAH BARANG (PHP Langsung) --}}
            @php
                $totalItems = 0;
                // Cek jika user sedang login, baru hitung keranjangnya
                if(Auth::check()) {
                    $totalItems = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                }
            @endphp

            {{-- 1. Tombol Cart (Keranjang) dengan BADGE --}}
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                <i class="bi bi-cart-fill"></i> Cart

                {{-- Jika jumlah barang lebih dari 0, munculkan angka merah --}}
                @if($totalItems > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $totalItems }}
                        <span class="visually-hidden">items</span>
                    </span>
                @endif
            </a>

            {{-- 2. Cek Status Login --}}
            @auth
                {{-- JIKA SUDAH LOGIN: Tampilkan Nama & Tombol Logout --}}
                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hi, {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('orders.history') }}">Riwayat Pesanan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                {{-- JIKA BELUM LOGIN: Tampilkan Tombol Login --}}
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
            @endauth

        </div>
    </div>
</div>