<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Dashboard Admin</h1>
        <div>
            
            <a href="<?php echo e(route('admin.orders.approved')); ?>" class="btn btn-primary">Lihat Pesanan & Pembayaran</a>
            <a href="<?php echo e(route('admin.recap')); ?>" class="btn btn-secondary">Rekap Transaksi</a>
            <a href="<?php echo e(route('admin.outlets.index')); ?>" class="btn btn-secondary">Manajemen Outlet</a>
            <a href="<?php echo e(route('admin.outlet-users.index')); ?>" class="btn btn-secondary">Akun Outlet</a>
            <a href="<?php echo e(route('admin.divisions.index')); ?>" class="btn btn-secondary">Manajemen Divisi</a>
        </div>
    </div>
    <div class="card-body">
        <h2>Pesanan Masuk (Menunggu Persetujuan)</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pemesan (Divisi)</th>
                        <th>Outlet Tujuan</th>
                        <th>Total Tagihan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pendingOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>#<?php echo e($order->id); ?></td>
                        <td><?php echo e($order->user->name); ?></td>
                        <td><?php echo e($order->outlet->name); ?></td>
                        <td>Rp <?php echo e(number_format($order->total_bill, 0, ',', '.')); ?></td>
                        <td>
                            
                            <form action="<?php echo e(route('admin.approveOrder', $order)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center" style="padding: 2rem;">Tidak ada pesanan yang menunggu persetujuan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>