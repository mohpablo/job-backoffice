<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (auth()->guard('web')->check()) {
            $role = auth()->guard('web')->user()->role;
            $hasAccess = in_array($role, $roles);
            if (!$hasAccess) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Proceed with the request
        return $next($request);
    }
}
