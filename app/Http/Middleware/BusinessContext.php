<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Business;

class BusinessContext
{
    public function handle(Request $request, Closure $next)
    {
        // Get business from route parameter
        $businessId = $request->route('business');
        
        if ($businessId) {
            $business = Business::findOrFail($businessId);
            
            // Share business with all views
            view()->share('business', $business);
            
            // Add business to request for controllers
            $request->merge(['business' => $business]);
        }

        return $next($request);
    }
} 