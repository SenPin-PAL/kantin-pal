<?php $__env->startSection('title', 'Riwayat Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Riwayat Transaksi Selesai</h1>
        <a href="<?php echo e(route('outlet.dashboard')); ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
    <div class="card-body">
        <?php $__empty_1 = true; $__currentLoopData = $completedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="recap-item">
                <div class="recap-header" data-toggle="recap-<?php echo e($order->id); ?>">
                    <div class="recap-info">
                        <strong>Pesanan #<?php echo e($order->id); ?></strong>
                        <span class="recap-meta">Oleh: <?php echo e($order->user->name); ?></span>
                    </div>
                    <div class="recap-summary">
                        <span>Total: <strong>Rp <?php echo e(number_format($order->total_bill, 0, ',', '.')); ?></strong></span>
                        <span class="recap-date"><?php echo e($order->updated_at->format('d M Y, H:i')); ?></span>
                        <span class="recap-arrow">▼</span>
                    </div>
                </div>
                <div class="recap-details" id="recap-<?php echo e($order->id); ?>">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->product->name); ?></td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td>Rp <?php echo e(number_format($item->price_per_item, 0, ',', '.')); ?></td>
                                    <td>Rp <?php echo e(number_format($item->price_per_item * $item->quantity, 0, ',', '.')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center" style="padding: 2rem;">Belum ada transaksi yang selesai.</p>
        <?php endif; ?>

        <div class="mt-4">
            <?php echo e($completedOrders->links()); ?>

        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const recapHeaders = document.querySelectorAll('.recap-header');
    recapHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const targetId = this.getAttribute('data-toggle');
            const detailElement = document.getElementById(targetId);
            const arrow = this.querySelector('.recap-arrow');

            if (detailElement.style.display === 'block') {
                detailElement.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
            } else {
                detailElement.style.display = 'block';
                arrow.style.transform = 'rotate(180deg)';
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/outlet/transactions.blade.php ENDPATH**/ ?>