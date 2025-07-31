<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class UserPreferences
{
    public function handle(Request $request, Closure $next)
    {
        // Set theme
        $theme = Session::get('theme', config('theme.default_theme'));
        view()->share('theme', $theme);

        // Set language
        $locale = Session::get('locale', config('app.locale'));
        App::setLocale($locale);
        view()->share('locale', $locale);

        // Set currency
        $currency = Session::get('currency', config('app.currency', 'USD'));
        view()->share('currency', $currency);

        // Set timezone
        $timezone = Session::get('timezone', config('app.timezone'));
        date_default_timezone_set($timezone);
        view()->share('timezone', $timezone);

        // Log activity
        if (auth()->check()) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ])
                ->log('page_visit');
        }

        return $next($request);
    }
} 