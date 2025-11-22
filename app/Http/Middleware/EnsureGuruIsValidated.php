<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware untuk memastikan guru hanya dapat mengakses aplikasi jika status = 'active'
 * Guru dengan status 'pending' akan logout otomatis
 * 
 * Ini mencegah guru baru yang belum divalidasi admin dari mengakses fitur apapun
 */
class EnsureGuruIsValidated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika user sudah authenticated dan role-nya guru
        if (Auth::check() && Auth::user()->role === 'guru') {
            // Jika status tidak 'active', logout dan redirect
            if (Auth::user()->status !== 'active') {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Akun guru Anda belum divalidasi oleh admin provinsi. Silakan tunggu persetujuan dari admin sebelum dapat mengakses aplikasi.');
            }
        }

        return $next($request);
    }
}
