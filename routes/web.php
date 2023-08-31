<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardProductsController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\DashboardTransactionsBuyController;
use App\Http\Controllers\DashboardTransactionsSellController;
use App\Http\Controllers\Admin\AdminTransactionsBuyController;
use App\Http\Controllers\Admin\AdminTransactionsSellController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/rewards', [RewardController::class, 'index'])->name('rewards');

Route::get('/details/{id}', [DetailController::class, 'index'])->name('detail');

Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::get('/success', [CartController::class, 'success'])->name('checkout-success');

Route::get('/register/success', [RegisterController::class, 'success'])->name('register-success');

Route::group(['middleware' => ['auth']], function() {
    Route::post('/details/{id}', [DetailController::class, 'add'])->name('detail-add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/qty/add/{id}', [CartController::class, 'addQty'])->name('cart-add-qty');
    Route::get('/cart/qty/decrease/{id}', [CartController::class, 'decreaseQty'])->name('cart-decrease-qty');
    Route::get('/getFormCart/{id}', [CartController::class, 'getFormCart'])->name('getFormCart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
    Route::get('/checkout/{id}', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout-all/{id}', [CheckoutController::class, 'all'])->name('checkout-all');
    Route::delete('/cart-checkout-delete/{id}', [CheckoutController::class, 'delete'])->name('checkout-delete');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout-process');
    Route::post('/checkout/process-all', [CheckoutController::class, 'processAll'])->name('checkout-process-all');
});

Route::group(['middleware' => ['auth', 'user']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/products', [DashboardProductsController::class, 'index']) ->name('products');
    Route::get('/dashboard/products/detail/{id}', [DashboardProductsController::class, 'detail'])->name('product-details');
    Route::post('/dashboard/products/{id}', [DashboardProductsController::class, 'update'])->name('dashboard-product-update');
    
    Route::post('/dashboard/products/gallery/upload', [DashboardProductsController::class, 'uploadGallery'])->name('dashboard-product-gallery-upload');
    Route::get('/dashboard/products/gallery/delete/{id}', [DashboardProductsController::class, 'deleteGallery'])->name('dashboard-product-gallery-delete');
    
    Route::get('/dashboard/products/create', [DashboardProductsController::class, 'create'])->name('products-create');
    Route::post('/dashboard/products', [DashboardProductsController::class, 'store'])->name('products-store');

    Route::get('/dashboard/transactions/sell', [DashboardTransactionsSellController::class, 'index'])->name('transactions-sell');
    Route::post('/dashboard/transactions/sell/{id}', [DashboardTransactionsSellController::class, 'update'])->name('transactions-sell-update');
    Route::get('/dashboard/transactions/sell/{id}', [DashboardTransactionsSellController::class, 'detail'])->name('transactions-sell-detail');
    
    
    Route::get('/dashboard/transactions/buy', [DashboardTransactionsBuyController::class, 'index'])->name('transactions-buy');
    Route::get('/dashboard/transactions/buy/{id}', [DashboardTransactionsBuyController::class, 'detail'])->name('transactions-buy-detail');
    Route::get('/dashboard/transactions/buy/delivered/{id}', [DashboardTransactionsBuyController::class, 'delivered'])->name('delivered');

    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard-settings');
    Route::post('/dashboard/settings/update', [DashboardController::class, 'updateSettings'])->name('update-settings');
    Route::get('/dashboard/account', [DashboardController::class, 'account'])->name('dashboard-account');
    Route::post('/dashboard/account/update/', [DashboardController::class, 'updateAccount'])->name('update-account');
});

    // ->middleware(['auth', 'admin'])
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    // ->namespace('Admin')
    ->group(function() {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
        Route::resource('category', AdminCategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::resource('product-gallery', ProductGalleryController::class)->only(['index', 'create', 'store', 'destroy']);

        Route::get('/transactions/sell', [AdminTransactionsSellController::class, 'index'])->name('admin-transactions-sell');
        Route::post('/transactions/sell/{id}', [AdminTransactionsSellController::class, 'update'])->name('admin-transactions-sell-update');
        Route::get('/transactions/sell/{id}', [AdminTransactionsSellController::class, 'detail'])->name('admin-transactions-sell-detail');
        Route::get('/transactions/sell-cetak', [AdminTransactionsSellController::class, 'cetak'])->name('admin-transactions-sell-print');
        
        Route::get('/transactions/buy', [AdminTransactionsBuyController::class, 'index'])->name('admin-transactions-buy');
        Route::get('/transactions/buy/{id}', [AdminTransactionsBuyController::class, 'detail'])->name('admin-transactions-buy-detail');
        Route::get('/transactions/buy/delivered/{id}', [AdminTransactionsBuyController::class, 'delivered'])->name('admin-delivered');

        
        Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('admin-settings');
        Route::post('/settings/update', [AdminDashboardController::class, 'updateSettings'])->name('admin-update-settings');
        Route::get('/account', [AdminDashboardController::class, 'account'])->name('admin-account');
        Route::post('/account/update/', [AdminDashboardController::class, 'updateAccount'])->name('admin-update-account');
    });
    
Auth::routes();