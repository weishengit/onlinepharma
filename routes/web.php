<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BanController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileDelete;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PasswordController;

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



// PAGES ROUTE
Route::get('/', [PagesController::class, 'index'])->name('home');

Route::prefix('pages')->name('pages.')->group(function () {

    Route::get('/sales', [PagesController::class, 'sales'])->name('sales');
    Route::get('/thanks', [PagesController::class, 'thanks'])->name('thanks');
    Route::get('/about', [PagesController::class, 'about'])->name('about');
    Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
    Route::get('/shop', [PagesController::class, 'shop'])
        ->name('shop')
        ->middleware(['active']);;
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

// PROFILE ROUTE
Route::middleware(['auth', 'active'])->prefix('profile')->name('profile.')->group(function () {
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
});

// ADMIN ROUTE
Route::middleware(['admin', 'active'])->name('admin.')->prefix('admin')->group(function () {

    //DASHBOARD
    Route::view('/', 'admin.index')->name('index');
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
    //PRODUCTS
    Route::put('product/{product}/activate', [ProductController::class, 'activate'])->name('product.activate');
    Route::put('product/{product}/not-available', [ProductController::class, 'markNotForSale'])->name('product.notavailable');
    Route::put('product/{product}/available', [ProductController::class, 'markForSale'])->name('product.available');
    Route::resource('product', ProductController::class);
});

require __DIR__.'/auth.php';
