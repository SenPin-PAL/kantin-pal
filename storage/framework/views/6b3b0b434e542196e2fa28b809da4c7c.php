<?php $__env->startSection('title', 'Manajemen Profil'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-4">
    <?php if(Auth::user()->role == 'admin'): ?>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">← Kembali ke Dashboard Admin</a>
    <?php elseif(Auth::user()->role == 'outlet'): ?>
        <a href="<?php echo e(route('outlet.dashboard')); ?>" class="btn btn-secondary">← Kembali ke Dashboard Outlet</a>
    <?php elseif(Auth::user()->role == 'divisi'): ?>
        <a href="<?php echo e(route('divisi.dashboard')); ?>" class="btn btn-secondary">← Kembali ke Dashboard Divisi</a>
    <?php endif; ?>
</div>


<div class="profile-grid">
    
    <div class="card">
        <div class="card-header">
            <h2>Informasi Profil</h2>
        </div>
        
        <?php if(session('success')): ?>
            <div class="alert alert-success m-4"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <form action="<?php echo e(route('profile.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username (untuk login)</label>
                    <input type="text" id="username" name="username" class="form-control" value="<?php echo e(old('username', $user->username)); ?>" required>
                </div>
                 <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo e($user->email); ?>" disabled readonly>
                    <small class="text-muted">Email tidak dapat diubah.</small>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Profil</button>
            </div>
        </form>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h2>Ubah Password</h2>
        </div>
         
        <?php if(session('success_password')): ?>
            <div class="alert alert-success m-4"><?php echo e(session('success_password')); ?></div>
        <?php endif; ?>
        <form action="<?php echo e(route('profile.password.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div class="card-body">
                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\Magang\Project Internship\kantin-pal\resources\views/profile/edit.blade.php ENDPATH**/ ?>