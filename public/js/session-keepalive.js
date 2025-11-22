/**
 * Session Keepalive - Keep user session alive during active browsing
 * 
 * Sends heartbeat request every 30 minutes to prevent session timeout
 * when user is actively using the application
 * 
 * Usage: Include this script in authenticated pages
 * <script src="{{ asset('js/session-keepalive.js') }}"></script>
 */

(function() {
    'use strict';

    const SessionKeepalive = {
        // Configuration - Shorter interval in development to prevent 419 errors
        // Development: 5 minutes (aggressive to prevent timeout during testing)
        // Production: 30 minutes (conservative to reduce server load)
        heartbeatInterval: window.location.hostname === 'localhost' || 
                          window.location.hostname === '127.0.0.1' ? 
                          (5 * 60 * 1000) :   // 5 minutes in development
                          (30 * 60 * 1000),   // 30 minutes in production
        heartbeatUrl: '/api/heartbeat',
        lastActivity: Date.now(),
        isActive: true,
        
        // Initialize session keepalive
        init: function() {
            // Log initialization
            console.log('[SessionKeepalive] Initialized - heartbeat every 30 minutes');
            
            // Track user activity
            this.trackActivity();
            
            // Start heartbeat timer
            this.startHeartbeat();
        },
        
        // Track user activity to know if still active
        trackActivity: function() {
            const events = ['mousedown', 'keydown', 'scroll', 'touchstart', 'click'];
            
            events.forEach(event => {
                document.addEventListener(event, () => {
                    this.lastActivity = Date.now();
                    this.isActive = true;
                }, { passive: true });
            });
            
            // Check if still active (window focus)
            window.addEventListener('focus', () => {
                this.isActive = true;
                console.log('[SessionKeepalive] Window focused');
            });
            
            window.addEventListener('blur', () => {
                this.isActive = false;
                console.log('[SessionKeepalive] Window blurred');
            });
        },
        
        // Send heartbeat to server
        sendHeartbeat: function() {
            // Only send if page is visible and user was active
            if (!document.hidden && this.isActive) {
                const csrfToken = this.getCsrfToken();
                
                if (!csrfToken) {
                    console.warn('[SessionKeepalive] CSRF token not found - skipping heartbeat');
                    return;
                }
                
                fetch(this.heartbeatUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        timestamp: Date.now()
                    })
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else if (response.status === 401) {
                        console.warn('[SessionKeepalive] Unauthorized - user session may have expired');
                        this.handleSessionExpired();
                    } else if (response.status === 419) {
                        console.warn('[SessionKeepalive] CSRF token mismatch (419)');
                        this.handleTokenMismatch();
                    }
                    return null;
                })
                .then(data => {
                    if (data && data.status === 'ok') {
                        console.log('[SessionKeepalive] Heartbeat sent successfully');
                        
                        // Update CSRF token if provided in response
                        if (data.csrf_token && window.CSRFManager) {
                            window.CSRFManager.updateToken(data.csrf_token);
                            console.log('[SessionKeepalive] CSRF token updated from server');
                        }
                    }
                })
                .catch(error => {
                    console.error('[SessionKeepalive] Error sending heartbeat:', error);
                });
            }
        },
        
        // Get CSRF token from meta tag
        getCsrfToken: function() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            if (meta) {
                return meta.getAttribute('content');
            }
            
            // Fallback: check form inputs
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) {
                return tokenInput.value;
            }
            
            return null;
        },
        
        // Start heartbeat interval
        startHeartbeat: function() {
            setInterval(() => {
                this.sendHeartbeat();
            }, this.heartbeatInterval);
            
            // Send first heartbeat after 1 minute
            setTimeout(() => {
                this.sendHeartbeat();
            }, 60 * 1000);
        },
        
        // Handle session expiration
        handleSessionExpired: function() {
            console.warn('[SessionKeepalive] Session has expired');
            // Show notification to user
            if (window.Toast) {
                window.Toast.error('Session expired. Please login again.');
            }
            // Optionally redirect to login
            // window.location.href = '/login';
        },
        
        // Handle CSRF token mismatch (419 error)
        handleTokenMismatch: function() {
            console.warn('[SessionKeepalive] CSRF Token Mismatch - attempting recovery');
            
            // Try to refresh page to get new token
            if (window.CSRFManager) {
                // Reload to get fresh CSRF token
                console.log('[SessionKeepalive] Reloading page to refresh CSRF token');
                window.location.reload();
            }
        }
    };
    
    // Start session keepalive when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            SessionKeepalive.init();
        });
    } else {
        SessionKeepalive.init();
    }
    
    // Expose to window for debugging
    window.SessionKeepalive = SessionKeepalive;
})();
