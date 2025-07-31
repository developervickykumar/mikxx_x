<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\FormFieldTypeController;
use App\Http\Controllers\FormFieldCategoryController;
use App\Http\Controllers\FormConditionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'feature.access:form-builder'])->prefix('admin')->group(function() {
    // Form Routes
    Route::resource('forms', FormController::class);
    
    // Form Fields Routes
    Route::get('forms/{form}/fields', [FormFieldController::class, 'index'])->name('forms.fields.index');
    Route::get('forms/{form}/fields/create', [FormFieldController::class, 'create'])->name('forms.fields.create');
    Route::post('forms/{form}/fields', [FormFieldController::class, 'store'])->name('forms.fields.store');
    Route::get('forms/{form}/fields/{field}/edit', [FormFieldController::class, 'edit'])->name('forms.fields.edit');
    Route::put('forms/{form}/fields/{field}', [FormFieldController::class, 'update'])->name('forms.fields.update');
    Route::delete('forms/{form}/fields/{field}', [FormFieldController::class, 'destroy'])->name('forms.fields.destroy');
    Route::post('forms/{form}/fields/order', [FormFieldController::class, 'updateOrder'])->name('forms.fields.updateOrder');
    
    // Field Types Routes
    Route::resource('field-types', FormFieldTypeController::class);
    Route::post('field-types/batch', [FormFieldTypeController::class, 'batch'])->name('field-types.batch');
    Route::get('field-types-export', [FormFieldTypeController::class, 'export'])->name('field-types.export');
    Route::post('field-types-import', [FormFieldTypeController::class, 'import'])->name('field-types.import');
    Route::get('field-types/documentation', [FormFieldTypeController::class, 'documentation'])->name('field-types.documentation');
    
    // Field Categories Routes
    Route::resource('field-categories', FormFieldCategoryController::class);
    Route::post('field-categories/order', [FormFieldCategoryController::class, 'updateOrder'])->name('field-categories.updateOrder');

    // Form Conditions Routes
    Route::prefix('form-conditions')->group(function () {
        Route::post('/', [FormConditionController::class, 'store']);
        Route::put('/{condition}', [FormConditionController::class, 'update']);
        Route::delete('/{condition}', [FormConditionController::class, 'destroy']);
        Route::post('/evaluate', [FormConditionController::class, 'evaluate'])->name('form-conditions.evaluate');
    });
}); 