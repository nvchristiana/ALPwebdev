<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0 0 2rem 0;
            background: radial-gradient(circle at top left, #071427, #2a0000 55%, #000000 100%);
            color: #ffffff;
        }

        .container {
            max-width: 960px;
        }

        /* --- Header Styles --- */
        .header-bar {
            background: rgba(5, 5, 20, 0.95);      
            border-bottom: 1px solid #b33;
            padding: 0.75rem 0;
            position: sticky; 
            top: 0; 
            z-index: 1000;
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Revisi: Agar logo kiri, menu kanan */
        }

        .header-title {
            margin: 0;
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            color: #ffffff;
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.8), 0 0 8px rgba(255, 255, 255, 0.3);
            text-decoration: none;
        }
        .header-title:hover {
            color: #ffcccc;
        }

        /* --- General UI Styles --- */
        .card {
            background-color: rgba(43, 0, 0, 0.92);   
            color: #ffffff;
            border: 1px solid #660000;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .btn-primary {
            background: linear-gradient(90deg, #0c3b8b, #800000);
            border-color: #800000;
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #1450b3, #a00000);
            border-color: #a00000;
        }

        .btn-warning {
            background-color: #cc5500;
            border-color: #cc5500;
            color: #ffffff;
        }
        .btn-warning:hover {
            background-color: #e06a10;
            border-color: #e06a10;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #520303;
            border-color: #b30000;
            color: white;
        }
        .btn-danger:hover {
            background-color: #d00000;
            border-color: #d00000;
        }

        .btn-outline-light {
            border-color: rgba(255,255,255,0.5);
            color: #fff;
        }
        .btn-outline-light:hover {
            background-color: rgba(255,255,255,0.1);
            border-color: #fff;
        }

        .table {
            color: #ffffff;
        }
        .table thead {
            background-color: #1b2136;
        }
        .table tbody tr {
            background-color: rgba(43, 0, 0, 0.9);
        }
        .table tbody tr:nth-child(even) {
            background-color: rgba(15, 22, 46, 0.9);
        }

        input.form-control,
        textarea.form-control,
        select.form-select {
            background-color: #1d2236;
            color: #ffffff;
            border: 1px solid #4a506e;
        }

        input.form-control::placeholder,
        textarea.form-control::placeholder {
            color: #c7c7c7;
        }

        input.form-control:focus,
        textarea.form-control:focus,
        select.form-select:focus {
            background-color: #252b45;
            color: #ffffff;
            border-color: #ff6666;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 102, 0.25);
        }

        .page-padding {
            padding: 1.5rem 1rem 2rem;
        }

        .dropdown-menu {
            background-color: #1d2236;
            border: 1px solid #4a506e;
        }
        .dropdown-item {
            color: #ffffff;
        }
        .dropdown-item:hover {
            background-color: #252b45;
            color: #ffffff;
        }
        .dropdown-divider {
            border-top: 1px solid #4a506e;
        }
    </style>
</head>

<body>
    
    {{-- HEADER LANGSUNG DISINI (Agar Menu Muncul) --}}
    <nav class="header-bar">
        <div class="container header-inner">
            {{-- LOGO / JUDUL --}}
            <a href="{{ route('products.index') }}" class="header-title">
                Artwork
            </a>

            <div class="d-flex align-items-center gap-3">
                @auth
                    {{-- TOMBOL KERANJANG --}}
                    @php
                        // Hitung jumlah keranjang manual disini agar badge muncul
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                    @endphp
                    
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
                        <i class="bi bi-cart-fill me-1"></i> Cart
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- DROPDOWN MENU USER (EDIT PROFIL ADA DISINI) --}}
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Hi, {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear me-2"></i> Edit Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.history') }}">
                                    <i class="bi bi-clock-history me-2"></i> Riwayat Pesanan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    {{-- JIKA BELUM LOGIN --}}
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- KONTEN HALAMAN --}}
    <div class="page-padding">
        <div class="container mt-3">
            @yield('content')
        </div>
    </div>

    {{-- Script Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>