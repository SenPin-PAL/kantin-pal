<div class="form-group">
    <label for="name">Nama Lengkap Pengguna</label>
    <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name', $outletUser->name ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="username">Username (untuk login)</label>
    <input type="text" id="username" name="username" class="form-control" value="<?php echo e(old('username', $outletUser->username ?? '')); ?>" required>
</div>

<div class="form-group">
    <label for="email">Alamat Email (Opsional)</label>
    <input type="email" id="email" name="email" class="form-control" value="<?php echo e(old('email', $outletUser->email ?? '')); ?>">
</div>

<div class="form-group">
    <label for="outlet_id">Ditugaskan di Outlet</label>
    <select name="outlet_id" id="outlet_id" class="form-control" required>
        <option value="">-- Pilih Outlet --</option>
        <?php $__currentLoopData = $outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($outlet->id); ?>" <?php echo e((old('outlet_id', $outletUser->outlet_id ?? '') == $outlet->id) ? 'selected' : ''); ?>>
                <?php echo e($outlet->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<hr style="margin: 2rem 0;">

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" class="form-control" <?php echo e(empty($isEdit) ? 'required' : ''); ?>>
    <?php if(!empty($isEdit)): ?>
        <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="password_confirmation">Konfirmasi Password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" <?php echo e(empty($isEdit) ? 'required' : ''); ?>>
</div>
<?php /**PATH E:\Kuliah\Magang\Project Internship\kantin-pal\resources\views/admin/outlet-users/_form.blade.php ENDPATH**/ ?>