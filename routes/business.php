<?php

use App\Http\Controllers\Business\BusinessController;
use App\Http\Controllers\Business\ServiceController;
use App\Http\Controllers\Business\AppointmentController;
use App\Http\Controllers\Business\SocialInteractionController;
use App\Http\Controllers\Business\StoryController;
use App\Http\Controllers\Business\MembershipPlanController;
use App\Http\Controllers\Business\ProductManagerController;
use App\Http\Controllers\Business\TeamHierarchyController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\BusinessAccess;
use App\Http\Controllers\Business\UserSettingsController;
use App\Http\Controllers\Business\ContentManagerController;
use App\Http\Controllers\Business\BusinessAdminController;
use App\Http\Controllers\Business\BusinessHomeController;
use App\Http\Controllers\Business\FranchiseController;
use App\Http\Controllers\Business\BusinessFollowerController;
use App\Http\Controllers\Business\BusinessEmployeeController;
use App\Http\Controllers\Business\ReviewController;
use App\Http\Controllers\Business\MonetizationController;
use App\Http\Controllers\Business\BusinessRoleController;
use App\Http\Controllers\Business\DashboardController;
use App\Http\Controllers\Business\ProfileController;
use App\Http\Controllers\Business\TeamController;
use App\Http\Controllers\Business\ReportController;
use App\Http\Controllers\Business\SettingController;

// Business routes with middleware
Route::middleware(['auth', 'business.access'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('business.dashboard')
        ->middleware('business.permission:view_dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('business.profile')
        ->middleware('business.permission:view_profile');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('business.profile.update')
        ->middleware('business.permission:edit_profile');

    // Team Management
    Route::get('/team', [TeamController::class, 'index'])
        ->name('business.team')
        ->middleware('business.permission:view_team');
    Route::post('/team', [TeamController::class, 'store'])
        ->name('business.team.store')
        ->middleware('business.permission:manage_team');
    Route::put('/team/{user}', [TeamController::class, 'update'])
        ->name('business.team.update')
        ->middleware('business.permission:manage_team');
    Route::delete('/team/{user}', [TeamController::class, 'destroy'])
        ->name('business.team.destroy')
        ->middleware('business.permission:manage_team');

    // Role Management
    Route::resource('roles', BusinessRoleController::class)
        ->parameters(['roles' => 'role'])
        ->middleware('business.permission:manage_roles');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('business.reports')
        ->middleware('business.permission:view_reports');
    Route::post('/reports/generate', [ReportController::class, 'generate'])
        ->name('business.reports.generate')
        ->middleware('business.permission:generate_reports');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])
        ->name('business.settings')
        ->middleware('business.permission:view_settings');
    Route::put('/settings', [SettingController::class, 'update'])
        ->name('business.settings.update')
        ->middleware('business.permission:manage_settings');

    // Business CRUD
    Route::resource('businesses', BusinessController::class);

    // Business-specific routes
    Route::prefix('businesses/{business}')->group(function () {
        // Services
        Route::resource('services', ServiceController::class);
        
        // Products
        Route::resource('products', ProductManagerController::class)->names([
            'index' => 'products.index',
            'create' => 'products.create',
            'store' => 'products.store',
            'show' => 'products.show',
            'edit' => 'products.edit',
            'update' => 'products.update',
            'destroy' => 'products.destroy',
        ]);
        
        // Appointments
        Route::resource('appointments', AppointmentController::class);
        Route::get('services/{service}/appointments/create', [AppointmentController::class, 'create'])
            ->name('services.appointments.create');
        Route::post('services/{service}/appointments', [AppointmentController::class, 'store'])
            ->name('services.appointments.store');
        
        // Stories
        Route::resource('stories', StoryController::class);
        Route::post('stories/{story}/toggle', [StoryController::class, 'toggle'])->name('stories.toggle');
        
        // Membership Plans
        Route::resource('membership-plans', MembershipPlanController::class);
        
        // Team Hierarchy
        Route::resource('team', TeamHierarchyController::class);
    });

    // Social Interactions
    Route::post('/interactions/like', [SocialInteractionController::class, 'like'])->name('interactions.like');
    Route::post('/interactions/unlike', [SocialInteractionController::class, 'unlike'])->name('interactions.unlike');
    Route::post('/interactions/comment', [SocialInteractionController::class, 'comment'])->name('interactions.comment');
    Route::post('/interactions/share', [SocialInteractionController::class, 'share'])->name('interactions.share');
});

// Public routes (no auth required)
Route::prefix('business')->name('business.')->group(function () {
    Route::get('businesses/{business}', [BusinessController::class, 'show'])->name('businesses.show');
    Route::get('businesses', [BusinessController::class, 'index'])->name('businesses.index');
});

Route::middleware(['auth'])->group(function () {
    // Business Dashboard
    Route::get('/business/dashboard', [BusinessController::class, 'dashboard'])->name('business.dashboard');
    
    // User Settings
    Route::prefix('business/settings')->group(function () {
        Route::get('/', [UserSettingsController::class, 'index'])->name('business.settings');
        Route::put('/update', [UserSettingsController::class, 'update'])->name('business.settings.update');
        Route::put('/notifications', [UserSettingsController::class, 'updateNotificationPreferences'])->name('business.settings.notifications');
        Route::put('/privacy', [UserSettingsController::class, 'updatePrivacySettings'])->name('business.settings.privacy');
    });

    // Content Management
    Route::prefix('business/content')->group(function () {
        Route::get('/', [ContentManagerController::class, 'index'])->name('business.content');
        Route::post('/media', [ContentManagerController::class, 'storeMedia'])->name('business.content.media.store');
        Route::delete('/media/{id}', [ContentManagerController::class, 'deleteMedia'])->name('business.content.media.delete');
        Route::put('/media/{id}', [ContentManagerController::class, 'updateMediaDetails'])->name('business.content.media.update');
    });

    // Stories
    Route::resource('business/stories', StoryController::class)->names([
        'index' => 'business.stories.index',
        'create' => 'business.stories.create',
        'store' => 'business.stories.store',
        'show' => 'business.stories.show',
        'edit' => 'business.stories.edit',
        'update' => 'business.stories.update',
        'destroy' => 'business.stories.destroy',
    ]);

    // Franchises
    Route::resource('business/franchises', FranchiseController::class)->names([
        'index' => 'business.franchises.index',
        'create' => 'business.franchises.create',
        'store' => 'business.franchises.store',
        'show' => 'business.franchises.show',
        'edit' => 'business.franchises.edit',
        'update' => 'business.franchises.update',
        'destroy' => 'business.franchises.destroy',
    ]);

    // Team Hierarchy
    Route::prefix('business/team')->group(function () {
        Route::get('/', [TeamHierarchyController::class, 'index'])->name('business.team.index');
        Route::post('/departments', [TeamHierarchyController::class, 'storeDepartment'])->name('business.team.departments.store');
        Route::put('/departments/{id}', [TeamHierarchyController::class, 'updateDepartment'])->name('business.team.departments.update');
        Route::delete('/departments/{id}', [TeamHierarchyController::class, 'deleteDepartment'])->name('business.team.departments.delete');
    });

    // Membership Plans
    Route::resource('business/membership-plans', MembershipPlanController::class)->names([
        'index' => 'business.membership-plans.index',
        'create' => 'business.membership-plans.create',
        'store' => 'business.membership-plans.store',
        'show' => 'business.membership-plans.show',
        'edit' => 'business.membership-plans.edit',
        'update' => 'business.membership-plans.update',
        'destroy' => 'business.membership-plans.destroy',
    ]);

    // Social Interactions
    Route::prefix('business/social')->group(function () {
        Route::post('/follow/{business}', [BusinessFollowerController::class, 'follow'])->name('business.follow');
        Route::delete('/unfollow/{business}', [BusinessFollowerController::class, 'unfollow'])->name('business.unfollow');
        Route::post('/like/{type}/{id}', [SocialInteractionController::class, 'like'])->name('business.social.like');
        Route::post('/comment/{type}/{id}', [SocialInteractionController::class, 'comment'])->name('business.social.comment');
    });

    // Reviews
    Route::resource('business/reviews', ReviewController::class)->names([
        'index' => 'business.reviews.index',
        'store' => 'business.reviews.store',
        'show' => 'business.reviews.show',
        'update' => 'business.reviews.update',
        'destroy' => 'business.reviews.destroy',
    ]);

    // Appointments
    Route::resource('business/appointments', AppointmentController::class)->names([
        'index' => 'business.appointments.index',
        'create' => 'business.appointments.create',
        'store' => 'business.appointments.store',
        'show' => 'business.appointments.show',
        'edit' => 'business.appointments.edit',
        'update' => 'business.appointments.update',
        'destroy' => 'business.appointments.destroy',
    ]);

    // Services
    Route::resource('business/services', ServiceController::class)->names([
        'index' => 'business.services.index',
        'create' => 'business.services.create',
        'store' => 'business.services.store',
        'show' => 'business.services.show',
        'edit' => 'business.services.edit',
        'update' => 'business.services.update',
        'destroy' => 'business.services.destroy',
    ]);

    // Monetization
    Route::prefix('business/monetization')->group(function () {
        Route::get('/', [MonetizationController::class, 'index'])->name('business.monetization.index');
        Route::get('/transactions', [MonetizationController::class, 'transactions'])->name('business.monetization.transactions');
        Route::get('/subscriptions', [MonetizationController::class, 'subscriptions'])->name('business.monetization.subscriptions');
        Route::get('/pricing-plans', [MonetizationController::class, 'pricingPlans'])->name('business.monetization.pricing-plans');
        Route::post('/pricing-plans', [MonetizationController::class, 'storePricingPlan'])->name('business.monetization.pricing-plans.store');
        Route::put('/pricing-plans/{id}', [MonetizationController::class, 'updatePricingPlan'])->name('business.monetization.pricing-plans.update');
        Route::delete('/pricing-plans/{id}', [MonetizationController::class, 'deletePricingPlan'])->name('business.monetization.pricing-plans.delete');
    });
}); 