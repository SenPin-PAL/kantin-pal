<?php $__env->startSection('title', 'Manajemen Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Manajemen Menu</h1>
        <div>
            
            <a href="<?php echo e(route('outlet.dashboard')); ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
            
            
            <a href="<?php echo e(route('outlet.products.create')); ?>" class="btn btn-primary">Tambah Menu Baru</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->name); ?></td>
                        <td>Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></td>
                        <td><?php echo e($product->stock); ?></td>
                        <td>
                            <a href="<?php echo e(route('outlet.products.edit', $product)); ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?php echo e(route('outlet.products.destroy', $product)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 2rem;">
                            Anda belum memiliki menu.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            
            <?php if($products->hasPages()): ?>
                <?php echo e($products->links()); ?>

            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/outlet/products/index.blade.php ENDPATH**/ ?>