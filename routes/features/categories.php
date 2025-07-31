<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'feature.access:categories'])->prefix('admin')->group(function () {
    // Basic Category Routes
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::resource('categories', CategoryController::class);
    
    // Category Management Routes
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/categories/{id}/update', [CategoryController::class, 'update']);
    Route::get('/categories/show/{name}', [CategoryController::class, 'show'])->name('categories.show');
    
    // Category Operations
    Route::post('/categories/{id}/copy', [CategoryController::class, 'copyCategory']);
    Route::post('/categories/{id}/move', [CategoryController::class, 'moveCategory']);
    Route::post('/categories/{id}/verify-pin', [CategoryController::class, 'verifyPin'])->name('categories.verifyPin');
    Route::post('/categories/{id}/update-status', [CategoryController::class, 'updateStatus']);
    Route::post('/categories/{id}/toggle-protection', [CategoryController::class, 'toggleProtection']);
    
    // Category Media
    Route::post('/category/{id}/update-icon', [CategoryController::class, 'updateIcon']);
    Route::post('/categories/{id}/update-image', [CategoryController::class, 'updateImage'])->name('category.updateImage');
    Route::post('/category-media-upload', [CategoryController::class, 'mediaUpload'])->name('category.media.upload');
    Route::delete('/delete-category-media/{id}', [CategoryController::class, 'categoryMediaDestroy']);
    
    // Category Hierarchy
    Route::post('categories/reorder', [CategoryController::class, 'reorder']);
    Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction']);
    Route::post('/hierarchy/store', [CategoryController::class, 'storeHierarchy']);
    Route::get('/hierarchy/{id}/children', [CategoryController::class, 'getHierarchyChildren']);
    Route::get('/categories/{id}/children', [CategoryController::class, 'getChildren']);
    Route::get('/categories/children-by-name/{name}', [CategoryController::class, 'getChildrenByName']);
    
    // Category Labels
    Route::get('/categories/icon-by-label/{label}', [CategoryController::class, 'getIconByLabel']);
    Route::post('/category/store-app-label', [CategoryController::class, 'storeAppLabel'])->name('category.storeAppLabel');
    Route::get('/categories/filter-by-label/{label}', [CategoryController::class, 'filterByLabel']);
}); 