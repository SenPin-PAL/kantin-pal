<?php $__env->startSection('title', 'Buat Pesanan Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Buat Pesanan Baru</h1>
    </div>
    <form action="<?php echo e(route('divisi.storeOrder')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card-body">
            
            <div class="product-grid">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="<?php echo e($product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text= '); ?>" alt="<?php echo e($product->name); ?>">
                        </div>
                        <div class="product-card-body">
                            <h3><?php echo e($product->name); ?></h3>
                            <p class="outlet-name"><?php echo e($product->description); ?></p>
                            <p class="outlet-name"><?php echo e($product->outlet->name); ?></p>
                            <p class="stock-info">Stok: <?php echo e($product->stock); ?></p>
                        </div>
                        <div class="product-card-footer">
                            
                            <input type="hidden" name="products[<?php echo e($loop->index); ?>][id]" value="<?php echo e($product->id); ?>">
                            
                            
                            <div class="quantity-selector">
                                <button type="button" class="quantity-btn" data-action="decrement">-</button>
                                <input type="number" name="products[<?php echo e($loop->index); ?>][quantity]" class="quantity-input" value="0" min="0" max="<?php echo e($product->stock); ?>" readonly>
                                <button type="button" class="quantity-btn" data-action="increment">+</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center" style="grid-column: 1 / -1; padding: 2rem;">
                        Saat ini tidak ada produk yang tersedia di semua outlet.
                    </p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($products->isNotEmpty()): ?>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
        </div>
        <?php endif; ?>
    </form>
</div>


<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantitySelectors = document.querySelectorAll('.quantity-selector');

    quantitySelectors.forEach(selector => {
        const decrementBtn = selector.querySelector('[data-action="decrement"]');
        const incrementBtn = selector.querySelector('[data-action="increment"]');
        const input = selector.querySelector('.quantity-input');
        const maxStock = parseInt(input.getAttribute('max'), 10);

        decrementBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value, 10);
            if (currentValue > 0) {
                input.value = currentValue - 1;
            }
        });

        incrementBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value, 10);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/divisi/order/create.blade.php ENDPATH**/ ?>