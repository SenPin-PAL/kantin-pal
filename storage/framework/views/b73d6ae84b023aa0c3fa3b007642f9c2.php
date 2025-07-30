<?php $__env->startSection('title', 'Edit Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Edit Menu: <?php echo e($product->name); ?></h1>
    </div>
    
    <form action="<?php echo e(route('outlet.products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Menu</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name', $product->name)); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo e(old('price', $product->price)); ?>" required>
            </div>
            <div class="form-group">
                <label for="stock">Stok Saat Ini</label>
                <input type="number" id="stock" name="stock" class="form-control" value="<?php echo e(old('stock', $product->stock)); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi (Opsional)</label>
                <textarea id="description" name="description" class="form-control"><?php echo e(old('description', $product->description)); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="image">Gambar Menu (Opsional)</label>
                <input type="file" id="image" name="image" class="form-control">
                <?php if($product->image): ?>
                    <div class="mt-2">
                        <small>Gambar Saat Ini:</small><br>
                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" width="150">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo e(route('outlet.products.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Office\KP\PROJEK\kantin-pal\resources\views/outlet/products/edit.blade.php ENDPATH**/ ?>