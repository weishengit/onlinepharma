<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileDelete;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/shop', [PagesController::class, 'shop'])->name('shop');
    Route::get('/cart', [PagesController::class, 'cart'])->name('cart');

    Route::get('/checkout', [PagesController::class, 'checkout'])
        ->name('checkout')
        ->middleware(['customer', 'checkout']);

    Route::get('/show/{product}', [PagesController::class, 'show'])
        ->name('show')
        ->where('product', '[a-zA-Z0-9-_]+');
});

// PROFILE ROUTE
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
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
Route::middleware(['admin'])->name('admin.')->prefix('admin')->group(function () {

    Route::view('/', 'admin.index')->name('index');
    Route::resource('category', [CategoryController::class]);
    
});

require __DIR__.'/auth.php';
