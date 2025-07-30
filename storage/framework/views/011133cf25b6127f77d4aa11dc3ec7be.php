<?php $__env->startSection('title', 'Dashboard Outlet'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="header-actions">
    <h1>Pesanan untuk Diproses</h1>
    <div>
        <a href="<?php echo e(route('outlet.products.index')); ?>" class="btn btn-secondary">Manajemen Menu</a>
        <a href="<?php echo e(route('outlet.transactions')); ?>" class="btn btn-secondary">Riwayat Transaksi</a>
    </div>
</div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pemesan (Divisi)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $activeOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td>#<?php echo e($order->id); ?></td>
        <td><?php echo e($order->user->name); ?></td>
        <td><span class="status status-<?php echo e($order->status); ?>"><?php echo e($order->status == 'approved' ? 'Baru Masuk' : 'Sedang Dibuat'); ?></span></td>
        <td>
            <?php if($order->status == 'approved'): ?>
                <form action="<?php echo e(route('outlet.orders.prepare', $order)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn btn-sm btn-primary">Terima Pesanan</button>
                </form>
            <?php elseif($order->status == 'preparing'): ?>
                <form action="<?php echo e(route('outlet.completeOrder', $order)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn btn-sm btn-success">Selesaikan</button>
                </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="4" class="text-center" style="padding: 2rem;">Tidak ada pesanan aktif.</td></tr>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/outlet/dashboard.blade.php ENDPATH**/ ?>