<?php

declare(strict_types=1);

use App\Http\Controllers\CartController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum');

Route::get('cart', [CartController::class, 'show'])->name('cart.show');
Route::post('cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/{productId}', [CartController::class, 'deleteProduct'])->name('cart.delete-product');
Route::post('order', [OrderController::class, 'store'])->name('order.store');
Route::get('countries', CountryController::class);
Route::get('countries/{country_id}/states', StateController::class);
