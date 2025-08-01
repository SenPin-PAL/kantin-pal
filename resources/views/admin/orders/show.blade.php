@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h1>Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        <a href="{{ route('admin.orders.approved') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
    </div>
</div>

<div class="details-grid">
    {{-- Kolom Kiri: Info & Form Pembayaran --}}
    <div class="card">
        <div class="card-body">
            <h3>Informasi Tagihan</h3>
            <ul class="info-list">
                <li><span>Total Tagihan:</span> <strong>Rp {{ number_format($order->total_bill, 0, ',', '.') }}</strong></li>
                <li><span>Sudah Dibayar:</span> <span class="text-success">Rp {{ number_format($order->paid_amount, 0, ',', '.') }}</span></li>
                <li><span>Sisa Tagihan:</span> <span class="text-danger">Rp {{ number_format($order->remaining_bill, 0, ',', '.') }}</span></li>
                <li><span>Status Pembayaran:</span> <span class="status status-{{ $order->payment_status }}">{{ $order->payment_status }}</span></li>
            </ul>

            <hr class="my-4">

            @if($order->remaining_bill > 0)
            <h3>Catat Pembayaran Baru</h3>
            <form action="{{ route('admin.orders.payments.store', $order) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="amount">Jumlah Pembayaran</label>
                    <input type="number" name="amount" id="amount" class="form-control" step="1000" max="{{ $order->remaining_bill }}" required>
                </div>
                <div class="form-group">
                    <label for="payment_date">Tanggal Bayar</label>
                    <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="notes">Catatan (Opsional)</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
            </form>
            @else
            <div class="alert alert-success">Pesanan sudah lunas.</div>
            @endif
        </div>
    </div>

    {{-- Kolom Kanan: Riwayat Pembayaran & Detail Item --}}
    <div class="card">
        <div class="card-body">
            <h3>Riwayat Pembayaran</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->payments as $payment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Belum ada pembayaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            <h3>Item yang Dipesan</h3>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price_per_item, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection