<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
            Paginator::useBootstrap();

        View::composer('layouts.right-sidebar', function ($view) {

            $primaryTabs = null;
        
            
            
                $primaryTabs = Category::where('parent_id', '103955')
                    ->where('status', 'Active')
                    ->orderBy('position')
                    ->get();
        
                
             
        
            $view->with('primaryTabs', $primaryTabs);
        });
        

    }
 
}
