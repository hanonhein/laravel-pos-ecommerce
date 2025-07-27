<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated AND is an admin
        if (Auth::check() && Auth::user()->is_admin) {
            // If they are, let them proceed to the requested page
            return $next($request);
        }

        // If they are not an admin, block them with a 403 Forbidden error
        abort(403, 'Unauthorized Action');
    }
}
