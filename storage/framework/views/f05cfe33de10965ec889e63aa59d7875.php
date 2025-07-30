<?php $__env->startSection('title', 'Dashboard Divisi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Riwayat Pesanan Saya</h1>
        <a href="<?php echo e(route('divisi.createOrder')); ?>" class="btn btn-primary">Buat Pesanan Baru</a>
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
    <?php $__empty_1 = true; $__currentLoopData = $myOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td>#<?php echo e($order->id); ?></td>
        <td><?php echo e($order->outlet->name); ?></td>
        <td>Rp <?php echo e(number_format($order->total_bill, 0, ',', '.')); ?></td>
        <td>
            <?php
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
            ?>
            <span class="status status-<?php echo e($order->status); ?>"><?php echo e($statusText); ?></span>
        </td>
        <td><?php echo e($order->created_at->format('d M Y')); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="5" class="text-center" style="padding: 2rem;">Anda belum pernah membuat pesanan.</td></tr>
    <?php endif; ?>
</tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Office\KP\PROJEK\kantin-pal\resources\views/divisi/dashboard.blade.php ENDPATH**/ ?>