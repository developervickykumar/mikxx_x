<?php
use Illuminate\Support\Facades\Route;

// === START routes for slug: abc ===

use App\Http\Controllers\CategoryController\ResourceController;

Route::get('/resource', [ResourceController::class, 'index']);
Route::get('/resource/{id}', [ResourceController::class, 'show']);
Route::post('/resource', [ResourceController::class, 'store']);
Route::put('/resource/{id}', [ResourceController::class, 'update']);
Route::delete('/resource/{id}', [ResourceController::class, 'destroya']);

// === END routes for slug: abc ===

// === START routes for slug: sector ===

use App\Http\Controllers\CategoryController\SectorController;

Route::get('/sector', [SectorController::class, 'index']);
Route::get('/sector/report', [SectorController::class, 'report']);
Route::get('/sector/edit', [SectorController::class, 'edit']);
Route::get('/sector/custom', [SectorController::class, 'custom']);

// === END routes for slug: sector ===

// === START routes for slug: quick-access ===

use App\Http\Controllers\CategoryController\QuickAccessController;

Route::get('/quick-access', [QuickAccessController::class, 'index']);
Route::get('/quick-access/report', [QuickAccessController::class, 'report']);
Route::get('/quick-access/edit', [QuickAccessController::class, 'edit']);
Route::get('/quick-access/custom', [QuickAccessController::class, 'custom']);

// === END routes for slug: quick-access ===

// === START routes for slug: functionality ===

use App\Http\Controllers\CategoryController\FunctionalityController;

Route::get('/functionality', [FunctionalityController::class, 'index']);
Route::get('/functionality/report', [FunctionalityController::class, 'report']);
Route::get('/functionality/edit', [FunctionalityController::class, 'edit']);
Route::get('/functionality/custom', [FunctionalityController::class, 'custom']);

// === END routes for slug: functionality ===
