<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || !($user instanceof \App\Models\Admin)) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        return $next($request);
    }
}