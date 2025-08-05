<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container">
    <h2>LOGIN</h2>
    
    
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
            <button type="submit" class="btn btn-primary btn-login ">Login</button>
        </div>
    </form>
</div>


<style>
/* .login-container {
    max-width: 450px;
    margin: 3rem auto;
    padding: 2rem;
    background: var(--white-color);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
} */
.login-container {
    max-width: 450px;
    width: 100%;
    margin: 3rem auto;
    margin-top: 6rem;
    padding: 2rem;
    /* Transparan buram dengan efek kaca */
    background: rgba(255, 255, 255, 0.6); /* Putih transparan */
    backdrop-filter: blur(10px); /* Efek buram */
    -webkit-backdrop-filter: blur(10px); /* Untuk Safari */

    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
}

.login-container h2 {
    text-align: center;
    margin-bottom: 1.5rem;
}
body {
    background-image: url('/storage/img/bg-login.png');
    background-size: cover; /* Lebih kecil, tidak dipotong */
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed; /* Biar tidak ikut scroll */
    background-color: #f2f2f2; /* Warna latar belakang pelengkap */
}

.form-group input,
.form-group button {
    width: 100%;
    box-sizing: border-box;
}
.btn-login {
    margin-top: 2rem;
    width: 100%; /* opsional, kalau belum penuh */
    display: block; /* pastikan full width berlaku */
}

.btn-primary {
    background-color: #0B257E;
    border: 2px solid #0B257E;
    color: white;
    padding: 0.75rem 1rem;
    font-weight: bold;
    transition: all 0.3s ease;
    width: 100%; /* opsional */
    display: block; /* opsional */
}

.btn-primary:focus,
.btn-primary:active {
    background-color: white;
    color: #0B257E;
    border: 2px solid #0B257E;
    outline: none;
    box-shadow: 0 0 0 2px rgba(11, 37, 126, 0.3); /* opsional efek glow saat fokus */
}
.btn-primary:hover {
    background-color: white;
    color: #0B257E;
    border: 2px solid #0B257E;
}




</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Kuliah\Magang\Project Internship\kantin-pal\resources\views/auth/login.blade.php ENDPATH**/ ?>