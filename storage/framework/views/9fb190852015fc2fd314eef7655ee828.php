<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container">
    <h2>Login ke Akun Anda</h2>
    
    
    <form method="POST" action="<?php echo e(route('login')); ?>">
        
        
        <?php echo csrf_field(); ?>

        <div class="form-group">
            
            <label for="username">Username</label>
            
            <input id="username" type="text" name="username" class="form-control" value="<?php echo e(old('username')); ?>" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</div>


<style>
.login-container {
    max-width: 450px;
    margin: 3rem auto;
    padding: 2rem;
    background: var(--white-color);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
}
.login-container h2 {
    text-align: center;
    margin-bottom: 1.5rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\Magang\Project Internship\kantin-pal\resources\views/auth/login.blade.php ENDPATH**/ ?>