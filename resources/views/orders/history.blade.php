@extends('products.layout')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h2 class="mb-4">Riwayat Pesanan Saya</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="alert alert-info text-center">
                Belum ada riwayat pesanan. <a href="{{ route('products.index') }}">Belanja dulu yuk!</a>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Order</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <ul class="mb-0 ps-3">
                                        @foreach($order->items as $item)
                                            <li>
                                                {{ $item->product->name }} 
                                                <small class="text-muted">x{{ $item->quantity }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-success">Berhasil Dibayar</span>
                                    <br>
                                    <small class="text-muted">{{ strtoupper($order->payment_method) }}</small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary">&laquo; Kembali Belanja</a>
            </div>
        @endif
    </div>
</div>
@endsection