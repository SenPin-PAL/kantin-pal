@extends('layouts.app')

@section('title', 'Dashboard Divisi')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Riwayat Pesanan</h1>
        <a href="{{ route('divisi.createOrder') }}" class="btn btn-primary">Buat Pesanan Baru</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Outlet</th>
                        <th>Total Tagihan</th>
                        <th style="width: 40%;">Status Pesanan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
    @forelse ($myOrders as $order)
    <tr>
        <td>#{{ $order->id }}</td>
        <td>{{ $order->outlet->name }}</td>
        <td>Rp {{ number_format($order->total_bill, 0, ',', '.') }}</td>
        <td>
            @php
                $statusText = '';
                switch($order->status) {
                    case 'pending':
                        $statusText = 'Menunggu Konfirmasi';
                        break;
                    case 'approved':
                        $statusText = 'Diterima oleh Outlet';
                        break;
                    case 'preparing':
                        $statusText = 'Sedang Dibuat';
                        break;
                    case 'completed':
                        $statusText = 'Selesai';
                        break;
                    default:
                        $statusText = ucfirst($order->status);
                }
            @endphp
            <span class="status status-{{ $order->status }}">{{ $statusText }}</span>
        </td>
        <td>{{ $order->created_at->format('d M Y') }}</td>
    </tr>
    @empty
    <tr><td colspan="5" class="text-center" style="padding: 2rem;">Belum pernah membuat pesanan.</td></tr>
    @endforelse
</tbody>
            </table>
        </div>
    </div>
</div>
@endsection