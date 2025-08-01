<?php $__env->startSection('title', 'Edit Akun Outlet'); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header"><h1>Edit Akun Outlet</h1></div>
    <form action="<?php echo e(route('admin.outlet-users.update', $outletUser)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <div class="card-body">
            <?php echo $__env->make('admin.outlet-users._form', ['isEdit' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo e(route('admin.outlet-users.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\Magang\Project Internship\kantin-pal\resources\views/admin/outlet-users/edit.blade.php ENDPATH**/ ?>