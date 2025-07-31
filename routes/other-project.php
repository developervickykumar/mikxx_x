<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtherProject\DashboardController;

// Define routes for the other project
Route::get('/', [DashboardController::class, 'index'])->name('other-project.dashboard');

// Add more routes as needed for your other project
// Route::get('/feature', [FeatureController::class, 'index'])->name('other-project.feature');
// Route::resource('items', ItemController::class); 