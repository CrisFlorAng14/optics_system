<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest.home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas para CRUD de usuarios
Route::prefix('users')->name('user.')->group(function() {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('store');
    Route::get('{id}', [App\Http\Controllers\UserController::class, 'show'])->name('show');
    Route::put('{id}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
    Route::delete('{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
});
// Rutas para CRUD de productos
Route::prefix('products')->name('product.')->group(function() {
    Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\ProductController::class, 'store'])->name('store');
    Route::get('{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
    Route::put('{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update');
    Route::delete('{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
});
// Rutas para CRUD de productos
Route::prefix('inventories')->name('inventory.')->group(function() {
    Route::get('/', [App\Http\Controllers\InventoryController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\InventoryController::class, 'store'])->name('store');
});