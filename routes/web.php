<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books/{book}/invoice', [InvoiceController::class, 'preview'])
    ->name('books.invoice.preview');
Route::get('/books/{book}/invoice/download', [InvoiceController::class, 'download'])
    ->name('books.invoice.download');
Route::get('/orders/{book}/invoice', [OrderController::class, 'invoice'])
    ->name('orders.invoice');

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/create', function () {
    return view('products.create');
})->name('products.create');

Route::get('/products/{product}/image', [ProductController::class, 'image'])
    ->name('products.image');

Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store');
