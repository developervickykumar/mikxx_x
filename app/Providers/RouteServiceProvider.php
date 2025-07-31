<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Models\HtmlTemplate;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/post.index';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
        
        // if (!app()->runningInConsole()) {
        // HtmlTemplate::where('active', true)->get()->each(function ($route) {
        //     Route::match([$route->method], $route->route, function () use ($route) {
        //         if ($route->controller && $route->controller_method) {
        //             $controller = app("\\App\\Http\\Controllers\\{$route->controller}");
        //             return $controller->{$route->controller_method}();
        //         }

        //         if ($route->view_file && view()->exists($route->view_file)) {
        //             return view($route->view_file);
        //         }

        //         if ($route->custom_logic) {
        //             return eval($route->custom_logic);
        //         }

        //         abort(404);
        //     });
        // });
    // }
    }
} 