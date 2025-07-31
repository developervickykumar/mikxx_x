<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register view composers
        $this->registerViewComposers();

        // Register blade components
        $this->registerBladeComponents();

        // Register blade directives
        $this->registerBladeDirectives();
    }

    /**
     * Register view composers.
     */
    protected function registerViewComposers(): void
    {
        // Example view composer
        // View::composer('*', function ($view) {
        //     $view->with('sharedData', []);
        // });
    }

    /**
     * Register blade components.
     */
    protected function registerBladeComponents(): void
    {
        // Register business permission component
        Blade::component('business-permission', \App\View\Components\BusinessPermission::class);
    }

    /**
     * Register blade directives.
     */
    protected function registerBladeDirectives(): void
    {
        // Example directive
        // Blade::directive('example', function ($expression) {
            // return "<?php echo 'Example: ' . {$expression}; ?";
        // });
    }
} 