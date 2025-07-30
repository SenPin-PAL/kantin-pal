<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OutletController as AdminOutletController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\OutletUserController as AdminOutletUserController;
use App\Http\Controllers\Outlet\ProductController as OutletProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Awal & Rute Otentikasi
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Grup Rute yang memerlukan login
Route::middleware(['auth'])->group(function () {

    // Rute Profil untuk semua role
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Rute untuk ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/orders/{order}/approve', [AdminController::class, 'approveOrder'])->name('approveOrder');
        Route::get('/recap', [AdminController::class, 'transactionRecap'])->name('recap');

        // Rute Pembayaran
        Route::get('/orders/approved', [AdminController::class, 'approvedOrders'])->name('orders.approved');
        Route::get('/orders/{order}', [AdminController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/payments', [AdminController::class, 'storePayment'])->name('orders.payments.store');

        // Rute Resource untuk Manajemen
        Route::resource('outlets', AdminOutletController::class);
        Route::resource('divisions', AdminDivisionController::class);
        Route::resource('outlet-users', AdminOutletUserController::class);
    });

    // Rute untuk OUTLET
    Route::middleware(['role:outlet'])->prefix('outlet')->name('outlet.')->group(function () {
        Route::get('/dashboard', [OutletController::class, 'dashboard'])->name('dashboard');
        Route::patch('/orders/{order}/prepare', [OutletController::class, 'startPreparation'])->name('orders.prepare');
        Route::patch('/orders/{order}/complete', [OutletController::class, 'completeOrder'])->name('completeOrder');
        Route::get('/transactions', [OutletController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/export', [OutletController::class, 'exportTransactions'])->name('transactions.export');
        Route::resource('products', OutletProductController::class);
        Route::get('/recap/purchases', [OutletController::class, 'purchaseRecap'])->name('recap.purchases');
    Route::get('/recap/products', [OutletController::class, 'productRecap'])->name('recap.products');
     Route::get('/recap/purchases/export', [OutletController::class, 'exportPurchaseRecap'])->name('recap.purchases.export');
    Route::get('/recap/products/export', [OutletController::class, 'exportProductRecap'])->name('recap.products.export');

    });

    // Rute untuk DIVISI
    Route::middleware(['role:divisi'])->prefix('divisi')->name('divisi.')->group(function () {
        Route::get('/dashboard', [DivisiController::class, 'dashboard'])->name('dashboard');
        Route::get('/order/create', [DivisiController::class, 'createOrder'])->name('createOrder');
        Route::post('/order/store', [DivisiController::class, 'storeOrder'])->name('storeOrder');
    });

});
