<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware untuk prevent session expiration dengan touch session
 * pada setiap request authenticated
 * 
 * Ini memastikan last_activity di session table selalu ter-update
 * sehingga session tidak kadaluarsa saat user aktif browsing
 */
class TouchSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Update session last activity time
        // Laravel automatically does this, but explicitly ensure it
        if ($request->user()) {
            // Regenerate session ID every 2 hours untuk security
            if (
                !$request->session()->has('last_regenerated') ||
                now()->diffInHours($request->session()->get('last_regenerated')) >= 2
            ) {

                $request->session()->regenerate();
                $request->session()->put('last_regenerated', now());
            }
        }

        return $next($request);
    }
}
