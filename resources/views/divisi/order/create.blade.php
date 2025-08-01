@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Buat Pesanan Baru</h1>
        <div class="search-bar">
            <form action="{{ route('divisi.createOrder') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau deskripsi menu..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ml-2">Cari</button>
            </form>
        </div>
    </div>
    <form action="{{ route('divisi.storeOrder') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="product-grid">
                @forelse($products as $product)
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-card-body">
                            <h3>{{ $product->name }}</h3>
                            <p class="outlet-name">{{ $product->description }}</p>
                            <p class="outlet-name">{{ $product->outlet->name }}</p>
                            <p class="stock-info">Stok: {{ $product->stock }}</p>
                        </div>
<<<<<<< HEAD
                        <div class="product-card-footer"  data-price="{{ $product->price }}"
                        data-name="{{ $product->name }}" >
                            {{-- Input tersembunyi untuk ID produk --}}
=======
                        <div class="product-card-footer">
>>>>>>> 98fd97ca091f788734b3650837421689d8bc2a5b
                            <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
                            <div class="quantity-selector">
                                <button type="button" class="quantity-btn" data-action="decrement">-</button>
                                <input type="number" name="products[{{ $loop->index }}][quantity]" class="quantity-input" value="0" min="0" max="{{ $product->stock }}">
                                <button type="button" class="quantity-btn" data-action="increment">+</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center" style="grid-column: 1 / -1; padding: 2rem;">
                        @if(request('search'))
                            Menu dengan kata kunci "{{ request('search') }}" tidak ditemukan.
                        @else
                            Saat ini tidak ada produk yang tersedia di semua outlet.
                        @endif
                    </p>
                @endforelse
            </div>

            {{-- Menambahkan Link Paginasi --}}
            <<div class="pagination-wrapper mt-4">
    {{ $products->links() }}
</div>

        </div>
        
        <!-- <div class="order-summary">
            <h3>🧾 Ringkasan Pesanan:</h3>
            <ul id="order-details"></ul>
            <p><strong>Total Item:</strong> <span id="total-items">0</span></p>
            <p><strong>Total Harga:</strong> Rp <span id="total-price">0</span></p>
        </div> -->


        <div class="card-footer">
            <div class="pagination-wrapper">
                {{ $products->links('vendor.pagination.custom') }} 
            </div>
            <!-- @if($products->isNotEmpty())
            <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
            @endif -->

            <button type="button" onclick="togglePopup(event)" id="basketButton" class="basket-btn">
            Basket • 0 Items Rp0
            </button>
            <!-- Popup Order Summary -->
            <div id="popupOrder" class="popup-overlay hidden">
            <div class="popup-content">
                <h2>Order Summary</h2>

                <div class="order-summary">
                    <div class="table-wrapper">
                        <div class="table-header">
                        <span>Produk</span>
                        <span>Harga</span>
                        <span>Qty</span>
                        <span>Subtotal</span>
                        </div>
                        <div id="order-details" class="table-body">
                        <!-- Baris item di-inject lewat JS -->
                        </div>
                    </div>

                    <div class="order-summary-totals">
                        <div class="summary-row">
                        <span>Total Item:</span>
                        <span id="total-items">0</span>
                        </div>
                        <div class="summary-row">
                        <span>Total Harga:</span>
                        <span>Rp <span id="total-price">0</span></span>
                        </div>
                    </div>
                </div>

                @if($products->isNotEmpty())
                <button type="submit" class="place-order-btn">Kirim Pesanan</button>
                @endif
            </div>
            </div>

        </div>
       
    </form>
 

</div>

@push('scripts')
{{-- Script untuk tombol +/- tetap sama --}}
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
                updateOrderSummary(); // Tambahkan ini
            }
        });
        incrementBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value, 10);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                updateOrderSummary(); // Tambahkan ini
            }
        });

    });

});

function updateOrderSummary() {
    const inputs = document.querySelectorAll('.quantity-input');
    let totalItems = 0;
    let totalPrice = 0;
    const orderDetails = document.getElementById('order-details');
    const basketButton = document.getElementById('basketButton');

    orderDetails.innerHTML = '';

    inputs.forEach(input => {
        const quantity = parseInt(input.value, 10);
        if (quantity > 0) {
            const parent = input.closest('.product-card-footer');
            const name = parent.dataset.name;
            const price = parseInt(parent.dataset.price, 10);
            const subtotal = price * quantity;

            totalItems += quantity;
            totalPrice += subtotal;

            const row = document.createElement('div');
            row.classList.add('table-row');

            row.innerHTML = `
            <span>${name}</span>
            <span>Rp ${price.toLocaleString('id-ID')}</span>
            <span>${quantity}</span>
            <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
            `;

            orderDetails.appendChild(row);

        }
    });

    // 🔁 Update tampilan total di ringkasan popup
    document.getElementById('total-items').textContent = totalItems;
    document.getElementById('total-price').textContent = totalPrice.toLocaleString('id-ID');

    // 🔁 Update tombol basket juga
    basketButton.innerText = `Basket • ${totalItems} Items Rp${totalPrice.toLocaleString('id-ID')}`;
}


function togglePopup(event) {
    if (event) event.preventDefault(); // cegah klik kirim form

    const popup = document.getElementById('popupOrder');
    popup.classList.toggle('hidden');
}

// Tutup popup jika klik di luar isi popup
document.getElementById("popupOrder").addEventListener("click", function (e) {
  if (e.target.id === "popupOrder") {
    togglePopup();
  }
});

 
</script>

<style> 
.pagination {
    display: flex;
    list-style: none;
    gap: 0.5rem;
    justify-content: center;
}

.pagination li a,
.pagination li span {
    padding: 6px 12px;
    border: 1px solid #0B257E;
    color: #0B257E;
    text-decoration: none;
    border-radius: 4px;
}

.pagination li span {
    background-color: #0B257E;
    color: white;
}

.order-summary {
    margin: 2rem 0;
    padding: 1rem;
    background-color: #f1f5f9;
    border: 1px solid #0B257E;
    border-radius: 8px;
    color: #0B257E;
}

.order-summary h3 {
    margin-bottom: 0.5rem;
}

.order-summary ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1rem;
}

.order-summary li {
    margin-bottom: 0.3rem;
    font-weight: 500;
}

/* Tombol basket di pojok bawah */
.basket-btn {
    position: fixed;
    bottom: 20px;
    right: 52%;
    transform: translateX(600px); /* Setengah dari lebar container (1200px / 2) */
    background-color: #4CAF50;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    z-index: 1000;
}

/* Popup overlay */
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
}

/* Popup content */
.popup-content {
  background-color: #fff;
  padding: 24px;
  border-radius: 12px;
  width: 90%;
  max-width: 520px; /* Diperlebar */
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.popup-content h2 {
  margin-top: 0;
  margin-bottom: 16px;
  text-align: center; /* Judul rata tengah */
}

/* Table wrapper */
.table-wrapper {
  width: 100%;
  margin-top: 10px;
  padding: 10px;
  border: 2px solid #1f2937;
  border-radius: 8px;
  background: #f8f9ff;
  font-size: 14px;
}

/* Table header */
.table-header {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 8px;
  font-weight: bold;
  padding: 6px 0;
  border-bottom: 1px dashed #ccc;
  text-align: center; /* Header rata tengah */
}

/* Table rows (isi data) */
.table-body .table-row {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 8px;
  padding: 6px 0;
  border-bottom: 1px dashed #ccc;
}

.table-body .table-row span:nth-child(1) {
  text-align: left;   /* Produk */
}
.table-body .table-row span:nth-child(2),
.table-body .table-row span:nth-child(3),
.table-body .table-row span:nth-child(4) {
  text-align: right;  /* Harga, Qty, Subtotal */
}

/* Summary bawah tabel */
.order-summary-totals {
  margin-top: 1rem;
  display: flex;
  flex-direction: column;
  gap: 8px;
  font-weight: bold;
  font-size: 16px;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  border-top: 1px dashed #ccc;
  padding-top: 6px;
}

/* Tombol Kirim Pesanan */
.place-order-btn {
  background-color: #28a745;
  color: white;
  padding: 12px;
  width: 100%;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 16px;
}

.basket-btn {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  background-color: #4CAF50;
  color: white;
  padding: 12px 30px;
  border: none;
  border-radius: 25px;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  z-index: 1000;
  width: max-content;
  max-width: 90vw;
}

/* Tambahan biar tidak terlalu lebar di layar besar */
@media (min-width: 1200px) {
  .basket-btn {
    left: 50%;
    transform: translateX(-50%);
  }
}



/* Utility */
.hidden {
  display: none;
}


</style>
@endpush
@endsection
