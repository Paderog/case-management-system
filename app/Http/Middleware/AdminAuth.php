<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow login & logout routes
        if ($request->is('login') || $request->is('login/*')) {
            return $next($request);
        }

        if (!session()->has('admin_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
