<?php

use App\Models\Cart;
use App\Http\Controllers\GoogleLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\FacebookLogin;
use App\Http\Controllers\ProfileDelete;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProductReturnController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\CriticalLevelController;
use App\Http\Controllers\ExpirationController;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserReportController;
use App\Models\ProductReturn;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// SOCIAL LOGIN
Route::get('/login/google', [GoogleLogin::class, 'redirect'])->name('google.login');
Route::get('/login/google/callback', [GoogleLogin::class, 'callback'])->name('google.callback');

Route::get('/login/facebook', [FacebookLogin::class, 'redirect'])->name('facebook.login');
Route::get('/login/facebook/callback', [FacebookLogin::class, 'callback'])->name('facebook.callback');

// PAGES ROUTE
Route::get('/', [PagesController::class, 'index'])->name('home');

Route::prefix('pages')->name('pages.')->group(function () {

    Route::get('/sales', [PagesController::class, 'sales'])->name('sales');
    Route::get('/thanks', [PagesController::class, 'thanks'])->name('thanks');
    Route::get('/about', [PagesController::class, 'about'])->name('about');
    Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
    Route::get('/shop/search/{filter?}', [PagesController::class, 'search'])
        ->name('search');
    Route::get('/shop/{filter?}', [PagesController::class, 'shop'])
        ->name('shop')
        ->middleware(['active']);
    Route::get('/cart', [PagesController::class, 'cart'])
        ->name('cart')
        ->middleware(['active']);

    Route::get('/checkout', [PagesController::class, 'checkout'])
        ->name('checkout')
        ->middleware(['checkout', 'active']);

    Route::get('/show/{product}', [PagesController::class, 'show'])
        ->name('show')
        ->where('product', '[a-zA-Z0-9-_]+');
});

// CART ROUTE
Route::get('/cart', [CartController::class, 'getCart'])->name('cart');
Route::post('/add-to-cart/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/remove-from-cart/{id}/{quantity}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::get('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::get('/clear-cart', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware(['auth', 'active', 'checkout', 'verified'])->group(function () {

    Route::post('/cart/prescription', [CartController::class, 'prescription'])->name('cart.prescription');
    Route::get('/cart/discount', [CartController::class, 'discount'])->name('cart.discount');
    Route::post('/cart/senior', [CartController::class, 'senior'])->name('cart.senior');
    Route::get('/cart/method', [CartController::class, 'method'])->name('cart.method');
    Route::get('/cart/checkout/regular', [CartController::class, 'checkout'])->name('cart.checkout.regular');
    Route::post('/cart/checkout/senior', [CartController::class, 'checkout'])->name('cart.checkout.senior');
    Route::get('/cart/checkout/delivery', [CartController::class, 'delivery'])->name('cart.delivery');
    Route::get('/cart/checkout/pickup', [CartController::class, 'pickup'])->name('cart.pickup');
    Route::get('/cart/finalize', [CartController::class, 'finalize'])->name('cart.finalize');
    Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm')->middleware(['cart']);;
});

// PROFILE ROUTE
Route::middleware(['auth', 'active', 'verified'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'] )->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'] )->name('edit');
    Route::put('/update', [ProfileController::class, 'update'] )->name('update');

    Route::get('/password/edit', [PasswordController::class, 'edit'])
        ->middleware(['password.confirm'])
        ->name('password.edit');
    Route::put('/password/edit', [PasswordController::class, 'update']);

    Route::get('/delete', [ProfileDelete::class, 'show'])
        ->middleware(['password.confirm'])
        ->name('delete.show');
    Route::delete('/delete', [ProfileDelete::class, 'destroy']);

    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::delete('/orders/{order}', [ProfileController::class, 'cancel'])->name('cancel')
        ->middleware(['password.confirm']);
    Route::get('/orders/{order?}', [ProfileController::class, 'order'])->name('order');
});

// ADMIN ROUTE
Route::middleware(['admin', 'active'])->name('admin.')->prefix('admin')->group(function () {
    //SMS
    Route::get('/sms', [SmsController::class, 'index']);
    //SETTINGS
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::get('/settings/edit', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('/settings/edit', [SettingController::class, 'update'])->name('setting.update');
    //DASHBOARD
    Route::get('/', [PagesController::class, 'admin'])->name('index');
    Route::get('/manage', [AdminController::class, 'manage'])->name('manage');
    //CATEGORY
    Route::put('category/{id}/activate', [CategoryController::class, 'activate'])->name('category.activate');
    Route::resource('category', CategoryController::class);
    //USERS
    Route::post('users/admin/{id}/add', [AdminController::class, 'store'])->name('make.admin');
    Route::delete('users/admin/{id}/remove', [AdminController::class, 'destroy'])->name('remove.admin');
    Route::get('users/show/admin', [UserController::class , 'showAdmin'])->name('user.admin.show');
    Route::get('users/show/customer', [UserController::class , 'showCustomer'])->name('user.customer.show');
    Route::get('users/show/inactive', [UserController::class , 'showInactive'])->name('user.inactive.show');
    Route::post('users/edit/{id}/ban', [BanController::class , 'store'])->name('user.ban');
    Route::delete('users/edit/{id}/unban', [BanController::class , 'destroy'])->name('user.unban');
    Route::resource('user', UserController::class);
    //TAX
    Route::put('tax/{product}/activate', [TaxController::class, 'activate'])->name('tax.activate');
    Route::resource('tax', TaxController::class);
    //DISCOUNTS
    Route::put('discount/{discount}/activate', [DiscountController::class, 'activate'])->name('discount.activate');
    Route::resource('discount', DiscountController::class);
    //PRODUCTS
    Route::put('product/{product}/activate', [ProductController::class, 'activate'])->name('product.activate');
    Route::put('product/{product}/not-available', [ProductController::class, 'markNotForSale'])->name('product.notavailable');
    Route::put('product/{product}/available', [ProductController::class, 'markForSale'])->name('product.available');
    Route::resource('product', ProductController::class);
    //ORDERS
    Route::post('/order/{id}/dispatch', [OrderController::class, 'dispatch'])->name('order.dispatch');
    Route::post('/order/{id}/accept', [OrderController::class, 'accept'])->name('order.accept');
    Route::post('/order/{id}/complete', [OrderController::class, 'complete'])->name('order.complete');
    Route::resource('order', OrderController::class);
    //RETURNS
    Route::resource('return', ProductReturnController::class);
    //SALES
    Route::get('/sale', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/sale/{product}', [SaleController::class, 'show'])->name('sale.show');
    Route::get('/sale/{product}/edit', [SaleController::class, 'edit'])->name('sale.edit');
    Route::put('/sale/{product}/edit', [SaleController::class, 'update'])->name('sale.update');
    Route::get('/sale/{product}/create', [SaleController::class, 'create'])->name('sale.create');
    Route::post('/sale/{product}', [SaleController::class, 'store'])->name('sale.store');
    Route::delete('/sale/{id}/destroy', [SaleController::class, 'destroy'])->name('sale.destroy');
    //BATCH
    Route::get('/inventory/critical', [CriticalLevelController::class, 'index'])->name('inventory.critical');
    Route::get('/inventory/expiring', [ExpirationController::class, 'index'])->name('inventory.expiring');
    Route::get('/batch/create/{id}', [BatchController::class, 'create'])->name('batch.add');
    Route::post('/batch/activate/{id}', [BatchController::class, 'activate'])->name('batch.activate');
    Route::post('/batch/create/{id}', [BatchController::class, 'store'])->name('batch.save');
    Route::resource('batch', BatchController::class);
    //REPORTS
    Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
    //REPORTS-USER
    Route::get('/reports/users/report', [ReportController::class, 'users'])->name('report.user');
    Route::get('/reports/users/api/', [UserReportController::class, 'users'])->name('report.user.api');
    //REPORTS-ORDERS
    Route::get('/reports/orders/report', [ReportController::class, 'orders'])->name('report.order');
    Route::get('/reports/orders/api/', [OrderReportController::class, 'orders'])->name('report.order.api');
});

require __DIR__.'/auth.php';
