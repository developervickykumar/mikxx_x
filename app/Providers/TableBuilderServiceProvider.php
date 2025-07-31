<?php

namespace App\Providers;

use App\Services\TableBuilderService;
use Illuminate\Support\ServiceProvider;

class TableBuilderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TableBuilderService::class, function ($app) {
            return new TableBuilderService();
        });
    }

    public function boot(): void
    {
        //
    }
} 