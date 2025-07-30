@extends('layouts.app')
@section('title', 'Pilih Laporan')
@section('content')
<div class="card">
    <div class="card-header">
        <h1>Pilih Jenis Laporan</h1>
        <a href="{{ route('outlet.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
    <div class="card-body">
        <div class="hub-container">
            <a href="{{ route('outlet.recap.purchases') }}" class="hub-button">
                <span class="hub-icon">👥</span>
                <h3 class="hub-title">Rekap Pembelian</h3>
                <p class="hub-description">Lihat ringkasan total pembelian berdasarkan Divisi.</p>
            </a>
            <a href="{{ route('outlet.recap.products') }}" class="hub-button">
                <span class="hub-icon">📦</span>
                <h3 class="hub-title">Rekap Produk</h3>
                <p class="hub-description">Lihat ringkasan total penjualan berdasarkan Produk.</p>
            </a>
        </div>
    </div>
</div>
@endsection
