<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class OtherProjectServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register views
        $this->loadViewsFrom(resource_path('views/other-project'), 'other-project');
        
        // Register routes
        $this->registerRoutes();
        
        // Register migrations
        $this->loadMigrationsFrom(database_path('migrations/other-project'));
        
        // Register assets
        $this->publishes([
            resource_path('assets/other-project') => public_path('vendor/other-project'),
        ], 'other-project-assets');
    }
    
    /**
     * Register the routes for the other project.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'prefix' => 'other-project',
            'namespace' => 'App\Http\Controllers\OtherProject',
            'middleware' => ['web', 'auth'],
        ], function () {
            $this->loadRoutesFrom(base_path('routes/other-project.php'));
        });
        
        Route::group([
            'prefix' => 'api/other-project',
            'namespace' => 'App\Http\Controllers\OtherProject\Api',
            'middleware' => ['api'],
        ], function () {
            $this->loadRoutesFrom(base_path('routes/other-project-api.php'));
        });
    }
} 