<?php $__env->startSection('title', 'Pilih Laporan'); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Pilih Jenis Laporan</h1>
        <a href="<?php echo e(route('outlet.dashboard')); ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
    <div class="card-body">
        <div class="hub-container">
            <a href="<?php echo e(route('outlet.recap.purchases')); ?>" class="hub-button">
                <span class="hub-icon">👥</span>
                <h3 class="hub-title">Rekap Pembelian</h3>
                <p class="hub-description">Lihat ringkasan total pembelian berdasarkan Divisi.</p>
            </a>
            <a href="<?php echo e(route('outlet.recap.products')); ?>" class="hub-button">
                <span class="hub-icon">📦</span>
                <h3 class="hub-title">Rekap Produk</h3>
                <p class="hub-description">Lihat ringkasan total penjualan berdasarkan Produk.</p>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/outlet/transactions.blade.php ENDPATH**/ ?>