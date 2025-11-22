/**
 * CSRF Manager - Handle CSRF Token Updates
 * 
 * Mengelola CSRF token refresh otomatis saat heartbeat
 * Memastikan form selalu memiliki token yang valid
 * 
 * Usage:
 * <script src="{{ asset('js/csrf-manager.js') }}"></script>
 */

(function() {
    'use strict';

    const CSRFManager = {
        // Configuration
        debug: true,  // Set to false in production
        tokenSelector: 'meta[name="csrf-token"]',
        formTokenSelector: 'input[name="_token"]',
        
        /**
         * Initialize CSRF Manager
         */
        init: function() {
            if (this.debug) {
                console.log('[CSRFManager] Initialized');
            }
            
            this.setupMetaToken();
            this.setupFormTokens();
            this.setupAjaxHeaders();
        },
        
        /**
         * Setup meta tag for CSRF token
         */
        setupMetaToken: function() {
            const metaTag = document.querySelector(this.tokenSelector);
            
            if (!metaTag) {
                console.warn('[CSRFManager] CSRF token meta tag not found');
                return;
            }
            
            if (this.debug) {
                console.log('[CSRFManager] Meta CSRF token found');
            }
        },
        
        /**
         * Update all form tokens
         */
        setupFormTokens: function() {
            const forms = document.querySelectorAll('form');
            
            if (this.debug) {
                console.log(`[CSRFManager] Found ${forms.length} forms`);
            }
            
            forms.forEach((form, index) => {
                const hasToken = form.querySelector(this.formTokenSelector);
                
                if (!hasToken && form.method.toUpperCase() === 'POST') {
                    // Form missing token, add it
                    const token = this.getToken();
                    if (token) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = '_token';
                        input.value = token;
                        form.appendChild(input);
                        
                        if (this.debug) {
                            console.log(`[CSRFManager] Added token to form ${index + 1}`);
                        }
                    }
                }
            });
        },
        
        /**
         * Setup AJAX default headers
         */
        setupAjaxHeaders: function() {
            // Setup fetch interceptor
            const originalFetch = window.fetch;
            
            window.fetch = function(...args) {
                const [resource, config] = args;
                
                // Add CSRF token to all POST/PUT/DELETE requests
                if (config && ['POST', 'PUT', 'DELETE', 'PATCH'].includes(config.method?.toUpperCase())) {
                    const headers = config.headers || {};
                    const token = CSRFManager.getToken();
                    
                    if (token) {
                        headers['X-CSRF-TOKEN'] = token;
                    }
                    
                    config.headers = headers;
                }
                
                return originalFetch.call(window, resource, config);
            };
            
            if (this.debug) {
                console.log('[CSRFManager] AJAX headers setup complete');
            }
        },
        
        /**
         * Get current CSRF token
         * @returns {string|null}
         */
        getToken: function() {
            // Try meta tag first
            const metaTag = document.querySelector(this.tokenSelector);
            if (metaTag) {
                return metaTag.getAttribute('content');
            }
            
            // Try first form input
            const formToken = document.querySelector(this.formTokenSelector);
            if (formToken) {
                return formToken.value;
            }
            
            return null;
        },
        
        /**
         * Update CSRF token from server response
         * Called by session-keepalive after heartbeat
         * @param {string} newToken
         */
        updateToken: function(newToken) {
            if (!newToken) {
                console.warn('[CSRFManager] No token provided to update');
                return;
            }
            
            // Update meta tag
            const metaTag = document.querySelector(this.tokenSelector);
            if (metaTag) {
                metaTag.setAttribute('content', newToken);
                if (this.debug) {
                    console.log('[CSRFManager] Updated meta token');
                }
            }
            
            // Update all form inputs with name="_token"
            const formTokens = document.querySelectorAll(this.formTokenSelector);
            formTokens.forEach(input => {
                input.value = newToken;
            });
            
            if (this.debug && formTokens.length > 0) {
                console.log(`[CSRFManager] Updated ${formTokens.length} form tokens`);
            }
            
            // Dispatch custom event for other scripts
            window.dispatchEvent(new CustomEvent('csrf-token-updated', {
                detail: { token: newToken }
            }));
        },
        
        /**
         * Validate CSRF token
         * @returns {boolean}
         */
        validateToken: function() {
            const token = this.getToken();
            
            if (!token || token.length < 10) {
                console.warn('[CSRFManager] Invalid or missing CSRF token');
                return false;
            }
            
            if (this.debug) {
                console.log('[CSRFManager] Token validation passed');
            }
            
            return true;
        },
        
        /**
         * Get token info for debugging
         */
        getTokenInfo: function() {
            const token = this.getToken();
            return {
                token: token ? token.substring(0, 10) + '...' : 'MISSING',
                length: token ? token.length : 0,
                fromMeta: !!document.querySelector(this.tokenSelector),
                fromForm: !!document.querySelector(this.formTokenSelector),
                formCount: document.querySelectorAll(this.formTokenSelector).length
            };
        }
    };
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            CSRFManager.init();
        });
    } else {
        CSRFManager.init();
    }
    
    // Expose to window for external use
    window.CSRFManager = CSRFManager;
})();
