<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest.home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')->name('user.')->group(function() {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
    Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('store');
    Route::get('{id}', [App\Http\Controllers\UserController::class, 'show'])->name('show');
    Route::put('{id}', [App\Http\Controllers\UserController::class, 'update'])->name('update');

});
