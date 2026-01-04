@extends('products.layout')

@section('title', 'Checkout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4">Checkout Pesanan</h2>

        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Ringkasan Belanja</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold fs-5">
                            <td colspan="2" class="text-end">Total Bayar:</td>
                            <td class="text-end text-primary">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

       
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Informasi Pengiriman</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Jalan, Nomor Rumah, Kota..." required></textarea>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">-- Pilih Cara Bayar --</option>
                            <option value="transfer_bca">Transfer Bank BCA</option>
                            <option value="transfer_mandiri">Transfer Bank Mandiri</option>
                            <option value="cod">COD (Bayar di Tempat)</option>
                            <option value="ewallet">GoPay / OVO</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            ✅ Konfirmasi & Bayar
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection