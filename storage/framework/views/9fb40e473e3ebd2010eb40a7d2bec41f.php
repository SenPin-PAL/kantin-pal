<?php $__env->startSection('title', 'Buat Pesanan Baru'); ?>
<?php $__env->startSection('content'); ?>
<div class="card mb-4">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Buat Pesanan Baru</h1>
            <div class="w-50">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama menu...">
            </div>
        </div>
    </div>
</div>


<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo e(route('divisi.storeOrder')); ?>" method="POST" id="order-form">
    <?php echo csrf_field(); ?>
    <div class="order-container">
        
        
        <div class="product-list-panel">
            <div class="product-list-scroller">
                <div class="product-grid">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="product-card" data-name="<?php echo e(strtolower($product->name)); ?>" data-outlet="<?php echo e(strtolower($product->outlet->name)); ?>">
                            <div class="product-card-image">
                                <img src="<?php echo e($product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300/e9ecef/495057?text=No+Image'); ?>" alt="<?php echo e($product->name); ?>">
                            </div>
                            <div class="product-card-body">
                                <h5 class="font-weight-bold mb-1"><?php echo e($product->name); ?></h5>
                                <p class="text-muted mb-1"><small><?php echo e($product->outlet->name); ?></small></p>
                                <p class="mb-1">Stok: <span class="font-weight-bold"><?php echo e($product->stock); ?></span></p>
                                <p class="font-weight-bold h5 text-primary">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                            </div>
                            <div class="product-card-footer">
                                <button type="button" class="btn btn-primary btn-block add-to-cart-btn"
                                    data-id="<?php echo e($product->id); ?>"
                                    data-name="<?php echo e($product->name); ?>"
                                    data-price="<?php echo e($product->price); ?>"
                                    data-stock="<?php echo e($product->stock); ?>">
                                    + Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center" style="grid-column: 1 / -1; padding: 2rem;">
                            Saat ini tidak ada produk yang tersedia.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="order-summary-panel">
            <div class="card-header bg-light">
                <h4 class="mb-0">Ringkasan Pesanan</h4>
            </div>
            <div class="card-body p-4">
                <div id="cart-items-container" style="min-height: 150px;">
                    <ul id="cart-items-list">
                        
                    </ul>
                    <p id="empty-cart-message" class="text-center text-muted mt-4 pt-4">Keranjang masih kosong.</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Total</h5>
                    <h5 class="mb-0 font-weight-bold" id="total-price">Rp 0</h5>
                </div>
            </div>
             <div class="card-footer p-3">
                <button type="submit" class="btn btn-success btn-block btn-lg" id="submit-order-btn" disabled>
                    Kirim Pesanan
                </button>
            </div>
        </div>

        
        <div id="hidden-inputs-container"></div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cart = {}; // { productId: { name, price, quantity, stock } }
    
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    const cartItemsList = document.getElementById('cart-items-list');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const totalPriceEl = document.getElementById('total-price');
    const submitButton = document.getElementById('submit-order-btn');
    const hiddenInputsContainer = document.getElementById('hidden-inputs-container');
    const searchInput = document.getElementById('searchInput');

    // --- FUNGSI UTAMA ---
    function addToCart(id, name, price, stock) {
        if (cart[id]) {
            if (cart[id].quantity < stock) {
                cart[id].quantity++;
            } else {
                // Bisa diganti dengan notifikasi yang lebih baik
                alert(`Stok untuk ${name} tidak mencukupi.`);
            }
        } else {
            if (stock > 0) {
                cart[id] = { name, price: parseFloat(price), quantity: 1, stock: parseInt(stock) };
            } else {
                alert(`Stok untuk ${name} habis.`);
            }
        }
        updateCartDisplay();
    }

    function updateQuantity(id, newQuantity) {
        newQuantity = parseInt(newQuantity, 10);
        if (!cart[id]) return; // Jika item sudah tidak ada

        if (newQuantity > 0) {
             if (newQuantity <= cart[id].stock) {
                cart[id].quantity = newQuantity;
            } else {
                cart[id].quantity = cart[id].stock;
                alert(`Stok untuk ${cart[id].name} hanya tersisa ${cart[id].stock}.`);
            }
        } else {
            delete cart[id];
        }
        updateCartDisplay();
    }
    
    function updateCartDisplay() {
        cartItemsList.innerHTML = '';
        hiddenInputsContainer.innerHTML = '';
        let totalPrice = 0;
        let index = 0;

        const hasItems = Object.keys(cart).length > 0;
        emptyCartMessage.style.display = hasItems ? 'none' : 'block';
        submitButton.disabled = !hasItems;

        for (const id in cart) {
            const item = cart[id];
            totalPrice += item.quantity * item.price;

            // Buat elemen list untuk ditampilkan di keranjang
            const li = document.createElement('li');
            li.innerHTML = `
                <div class="item-details">
                    <strong class="d-block">${item.name}</strong>
                    <small>Rp ${item.price.toLocaleString('id-ID')}</small>
                </div>
                <div class="quantity-selector-cart">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-id="${id}" data-action="decrement">-</button>
                    <input type="number" class="quantity-input-cart" value="${item.quantity}" min="1" max="${item.stock}" data-id="${id}">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-id="${id}" data-action="increment">+</button>
                </div>
            `;
            cartItemsList.appendChild(li);

            // Buat hidden input untuk dikirim bersama form
            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = `products[${index}][id]`;
            hiddenId.value = id;

            const hiddenQuantity = document.createElement('input');
            hiddenQuantity.type = 'hidden';
            hiddenQuantity.name = `products[${index}][quantity]`;
            hiddenQuantity.value = item.quantity;
            
            hiddenInputsContainer.appendChild(hiddenId);
            hiddenInputsContainer.appendChild(hiddenQuantity);
            index++;
        }

        totalPriceEl.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    }

    // --- EVENT LISTENERS ---
    document.querySelector('.product-grid').addEventListener('click', (e) => {
        if (e.target.classList.contains('add-to-cart-btn')) {
            const { id, name, price, stock } = e.target.dataset;
            addToCart(id, name, price, stock);
        }
    });

    cartItemsList.addEventListener('click', (e) => {
        const target = e.target;
        if (target.tagName === 'BUTTON') {
            const id = target.dataset.id;
            const action = target.dataset.action;
            if (action === 'increment') {
                updateQuantity(id, cart[id].quantity + 1);
            } else if (action === 'decrement') {
                updateQuantity(id, cart[id].quantity - 1);
            }
        }
    });

    cartItemsList.addEventListener('change', (e) => {
        if (e.target.matches('.quantity-input-cart')) {
            const id = e.target.dataset.id;
            const newQuantity = parseInt(e.target.value, 10);
            updateQuantity(id, newQuantity);
        }
    });
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(card => {
            const productName = card.dataset.name;
            const outletName = card.dataset.outlet;
            if (productName.includes(searchTerm) || outletName.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Sekolah\Semester_6\Magang\Coding\kantin-pal\resources\views/divisi/order/create.blade.php ENDPATH**/ ?>