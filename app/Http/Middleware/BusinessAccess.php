<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $business = $request->route('business');

        if (!$business || !$request->user()->businesses->contains($business)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
