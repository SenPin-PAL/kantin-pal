@extends('layouts.app')
@section('title', 'Rekap Pembelian')
@section('content')
<div class="card">
    <div class="card-header">
        <h1>Rekap Pembelian per Divisi</h1>
        <a href="{{ route('outlet.transactions') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <div class="filter-bar">
            <form action="{{ route('outlet.recap.purchases') }}" method="GET" class="d-flex">
                <select name="filter" class="form-control" onchange="this.form.submit()">
                    <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                </select>
            </form>
            <a href="{{ route('outlet.recap.purchases.export', ['filter' => $filter]) }}" class="btn btn-success">Cetak Rekap (CSV)</a>
        </div>
        <hr class="my-4">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Divisi</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recap as $divisionName => $data)
                    <tr>
                        <td>{{ $divisionName }}</td>
                        <td>{{ $data['total_transactions'] }}</td>
                        <td>Rp {{ number_format($data['total_purchase'], 0, ',', '.') }}</td>
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
