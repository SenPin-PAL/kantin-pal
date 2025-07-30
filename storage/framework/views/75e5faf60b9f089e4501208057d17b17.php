<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Aplikasi POS'); ?> - POS App</title>
    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>
    <div id="app">
        <header class="navbar">
            <div class="container">
                <a href="/" class="navbar-brand">POS App</a>
                <nav>
                    <?php if(auth()->guard()->check()): ?>
                        <span class="navbar-user">Halo, <?php echo e(Auth::user()->name); ?> (<?php echo e(ucfirst(Auth::user()->role)); ?>)</span>
                        
                        
                        <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-sm btn-secondary" style="margin-right: 0.5rem;">Profil</a>
                        
                        <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    <?php endif; ?>
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>

        <main class="main-content">
            <div class="container">
                
                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-left: 1rem;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

        <footer class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> Kantin POS. All rights reserved.</p>
        </footer>
    </div>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Office\KP\PROJEK\kantin-pal\resources\views/layouts/app.blade.php ENDPATH**/ ?>