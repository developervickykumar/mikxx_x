<?php
// app/Http/Middleware/ActiveRoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ActiveRoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Session::has('active_role')) {
            Auth::user()->active_role = Session::get('active_role');
        } else {
            Auth::user()->active_role = Auth::user()->role;
        }

        return $next($request);
    }
}
