<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ExpiryController as AdminExpiry;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\PrescriptionController as AdminPrescription;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\UserController as AdminUser;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.product');
Route::get('/lang/{lang}', [AccountController::class, 'setLang'])->name('lang');

// ── Cart ─────────────────────────────────────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::get('/sidebar', [CartController::class, 'sidebar'])->name('sidebar');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// ── Authenticated ────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [AccountController::class, 'order'])->name('order');
        Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('addresses.store');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
        Route::get('/success', [CheckoutController::class, 'success'])->name('success');
    });
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
        Route::get('/', [PrescriptionController::class, 'index'])->name('index');
        Route::get('/create', [PrescriptionController::class, 'create'])->name('create');
        Route::post('/', [PrescriptionController::class, 'store'])->name('store');
    });

    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::post('/', [SubscriptionController::class, 'store'])->name('store');
        Route::patch('/{subscription}/toggle', [SubscriptionController::class, 'toggle'])->name('toggle');
        Route::delete('/{subscription}', [SubscriptionController::class, 'destroy'])->name('destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', fn() => redirect()->route('account.dashboard'))
        ->middleware('verified')->name('dashboard');
});

// ── Admin ────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrder::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrder::class, 'show'])->name('show');
        Route::patch('/{order}/status', [AdminOrder::class, 'updateStatus'])->name('status');
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminProduct::class, 'index'])->name('index');
        Route::get('/create', [AdminProduct::class, 'create'])->name('create');
        Route::post('/', [AdminProduct::class, 'store'])->name('store');
        Route::get('/{product}/edit', [AdminProduct::class, 'edit'])->name('edit');
        Route::patch('/{product}', [AdminProduct::class, 'update'])->name('update');
        Route::get('/{product}/expiry', [AdminProduct::class, 'expiry'])->name('expiry');
        Route::post('/{product}/expiry', [AdminProduct::class, 'addBatch'])->name('expiry.store');
        Route::get('/{product}/analytics', [AdminProduct::class, 'analytics'])->name('analytics');
    });

    Route::prefix('expiry')->name('expiry.')->group(function () {
        Route::get('/', [AdminExpiry::class, 'index'])->name('index');
    });

    Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
        Route::get('/', [AdminPrescription::class, 'index'])->name('index');
        Route::patch('/{prescription}/review', [AdminPrescription::class, 'review'])->name('review');
    });

    // Users management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUser::class, 'index'])->name('index');
        Route::patch('/{user}/role', [AdminUser::class, 'updateRole'])->name('role');
    });
});

require __DIR__.'/auth.php';
