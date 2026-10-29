<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('books', BookController::class)->names('api.books');
Route::apiResource('products', ProductController::class)->names([
    'index' => 'api.products.index',
    'store' => 'api.products.store',
    'show' => 'api.products.show',
    'update' => 'api.products.update',
    'destroy' => 'api.products.destroy',
]);
