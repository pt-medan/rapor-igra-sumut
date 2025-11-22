<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * HeartbeatController - Keep user session alive
 * 
 * Endpoint ini dipanggil oleh session-keepalive.js setiap 5 menit (dev) atau 30 menit (prod)
 * Fungsi: Update last_activity di session, refresh CSRF token, dan keep auth fresh
 */
class HeartbeatController extends Controller
{
    /**
     * Send heartbeat to keep session alive
     * 
     * POST /api/heartbeat
     * 
     * Response:
     * {
     *   "status": "ok",
     *   "timestamp": "2025-11-22T10:30:00Z",
     *   "session_expires_in": 720,  // minutes
     *   "csrf_token": "new_token"   // refreshed CSRF token
     * }
     */
    public function index(Request $request)
    {
        try {
            // User must be authenticated
            if (!$request->user()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                    'code' => 401
                ], 401);
            }

            // Get current session config
            $sessionLifetime = config('session.lifetime', 720);

            // Regenerate CSRF token for enhanced security
            $request->session()->regenerateToken();

            // Get new CSRF token
            $newCsrfToken = csrf_token();

            // Log heartbeat (optional - useful for debugging)
            // \Log::debug("Heartbeat from user {$request->user()->id}");

            // Return success response with new token
            return response()->json([
                'status' => 'ok',
                'message' => 'Session refreshed',
                'timestamp' => now()->toIso8601String(),
                'session_expires_in' => $sessionLifetime,  // remaining minutes
                'csrf_token' => $newCsrfToken,  // Send back new token for frontend
                'user_id' => $request->user()->id,
                'user_name' => $request->user()->name
            ], 200);

        } catch (\Exception $e) {
            // Log error
            \Log::error('Heartbeat error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Heartbeat failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Alternative: Check if session is still valid
     * 
     * GET /api/heartbeat/check
     * 
     * Useful for checking session validity without modifying it
     */
    public function check(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'status' => 'expired',
                'authenticated' => false
            ], 401);
        }

        return response()->json([
            'status' => 'ok',
            'authenticated' => true,
            'user_id' => $request->user()->id,
            'user_name' => $request->user()->name
        ], 200);
    }
}
