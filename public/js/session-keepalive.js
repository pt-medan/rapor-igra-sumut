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
        // Configuration
        heartbeatInterval: 30 * 60 * 1000,  // 30 minutes in milliseconds
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
                        console.log('[SessionKeepalive] Heartbeat sent successfully');
                        return response.json();
                    } else if (response.status === 401) {
                        console.warn('[SessionKeepalive] Unauthorized - user session may have expired');
                        this.handleSessionExpired();
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
