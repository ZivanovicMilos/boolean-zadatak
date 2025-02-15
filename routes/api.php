<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('api.products');
    Route::get('/category/{id}', [ProductController::class, 'productsByCategory']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
    Route::get('/export/category/{id}', [ProductController::class, 'exportCategoryCSV']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('api.categories');
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});
