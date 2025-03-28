<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('books', BookController::class);
    Route::resource('book', \App\Http\Controllers\OrderController::class);
    Route::resource('admin/order', \App\Http\Controllers\OrderController::class);
    Route::get('/admin/order/{order}', [OrderController::class, 'show'])->name('admin.order.show');
    Route::get('/admin/order/index', [OrderController::class, 'show'])->name('admin.order.index');
    Route::resource('admin/book', \App\Http\Controllers\BookController::class);
    Route::resource('orders', \App\Http\Controllers\OrderController::class);
    Route::get('/orders/payee/{id}', [OrderController::class, 'payée'])->name('orders.payée');
    Route::get('/orders/prepa/{id}', [OrderController::class, 'preparation'])->name('orders.preparation');
    Route::get('/orders/expedie/{id}', [OrderController::class, 'expedie'])->name('orders.expedie');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/books/archiver/{id}', [BookController::class, 'archiver'])->name('books.archiver');
    Route::get('/books/desarchiver/{id}', [BookController::class, 'desarchiver'])->name('books.desarchiver');
});
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
require __DIR__.'/auth.php';
