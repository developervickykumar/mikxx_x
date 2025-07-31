<?php

use App\Http\Controllers\Test\FeatureAccessTestController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('test')->group(function () {
    // Test Form Builder access
    Route::get('/form-builder', [FeatureAccessTestController::class, 'testFormBuilder'])
        ->middleware('feature.access:form-builder')
        ->name('test.form-builder');

    // Test Categories access
    Route::get('/categories', [FeatureAccessTestController::class, 'testCategories'])
        ->middleware('feature.access:categories')
        ->name('test.categories');

    // Test Builder access
    Route::get('/builder', [FeatureAccessTestController::class, 'testBuilder'])
        ->middleware('feature.access:builder')
        ->name('test.builder');
}); 