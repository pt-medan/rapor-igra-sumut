<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to check if guru account is verified/active by admin provinsi
 * 
 * Guru accounts with status other than 'active' cannot access guru features
 * This ensures only approved accounts can use the application
 */
class GuruVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Only check for guru role
        if (Auth::check() && Auth::user()->role === 'guru') {
            // If guru status is not 'active', redirect to pending page
            if (Auth::user()->status !== 'active') {
                Auth::logout();

                return redirect()->route('login')
                    ->with('error', 'Akun guru Anda belum divalidasi oleh admin provinsi. Silakan tunggu persetujuan.');
            }
        }

        return $next($request);
    }
}
