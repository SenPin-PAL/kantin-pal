<?php $__env->startSection('title', 'Manajemen Akun Outlet'); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Manajemen Akun Outlet</h1>
        <div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Kembali</a>
            <a href="<?php echo e(route('admin.outlet-users.create')); ?>" class="btn btn-primary">Tambah Akun Outlet</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Username</th>
                        <th>Bertugas di Outlet</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $outletUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->username); ?></td>
                        <td><?php echo e($user->outlet->name ?? 'N/A'); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.outlet-users.edit', $user)); ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?php echo e(route('admin.outlet-users.destroy', $user)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="text-center" style="padding: 2rem;">Tidak ada data akun outlet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4"><?php echo e($outletUsers->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\Magang\Project Internship\kantin-pal\resources\views/admin/outlet-users/index.blade.php ENDPATH**/ ?>