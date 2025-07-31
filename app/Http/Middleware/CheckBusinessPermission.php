<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBusinessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $business = $request->route('business');

        if (!$business || !$request->user()->hasBusinessPermission($business, $permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 