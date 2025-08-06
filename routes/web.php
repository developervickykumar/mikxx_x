<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FormConditionController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\FormFieldTypeController;
use App\Http\Controllers\FormFieldCategoryController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\TableBuilderController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BusinessRoleController;
use App\Http\Controllers\BusinessPermissionController;
use App\Http\Controllers\BusinessPermissionGroupController;
use App\Http\Controllers\BusinessUserRoleController;
use App\Http\Controllers\BusinessAuditLogController;
use App\Http\Controllers\TabFormsController;
use App\Http\Controllers\FormFieldSettingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\PageBuilderController;
use App\Http\Controllers\FormTemplateController;
use App\Http\Controllers\TemplatePreviewController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleCategoryController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\PageTemplateController;
use App\Http\Controllers\ImprovementController;
use App\Http\Controllers\ModuleViewManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormBuilderController;

use App\Http\Controllers\MailController;

use App\Http\Controllers\AIBuilderController;
use App\Http\Controllers\Migration\AutoBuilderController;
use App\Http\Controllers\Migration\MigrationController;
use App\Http\Controllers\Migration\SchedulerController;

use App\Http\Controllers\MenuBuilderController;

use App\Http\Controllers\MediaController;
use App\Http\Controllers\HtmlTemplateController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\IconKeywordController;

use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\DynamicPageController;
use App\Http\Controllers\GiftController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BusinessProController;
use App\Http\Controllers\VehicleController;

Route::post('/admin/dynamic-pages/save', [DynamicPageController::class, 'save'])->name('dynamic-pages.save');
Route::get('/dynamic/{slug}', function($slug) {
    return view("dynamic-pages.$slug.index");
});
//email sending route
Route::post('send-mail',[MailController::class,'sendMail']);
// Route::get('{slug}', [DynamicPageController::class, 'render'])->where('slug', '.*');
Route::get('mail',function()
{
   return view('mail');
});

Route::post('/send-gift', [GiftController::class, 'send'])->name('send.gift');


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file.manager');
    Route::get('/file-manager/load', [FileManagerController::class, 'loadFile'])->name('file.manager.load');
    Route::post('/file-manager/save', [FileManagerController::class, 'saveFile'])->name('file.manager.save');
    Route::get('/file-manager/tree', [FileManagerController::class, 'fileTree'])->name('file.manager.tree');
    Route::post('/file-manager/create', [FileManagerController::class, 'createFile'])->name('file.manager.create');
    Route::get('/file-manager/history', [FileManagerController::class, 'fileHistory'])->name('file.manager.history');
    Route::get('/file-manager/history/load', [FileManagerController::class, 'loadHistoryVersion'])->name('file.manager.history.load');

    //category page
    // routes/web.php
    Route::post('/dynamic-page/save', [FileManagerController::class, 'saveDynamicPage'])->name('dynamic.page.save');

        Route::post('/html-templates/save-or-update', [HtmlTemplateController::class, 'saveOrUpdate']);

    Route::post('/ai/recheck-html', [HtmlTemplateController::class, 'recheck']);

    Route::get('/html-templates/{id}/edit', [HtmlTemplateController::class, 'fetchTemplate']);

    Route::post('/ai/custom-prompt', [HtmlTemplateController::class, 'customPrompt']);


});




Route::get('/categories/assign-icons', [CategoryController::class, 'autoAssignIconsFromJson']);

Route::get('/admin/icon-keywords', [IconKeywordController::class, 'index'])->name('icon-keywords.index');
Route::post('/admin/icon-keywords', [IconKeywordController::class, 'store'])->name('icon-keywords.store');
Route::post('/admin/icon-keywords/bulk-assign', [IconKeywordController::class, 'bulkAssign'])->name('icon-keywords.bulk.assign');


Route::get('/icon-keywords/assign-to-categories', [IconKeywordController::class, 'assignIconsToCategories'])->name('icon-keywords.assign');



Route::post('/generate-video', [MediaController::class, 'createVideo']);
Route::post('/extract-image', [MediaController::class, 'videoToImage']);
Route::get('/img-to-video', function () {
    return view('img-to-video');
});

Route::get('/phpinfo', function () {
    phpinfo();
});

// Include Business routes
// require __DIR__.'/business.php';

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::middleware(['auth'])->get('/switch-role/{role}', [App\Http\Controllers\RoleSwitchController::class, 'switch'])->name('switch.role');
Route::put('update-profile/{id}', [HomeController::class, 'updateProfile'])->name('update.profile');


Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');

    Route::middleware('auth')->group(function () {


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');



        Route::get('/tab-form/{parent_id?}', [tabFormsController::class, 'tabForm'])->name('tab.form');
        Route::get('/tab-form-management', [TabFormsController::class, 'index'])->name('tab-form-management');
        Route::get('/form-management-view', [TabFormsController::class, 'formManagementView'])->name('form-management-view');
        Route::get('/tab-form/{parent_id}', [TabFormController::class, 'edit'])->name('tab.form');
        Route::post('/tab-settings/{id}/save', [TabFormController::class, 'saveSettings'])->name('tab.settings.save');



        Route::get('/form-report', [TabFormsController::class, 'formReport'])->name('form-report');

        Route::get('/profile-settings', [ProfileController::class, 'index'])->name('profile.settings');

        Route::get('/user-settings', [UserSettingsController::class, 'index'])->name('user.settings');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.view');


        // Form Conditions Routes
        Route::prefix('form-conditions')->group(function () {
            Route::post('/', [FormConditionController::class, 'store']);
            Route::put('/{condition}', [FormConditionController::class, 'update']);
            Route::delete('/{condition}', [FormConditionController::class, 'destroy']);
            Route::post('/evaluate', [FormConditionController::class, 'evaluate'])->name('form-conditions.evaluate');
        });

        // Form Builder Routes
        Route::prefix('admin')->group(function() {
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



            // categories

            Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

            Route::resource('categories', CategoryController::class);


            Route::get('/form-builder/get-child-by-name/{name}', [FormBuilderController::class, 'getChildByName']);

            Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
            Route::post('/categories/{id}/update', [CategoryController::class, 'update']);
            Route::get('/categories/show/{name}', [CategoryController::class, 'show'])->name('categories.show');

            Route::post('/categories/{id}/copy', [CategoryController::class, 'copyCategory']);
            Route::post('/categories/{id}/move', [CategoryController::class, 'moveCategory']);

            Route::post('/categories/{id}/verify-pin', [CategoryController::class, 'verifyPin'])->name('categories.verifyPin');
            // Route::post('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
            Route::post('/categories/{id}/update-status', [CategoryController::class, 'updateStatus']);

            Route::post('/categories/{id}/toggle-protection', [CategoryController::class, 'toggleProtection']);


            Route::post('/category/{id}/update-icon', [CategoryController::class, 'updateIcon']);
            Route::post('/categories/{id}/update-image', [CategoryController::class, 'updateImage'])->name('category.updateImage');

            Route::post('categories/reorder', [CategoryController::class, 'reorder']);

            Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction']);

            Route::post('/hierarchy/store', [CategoryController::class, 'storeHierarchy']);

            Route::get('/hierarchy/{id}/children', [CategoryController::class, 'getHierarchyChildren']);


            Route::post('/category-media-upload', [CategoryController::class, 'mediaUpload'])->name('category.media.upload');
            // Route::put('/update-category-media/{id}', [CategoryController::class, 'categoryUpdate']);
            Route::delete('/delete-category-media/{id}', [CategoryController::class, 'categoryMediaDestroy']);

            Route::get('/categories/icon-by-label/{label}', [CategoryController::class, 'getIconByLabel']);



            Route::get('/categories/{id}/children', [CategoryController::class, 'getChildren']);



            Route::get('/categories/children-by-name/{name}', [CategoryController::class, 'getChildrenByName']);

            Route::post('/category/store-app-label', [App\Http\Controllers\CategoryController::class, 'storeAppLabel'])->name('category.storeAppLabel');

            Route::get('/categories/filter-by-label/{label}', [CategoryController::class, 'filterByLabel']);

            Route::get('/categories/{id}/all-subcategories', [CategoryController::class, 'getAllSubcategories']);


            //builder

            Route::get('/choose-builder', [BuilderController::class, 'chooseBuilder'])->name('builder.choose-builder');
            Route::get('/builder', [BuilderController::class, 'index'])->name('builder.index');

        });
    });
});


Route::middleware(['auth'])->group(function () {

    Route::post('/posts/{id}/like', [PostController::class, 'toggleLike'])->name('posts.like');
Route::post('/post/{post}/comment', [PostController::class, 'storeComment'])->name('post.comment');

});

Route::prefix('admin')->group(function () {

    Route::get('/post', [PostController::class, 'index'])->name('post.index');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');

    //categories
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

    Route::resource('categories', CategoryController::class);

    Route::get('/form-builder/get-child-by-name/{name}', [FormBuilderController::class, 'getChildByName']);

    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/categories/{id}/update', [CategoryController::class, 'update']);

    Route::get('/categories/show/{name}', [CategoryController::class, 'show'])->name('categories.show');

    Route::post('/categories/{id}/copy', [CategoryController::class, 'copyCategory']);
    Route::post('/categories/{id}/move', [CategoryController::class, 'moveCategory']);

    Route::post('/categories/{id}/verify-pin', [CategoryController::class, 'verifyPin'])->name('categories.verifyPin');
    // Route::post('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
    Route::post('/categories/{id}/update-status', [CategoryController::class, 'updateStatus']);

    Route::post('/categories/{id}/toggle-protection', [CategoryController::class, 'toggleProtection']);

    Route::post('/category/{id}/update-icon', [CategoryController::class, 'updateIcon']);
    Route::post('/categories/{id}/update-image', [CategoryController::class, 'updateImage'])->name('category.updateImage');

    Route::post('categories/reorder', [CategoryController::class, 'reorder']);

    Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction']);

    Route::post('/hierarchy/store', [CategoryController::class, 'storeHierarchy']);

    Route::get('/hierarchy/{id}/children', [CategoryController::class, 'getHierarchyChildren']);

    Route::post('/category-media-upload', [CategoryController::class, 'mediaUpload'])->name('category.media.upload');
    // Route::put('/update-category-media/{id}', [CategoryController::class, 'categoryUpdate']);
    Route::delete('/delete-category-media/{id}', [CategoryController::class, 'categoryMediaDestroy']);

    Route::get('/categories/icon-by-label/{label}', [CategoryController::class, 'getIconByLabel']);

    Route::get('/categories/{id}/children', [CategoryController::class, 'getChildren']);


    Route::get('/categories/{id}/counts', [CategoryController::class, 'getCounts']);


    Route::get('/categories/{id}/direct-subcategories', [CategoryController::class, 'getDirectSubcategories']);




    Route::get('/quick-access/view/{id}', [CategoryController::class, 'showQuickAccess'])->name('quick.access.view');




    Route::post('/update-profile/bio-achievements', [ProfileController::class, 'updateBioAndAchievements'])->name('update.profile.bio.achievements');

    Route::get('candidates-list', [CandidateController::class, 'view'])->name('candidate.list');


    Route::post('/media/upload', [CandidateController::class, 'storeMedia'])->name('media.upload');
    Route::post('/media/like', [CandidateController::class, 'storeLike'])->name('like.store');
    Route::post('/media/comment', [CandidateController::class, 'storeComment'])->name('comment.store');


    // routes/web.php


});

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/assign-role', [UserController::class, 'assignRoleForm'])->name('users.assignRoleForm');
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('/updateProfileFields', [ProfileController::class, 'updateProfileFields'])->name('updateProfileFields');
    Route::put('/users/{user}/update-picture', [UserController::class, 'updatePicture'])->name('users.updatePicture');
    Route::get('/audit-logs', [AuditController::class, 'index'])->name('audit.index');
    Route::get('/user-details/{id}', [UserController::class, 'details'])->name('user.detail');

    Route::get('/business/{slug}', [UserController::class, 'userBusiness'])->name('user.business');



Route::get('/categories/{id}/childrens', [CategoryController::class, 'getChildrens']);

Route::get('/categories/children-by-name/{name}', [CategoryController::class, 'getChildrenByName']);
Route::get('admin/categories/{id}/children-html', [CategoryController::class, 'getChildrenHtml']);


Route::post('/category/store-app-label', [App\Http\Controllers\CategoryController::class, 'storeAppLabel'])->name('category.storeAppLabel');

Route::get('/categories/filter-by-label/{label}', [CategoryController::class, 'filterByLabel']);

// Post Shortcuts
Route::get('/post/shortcut', [App\Http\Controllers\PostShortcutController::class, 'index'])->name('post.shortcut');

// Individual Create Pages
Route::get('/post/create/{type}', [App\Http\Controllers\PostShortcutController::class, 'create'])->name('post.create');

require __DIR__.'/auth.php';

Route::get('/edit-profile/{id}', [App\Http\Controllers\HomeController::class, 'editProfile'])->name('editProfile');
Route::post('/media/upload', [CandidateController::class, 'storeMedia'])->name('media.upload');

Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::patch('/admin/password', [HomeController::class, 'updateAdminPassword'])->name('admin.updatePassword');

// Public Form Routes
Route::get('forms/{slug}', [FormController::class, 'render'])->name('forms.render');
Route::post('forms/{slug}/submit', [FormController::class, 'submit'])->name('forms.submit');


    Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');

    Route::resource('categories', CategoryController::class);


    Route::get('/form-builder/get-child-by-name/{name}', [FormBuilderController::class, 'getChildByName']);

    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/categories/{id}/update', [CategoryController::class, 'update']);

    Route::get('/categories/show/{name}', [CategoryController::class, 'show'])->name('categories.show');

    Route::post('/categories/{id}/copy', [CategoryController::class, 'copyCategory']);
    Route::post('/categories/{id}/move', [CategoryController::class, 'moveCategory']);

    Route::post('/categories/{id}/verify-pin', [CategoryController::class, 'verifyPin'])->name('categories.verifyPin');
    // Route::post('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
    Route::post('/categories/{id}/update-status', [CategoryController::class, 'updateStatus']);

    Route::post('/categories/{id}/toggle-protection', [CategoryController::class, 'toggleProtection']);


    Route::post('/category/{id}/update-icon', [CategoryController::class, 'updateIcon']);
    Route::post('/categories/{id}/update-image', [CategoryController::class, 'updateImage'])->name('category.updateImage');

    Route::post('categories/reorder', [CategoryController::class, 'reorder']);

    Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction']);

    Route::post('/hierarchy/store', [CategoryController::class, 'storeHierarchy']);

    Route::get('/hierarchy/{id}/children', [CategoryController::class, 'getHierarchyChildren']);


    Route::post('/category-media-upload', [CategoryController::class, 'mediaUpload'])->name('category.media.upload');
    // Route::put('/update-category-media/{id}', [CategoryController::class, 'categoryUpdate']);
    Route::delete('/delete-category-media/{id}', [CategoryController::class, 'categoryMediaDestroy']);

    Route::get('/categories/icon-by-label/{label}', [CategoryController::class, 'getIconByLabel']);



// Table Builder Routes
Route::middleware(['auth'])->group(function () {
    // Basic CRUD
    Route::get('/table-builder', [TableBuilderController::class, 'index'])->name('table-builder.index');
    Route::get('/table-builder/create', [TableBuilderController::class, 'create'])->name('table-builder.create');
    Route::post('/table-builder', [TableBuilderController::class, 'store'])->name('table-builder.store');
    Route::get('/table-builder/{tableBuilder}', [TableBuilderController::class, 'show'])->name('table-builder.show');
    Route::get('/table-builder/{tableBuilder}/edit', [TableBuilderController::class, 'edit'])->name('table-builder.edit');
    Route::put('/table-builder/{tableBuilder}', [TableBuilderController::class, 'update'])->name('table-builder.update');
    Route::delete('/table-builder/{tableBuilder}', [TableBuilderController::class, 'destroy'])->name('table-builder.destroy');

    // Table Actions
    Route::post('/table-builder/{tableBuilder}/generate', [TableBuilderController::class, 'generate'])->name('table-builder.generate');
    Route::post('/table-builder/{tableBuilder}/duplicate', [TableBuilderController::class, 'duplicate'])->name('table-builder.duplicate');
    Route::post('/table-builder/{tableBuilder}/save-template', [TableBuilderController::class, 'saveAsTemplate'])->name('table-builder.save-template');
    Route::post('/table-builder/bulk-action', [TableBuilderController::class, 'bulkAction'])->name('table-builder.bulk-action');

    // Form & Graph
    Route::get('/table-builder/{tableBuilder}/create-form', [TableBuilderController::class, 'createForm'])->name('table-builder.create-form');
    Route::get('/table-builder/{tableBuilder}/create-graph', [TableBuilderController::class, 'createGraph'])->name('table-builder.create-graph');

    // Templates
    Route::get('/table-builder/templates', [TableBuilderController::class, 'templatesIndex'])->name('table-builder.templates.index');
    Route::get('/table-builder/templates/{template}', [TableBuilderController::class, 'showTemplate'])->name('table-builder.templates.show');
    Route::post('/table-builder/templates/{template}/create', [TableBuilderController::class, 'createFromTemplate'])->name('table-builder.templates.create');

    // Import/Export
    Route::post('/table-builder/import', [TableBuilderController::class, 'import'])->name('table-builder.import');
    Route::post('/table-builder/export', [TableBuilderController::class, 'export'])->name('table-builder.export');

    // Categories & Tags
    Route::put('/table-builder/{tableBuilder}/category', [TableBuilderController::class, 'updateCategory'])->name('table-builder.update-category');
    Route::put('/table-builder/{tableBuilder}/tags', [TableBuilderController::class, 'updateTags'])->name('table-builder.update-tags');
    Route::get('/table-builder/categories', [TableBuilderController::class, 'getCategories'])->name('table-builder.categories');
    Route::get('/table-builder/tags', [TableBuilderController::class, 'getTags'])->name('table-builder.tags');

    // Search
    Route::get('/table-builder/search', [TableBuilderController::class, 'search'])->name('table-builder.search');
});
Route::post('/form-builder/save', [FormBuilderController::class, 'store'])->name('form.builder.save');



Route::post('forms/fields/save-settings', [FormFieldController::class, 'saveFieldSettings'])->name('forms.fields.saveSettings');




// Role Management Routes
Route::middleware(['auth', 'permission:manage_roles'])->group(function () {
    Route::resource('roles', RoleController::class);
});

// Permission Management Routes
Route::middleware(['auth', 'business.context'])->group(function () {
    Route::prefix('business/{business}')->name('business.')->group(function () {
        // Roles
        Route::resource('roles', \App\Http\Controllers\Business\BusinessRoleController::class);

        // Permissions
        Route::resource('permissions', \App\Http\Controllers\Business\BusinessPermissionController::class);

        // Permission Groups
        Route::resource('permission-groups', \App\Http\Controllers\Business\BusinessPermissionGroupController::class);

        // User Roles
        Route::resource('user-roles', \App\Http\Controllers\Business\BusinessUserRoleController::class);

        // Audit Logs
        Route::get('audit-logs', [\App\Http\Controllers\Business\BusinessAuditLogController::class, 'index'])->name('audit-logs.index');
    });
});



// Business Management Routes
Route::middleware(['auth'])->group(function () {
    // Business Management Routes
    Route::prefix('business')->name('business.')->group(function () {
        // Business Profile Routes
        Route::get('/profile', [\App\Http\Controllers\Business\BusinessProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [\App\Http\Controllers\Business\BusinessProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Business\BusinessProfileController::class, 'update'])->name('profile.update');
        Route::get('/pro', [\App\Http\Controllers\Business\BusinessProfileController::class, 'profiles'])->name('business.pro');

        // Existing Business Routes
        Route::get('/', [\App\Http\Controllers\Business\BusinessController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Business\BusinessController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Business\BusinessController::class, 'store'])->name('store');
        Route::get('/{business}', [\App\Http\Controllers\Business\BusinessController::class, 'show'])->name('show');
        Route::get('/{business}/edit', [\App\Http\Controllers\Business\BusinessController::class, 'edit'])->name('edit');
        Route::put('/{business}', [\App\Http\Controllers\Business\BusinessController::class, 'update'])->name('update');
        Route::delete('/{business}', [\App\Http\Controllers\Business\BusinessController::class, 'destroy'])->name('destroy');
    });

});


Route::middleware(['business_access'])->group(function () {

    Route::get('/business/dashboard', [BusinessDashboardController::class, 'index'])->name('business.dashboard');

});


Route::post('/form-field-settings/save', [FormFieldSettingController::class, 'save'])->name('form-field-settings.save');

// Sitemap Routes
Route::middleware(['auth'])->group(function () {
    // Admin Sitemap
    Route::get('/admin/sitemap', [SitemapController::class, 'index'])
        ->middleware(['permission:view_sitemap'])
        ->name('admin.sitemap');

    // Business Sitemap
    Route::get('/business/sitemap', [SitemapController::class, 'businessSitemap'])
        ->middleware(['business.context'])
        ->name('business.sitemap');

    // User Sitemap
    Route::get('/user/sitemap', [SitemapController::class, 'userSitemap'])
        ->name('user.sitemap');
});

// Public Sitemap (limited access)
Route::get('/sitemap', [SitemapController::class, 'publicSitemap'])
    ->name('sitemap');

// Page Builder Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/page-builder', [PageBuilderController::class, 'index'])->name('page-builder.index');
    Route::post('/page-builder/save', [PageBuilderController::class, 'save'])->name('page-builder.save');
    Route::get('/page-builder/preview/{id}', [PageBuilderController::class, 'preview'])->name('page-builder.preview');
    Route::get('/page-builder/export/{id}', [PageBuilderController::class, 'export'])->name('page-builder.export');
    Route::get('/page-builder/components', [PageBuilderController::class, 'getComponents'])->name('page-builder.components');
});

Route::post('/preview-result-template', function (\Illuminate\Http\Request $request) {
    $data = $request->except('_token');
    $type = $request->input('preview_type', 'default');

    return view('templates.result-view-templates.' . $type, [
        'data' => $data
    ]);
});

Route::prefix('templates')->group(function () {
    Route::get('/', [FormTemplateController::class, 'index'])->name('form-templates.index');
    Route::get('/create', [FormTemplateController::class, 'create'])->name('form-templates.create');
    Route::post('/store', [FormTemplateController::class, 'store'])->name('form-templates.store');
    Route::get('/{template}', [FormTemplateController::class, 'show'])->name('form-templates.show');
    Route::put('/templates/{template}', [TemplateController::class, 'update'])->name('templates.update');

});

Route::prefix('page-templates')->group(function () {
    Route::get('/', [PageTemplateController::class, 'index'])->name('page-templates.index');
    Route::get('/create', [PageTemplateController::class, 'create'])->name('page-templates.create');
    Route::post('/store', [PageTemplateController::class, 'store'])->name('page-templates.store');
    Route::get('/{template}', [PageTemplateController::class, 'show'])->name('page-templates.show');
    // Route::put('/page-templates/{template}', [PageTemplateController::class, 'update'])->name('page-templates.update');
});

Route::put('/page-templates/update/{id}', [PageTemplateController::class, 'update'])->name('page-templates.update');

Route::post('/preview-result-template', [TemplatePreviewController::class, 'preview'])->name('preview.result');



Route::resource('modules', ModuleController::class);

Route::get('module/category/', [ModuleCategoryController::class, 'index'])->name('module.category.index');
Route::post('module/category/store', [ModuleCategoryController::class, 'store'])->name('module.category.store');
Route::delete('module/category/{category}', [ModuleCategoryController::class, 'destroy'])->name('module.category.destroy');
Route::get('module/category/edit/{id}', [ModuleCategoryController::class, 'edit'])->name('module.category.edit');
Route::put('module/category/{id}', [ModuleCategoryController::class, 'update'])->name('module.category.update');
Route::get('module/get-categories/{category_type}', [ModuleCategoryController::class, 'getCategoriesByType']);
Route::get('/module-detail/{moduleId}',  [ModuleController::class, 'moduleDetail'])->name('module-detail');

Route::get('/ajax/category/{id}/template', [CategoryController::class, 'loadTemplate']);

Route::post('/improvements', [ImprovementController::class, 'store']);
Route::get('/improvements/{category_id}', [ImprovementController::class, 'index']);
Route::put('/improvements/{id}', [ImprovementController::class, 'update']);

Route::get('/module-view-management', [ModuleViewManagementController::class, 'index'])->name('module-view-management');
Route::get('/module-view/{parentId}', [ModuleViewManagementController::class, 'moduleView'])->name('module.view');


// Module Management
Route::prefix('admin')->group(function () {
    Route::get('/modules', [AutoBuilderController::class, 'listModules']);
    Route::get('/module/{id}', [AutoBuilderController::class, 'viewModule']);
    Route::post('/module/{id}/export', [AutoBuilderController::class, 'exportModule']);
    Route::delete('/module/{id}', [AutoBuilderController::class, 'deleteModule']);
    Route::patch('/module/{id}/status', [AutoBuilderController::class, 'updateModuleStatus']);

    // Migration Routes
    Route::post('/run-migrations', [MigrationController::class, 'run']);
    Route::post('/rollback-migrations', [MigrationController::class, 'rollback']);
    Route::post('/run-seeder', [MigrationController::class, 'seed']);
    Route::get('/migration-status', [MigrationController::class, 'status']);

    // Scheduler Routes
    Route::get('/scheduled-tasks', [SchedulerController::class, 'index']);
    Route::post('/run-task', [SchedulerController::class, 'runTask']);
});


Route::view('/code-generator/html-builder-dashboard', 'code-generator.html-builder-dashboard')->name('code-generator.html-builder-dashboard');


// File Operations
Route::post('/auto-builder/export-zip', [AutoBuilderController::class, 'exportZip']);
Route::post('/auto-builder/save-file', [AutoBuilderController::class, 'saveFile']);

Route::view('/code-generator', 'code-generator.dashboard')->name('code-generator.dashboard');
Route::view('/code-generator/template-library', 'code-generator.template-library')->name('code-generator.template-library');
Route::view('/code-generator/ai-content-suggestion', 'code-generator.ai-content-suggestion')->name('code-generator.ai-content-suggestion');
Route::view('/code-generator/user-activity-log', 'code-generator.user-activity-log')->name('code-generator.user-activity-log');
Route::view('/code-generator/export-html-output', 'code-generator.export-html-output')->name('code-generator.export-html-output');
Route::view('/code-generator/new-html-builder', 'code-generator.new-html-builder')->name('code-generator.new-html-builder');

Route::view('/code-generator/analytics', 'code-generator.analytics')->name('code-generator.analytics');
Route::view('/code-generator/code-generator-dashboard', 'code-generator.code-generator-dashboard')->name('code-generator.code-generator-dashboard');
Route::view('/code-generator/code-generator-dashboard', 'code-generator.code-generator-dashboard')->name('code-generator.code-generator-dashboard');
Route::view('/code-generator/code-generator-dashboard', 'code-generator.code-generator-dashboard')->name('code-generator.code-generator-dashboard');


Route::put('/admin/categories/{id}/update-code', [CategoryController::class, 'updateCode'])->name('categories.updateCode');

Route::post('/admin/ai/generate-html', [AIBuilderController::class, 'generateHtml']);

Route::get('/check-env', function () {
    return [
        'env_file' => base_path('.env'),
        'api_key' => env('OPENAI_API_KEY'),
    ];
});

Route::get('/menu-builder', [MenuBuilderController::class, 'index']);

Route::view('/chat', 'backend.chat')->name('chat.index');

//shopping

Route::get('/shopping', [ShoppingController::class, 'index'])->name('shopping.index');



Route::post('/category/toggle-publish', [CategoryController::class, 'togglePublish'])->name('category.toggle-publish');

Route::post('/admin/html-template', [HtmlTemplateController::class, 'store'])->name('html-template.store');

Route::get('user-profile', [ProfileController::class, 'showProfile'])->name('profile.edit');
Route::post('user-profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

Route::get('logout',function(){
    Auth::logout();
    dd('success');
});

Route::get('/pro',[BusinessProController::class,'index'])->name('pro');

require base_path('routes/dynamic-routes.php');



Route::get('/product',[VehicleController::class,'product'])->name('product');
Route::get('/prodview',[VehicleController::class,'prodview'])->name('prodview');

Route::get('/proview', [VehicleController::class, 'proview'])->name('proview');

Route::get('vehicle/fetch-children/{id}', function ($id) {
    return \App\Models\Category::where('parent_id', $id)->with('child.child')->get();
});

Route::get('/vehicle/fetch-childrenn/{parent_id}', function ($parent_id) {
    return \App\Models\Category::where('parent_id', $parent_id)->get();
});

Route::get('/vehicle/create', [VehicleController::class, 'create']);
Route::get('/vehicle/fetch-child/{id}', [VehicleController::class, 'fetchChildren']);
Route::post('/vehicle/store', [VehicleController::class, 'pstore'])->name('vehicle.store');

//google seet upload files
Route::post('import',[VehicleController::class, 'importCSV'])->name('import.csv');
Route::get('product/export/{type}',[vehicleController::class, 'export'])->name('product.export');
//embed route

//product builder
Route::get('productBuilder',[VehicleController::class, 'productBuilder'])->name('productBuilder');

