<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| End user section ("/*")
|--------------------------------------------------------------------------
| Read-only catalog and purchases. Customers cannot create, edit or delete products.
*/
Route::get('/', 'App\Http\Controllers\HomeController@index')
    ->name('home');
Route::get('/productos', 'App\Http\Controllers\ProductController@index')
    ->name('products.index');
Route::get('/productos/buscar', 'App\Http\Controllers\ProductController@search')
    ->name('products.search');
Route::get('/productos/mas-comentados', 'App\Http\Controllers\ProductController@topCommented')
    ->name('products.top-commented');
Route::get('/productos/mas-vendidos', 'App\Http\Controllers\ProductController@topSelling')
    ->name('products.top-selling');
Route::get('/productos/{id}', 'App\Http\Controllers\ProductController@show')
    ->name('products.show');

Route::middleware('auth')->group(function () {
    Route::post('/productos/{product}/resenas', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/mis-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::get('/mis-pedidos/{id}', [OrderController::class, 'show'])->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Admin section ("/admin/*")
|--------------------------------------------------------------------------
| Views and controllers independent from the end user section.
| Requires authentication and the admin role ('auth' and 'admin' middleware).
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // The group adds the "admin." prefix: 'products.index' is registered as 'admin.products.index'.
    Route::get('/productos', 'App\Http\Controllers\Admin\ProductController@index')
        ->name('products.index');
    Route::get('/productos/crear', 'App\Http\Controllers\Admin\ProductController@create')
        ->name('products.create');
    Route::post('/productos', 'App\Http\Controllers\Admin\ProductController@store')
        ->name('products.store');
    Route::get('/productos/{id}/editar', 'App\Http\Controllers\Admin\ProductController@edit')
        ->name('products.edit');
    Route::put('/productos/{id}', 'App\Http\Controllers\Admin\ProductController@update')
        ->name('products.update');
    Route::patch('/productos/{id}/desactivar', 'App\Http\Controllers\Admin\ProductController@deactivate')
        ->name('products.deactivate');

    Route::resource('categories', AdminCategoryController::class)->except(['show']);
});

require __DIR__.'/auth.php';
