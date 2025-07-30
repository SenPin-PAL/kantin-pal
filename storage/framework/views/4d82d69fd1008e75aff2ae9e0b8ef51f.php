<?php $__env->startSection('title', 'Buat Pesanan Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h1>Buat Pesanan Baru</h1>
        <div class="search-bar">
            <form action="<?php echo e(route('divisi.createOrder')); ?>" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau deskripsi menu..." value="<?php echo e(request('search')); ?>">
                <button type="submit" class="btn btn-primary ml-2">Cari</button>
            </form>
        </div>
    </div>
    <form action="<?php echo e(route('divisi.storeOrder')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card-body">
            <div class="product-grid">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>">
                        </div>
                        <div class="product-card-body">
                            <h3><?php echo e($product->name); ?></h3>
                            <p class="outlet-name"><?php echo e($product->outlet->name); ?></p>
                            <p class="stock-info">Stok: <?php echo e($product->stock); ?></p>
                        </div>
                        <div class="product-card-footer">
                            <input type="hidden" name="products[<?php echo e($loop->index); ?>][id]" value="<?php echo e($product->id); ?>">
                            <div class="quantity-selector">
                                <button type="button" class="quantity-btn" data-action="decrement">-</button>
                                <input type="number" name="products[<?php echo e($loop->index); ?>][quantity]" class="quantity-input" value="0" min="0" max="<?php echo e($product->stock); ?>">
                                <button type="button" class="quantity-btn" data-action="increment">+</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center" style="grid-column: 1 / -1; padding: 2rem;">
                        <?php if(request('search')): ?>
                            Menu dengan kata kunci "<?php echo e(request('search')); ?>" tidak ditemukan.
                        <?php else: ?>
                            Saat ini tidak ada produk yang tersedia di semua outlet.
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>

            
            <<div class="pagination-wrapper mt-4">
    <?php echo e($products->links()); ?>

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Office\KP\PROJEK\kantin-pal\resources\views/divisi/order/create.blade.php ENDPATH**/ ?>