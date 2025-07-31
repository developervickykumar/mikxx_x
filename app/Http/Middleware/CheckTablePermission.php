<?php

namespace App\Http\Middleware;

use App\Models\TableBuilder;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTablePermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $table = $request->route('tableBuilder');

        if (!$table instanceof TableBuilder) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        if (!$table->hasPermission($request->user(), $permission)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
} 