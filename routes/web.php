<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public section ("/*")
|--------------------------------------------------------------------------
| Read-only and purchase. Cannot create, edit, or delete products.
*/
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/productos', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/productos/buscar', 'App\Http\Controllers\ProductController@search')->name('products.search');
Route::get('/productos/filtro', 'App\Http\Controllers\ProductController@filter')->name('products.filter');
Route::get('/productos/mas-comentados', 'App\Http\Controllers\ProductController@topCommented')->name('products.top-commented');
Route::get('/productos/mas-vendidos', 'App\Http\Controllers\ProductController@topSelling')->name('products.top-selling');
Route::get('/productos/{id}', 'App\Http\Controllers\ProductController@show')->name('products.show');

Route::middleware('auth')->group(function () {
    Route::post('/productos/{productId}/resenas', 'App\Http\Controllers\ReviewController@store')->name('reviews.store');
    Route::get('/mis-pedidos', 'App\Http\Controllers\OrderController@index')->name('orders.index');
    Route::post('/checkout', 'App\Http\Controllers\OrderController@checkout')->name('orders.checkout');
    Route::get('/mis-pedidos/{id}', 'App\Http\Controllers\OrderController@show')->name('orders.show');
});

/*
|--------------------------------------------------------------------------
| Admin section ("/admin/*")
|--------------------------------------------------------------------------
| Independent views and controllers from the public section.
| Requires authentication and admin role ('auth' and 'admin' middleware).
| The group adds the "admin." prefix: 'products.index' is registered as 'admin.products.index'.
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', 'App\Http\Controllers\Admin\ProductController@index')->name('products.index');
    Route::get('/products/create', 'App\Http\Controllers\Admin\ProductController@create')->name('products.create');
    Route::post('/products', 'App\Http\Controllers\Admin\ProductController@store')->name('products.store');
    Route::get('/products/{id}/edit', 'App\Http\Controllers\Admin\ProductController@edit')->name('products.edit');
    Route::put('/products/{id}', 'App\Http\Controllers\Admin\ProductController@update')->name('products.update');
    // Products are deactivated instead of deleted, so their order items keep pointing to them.
    Route::patch('/products/{id}/deactivate', 'App\Http\Controllers\Admin\ProductController@deactivate')->name('products.deactivate');

    Route::get('/categories', 'App\Http\Controllers\Admin\CategoryController@index')->name('categories.index');
    Route::get('/categories/create', 'App\Http\Controllers\Admin\CategoryController@create')->name('categories.create');
    Route::post('/categories', 'App\Http\Controllers\Admin\CategoryController@store')->name('categories.store');
    Route::get('/categories/{id}/edit', 'App\Http\Controllers\Admin\CategoryController@edit')->name('categories.edit');
    Route::put('/categories/{id}', 'App\Http\Controllers\Admin\CategoryController@update')->name('categories.update');
    Route::delete('/categories/{id}', 'App\Http\Controllers\Admin\CategoryController@destroy')->name('categories.destroy');

    Route::get('/brands', 'App\Http\Controllers\Admin\BrandController@index')->name('brands.index');
    Route::get('/brands/create', 'App\Http\Controllers\Admin\BrandController@create')->name('brands.create');
    Route::post('/brands', 'App\Http\Controllers\Admin\BrandController@store')->name('brands.store');
    Route::get('/brands/{id}/edit', 'App\Http\Controllers\Admin\BrandController@edit')->name('brands.edit');
    Route::put('/brands/{id}', 'App\Http\Controllers\Admin\BrandController@update')->name('brands.update');
    Route::delete('/brands/{id}', 'App\Http\Controllers\Admin\BrandController@destroy')->name('brands.destroy');
});

require __DIR__.'/auth.php';
