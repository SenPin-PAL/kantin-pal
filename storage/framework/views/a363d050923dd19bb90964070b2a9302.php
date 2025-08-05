<?php $__env->startSection('title', 'Rekap Pembelian'); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Rekap Pembelian per Divisi</h1>
        <a href="<?php echo e(route('outlet.transactions')); ?>" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <div class="filter-bar">
            <form action="<?php echo e(route('outlet.recap.purchases')); ?>" method="GET" class="d-flex">
                <select name="filter" class="form-control" onchange="this.form.submit()">
                    <option value="today" <?php echo e($filter == 'today' ? 'selected' : ''); ?>>Hari Ini</option>
                    <option value="week" <?php echo e($filter == 'week' ? 'selected' : ''); ?>>Minggu Ini</option>
                    <option value="month" <?php echo e($filter == 'month' ? 'selected' : ''); ?>>Bulan Ini</option>
                </select>
            </form>
            <a href="<?php echo e(route('outlet.recap.purchases.export', ['filter' => $filter])); ?>" class="btn btn-success">Cetak Rekap (CSV)</a>
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
                    <?php $__empty_1 = true; $__currentLoopData = $recap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $divisionName => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($divisionName); ?></td>
                        <td><?php echo e($data['total_transactions']); ?></td>
                        <td>Rp <?php echo e(number_format($data['total_purchase'], 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-center" style="padding: 2rem;">Tidak ada data pada periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/outlet/recaps/purchases.blade.php ENDPATH**/ ?>