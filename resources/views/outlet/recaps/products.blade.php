@extends('layouts.app')
@section('title', 'Rekap Produk')
@section('content')
<div class="card">
    <div class="card-header">
        <h1>Rekap Penjualan per Produk</h1>
        <a href="{{ route('outlet.transactions') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <div class="filter-bar">
            <form action="{{ route('outlet.recap.products') }}" method="GET" class="d-flex">
                <select name="filter" class="form-control" onchange="this.form.submit()">
                    <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                </select>
            </form>
            <a href="{{ route('outlet.recap.products.export', ['filter' => $filter]) }}" class="btn btn-success">Cetak Rekap (CSV)</a>
        </div>
        <hr class="my-4">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Total Terjual (Qty)</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recap as $productName => $data)
                    <tr>
                        <td>{{ $productName }}</td>
                        <td>{{ $data['total_quantity'] }}</td>
                        <td>Rp {{ number_format($data['total_sales'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center" style="padding: 2rem;">Tidak ada data pada periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
