<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sección usuario final ("/*")
|--------------------------------------------------------------------------
| Solo lectura y compra. No puede crear, editar ni borrar productos.
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/buscar', [ProductController::class, 'search'])->name('products.search');
Route::get('/productos/mas-comentados', [ProductController::class, 'topCommented'])->name('products.top-commented');
Route::get('/productos/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::post('/productos/{product}/resenas', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/mis-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::get('/mis-pedidos/{id}', [OrderController::class, 'show'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Sección administrador ("/admin/*")
|--------------------------------------------------------------------------
| Vistas y controladores independientes de la sección de usuario final.
| Requiere autenticación + rol admin (middleware 'auth' y 'admin').
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
});

require __DIR__.'/auth.php';
