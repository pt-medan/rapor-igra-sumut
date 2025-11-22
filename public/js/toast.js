/**
 * Toast Notification System
 * Display toast notifications with different types: success, error, warning, info
 */

class Toast {
    static {
        this.container = null;
        this.initContainer();
    }

    /**
     * Initialize toast container
     */
    static initContainer() {
        if (document.getElementById('toast-container')) return;

        const container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        `;
        document.body.appendChild(container);
        this.container = container;
    }

    /**
     * Show toast notification
     * @param {string} message - The message to display
     * @param {string} type - The type: 'success', 'error', 'warning', 'info'
     * @param {number} duration - How long to show (ms), 0 = permanent
     */
    static show(message, type = 'info', duration = 4000) {
        if (!this.container) this.initContainer();

        const toast = document.createElement('div');
        const colors = {
            success: { bg: '#10b981', border: '#059669', icon: '✓' },
            error: { bg: '#ef4444', border: '#dc2626', icon: '✕' },
            warning: { bg: '#f59e0b', border: '#d97706', icon: '⚠' },
            info: { bg: '#3b82f6', border: '#1d4ed8', icon: 'ℹ' }
        };

        const config = colors[type] || colors.info;

        toast.style.cssText = `
            background: ${config.bg};
            color: white;
            padding: 16px 20px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-left: 4px solid ${config.border};
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 300px;
            max-width: 500px;
            word-wrap: break-word;
            animation: slideIn 0.3s ease-out;
        `;

        const iconSpan = document.createElement('span');
        iconSpan.style.cssText = `
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        `;
        iconSpan.textContent = config.icon;

        const messageSpan = document.createElement('span');
        messageSpan.style.cssText = `
            flex: 1;
            font-size: 14px;
            line-height: 1.5;
        `;
        messageSpan.textContent = message;

        const closeBtn = document.createElement('button');
        closeBtn.style.cssText = `
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
            flex-shrink: 0;
            opacity: 0.7;
            transition: opacity 0.2s;
        `;
        closeBtn.textContent = '×';
        closeBtn.onmouseover = () => closeBtn.style.opacity = '1';
        closeBtn.onmouseout = () => closeBtn.style.opacity = '0.7';
        closeBtn.onclick = () => this.remove(toast);

        toast.appendChild(iconSpan);
        toast.appendChild(messageSpan);
        toast.appendChild(closeBtn);

        this.container.appendChild(toast);

        // Add CSS animation
        if (!document.getElementById('toast-styles')) {
            const style = document.createElement('style');
            style.id = 'toast-styles';
            style.textContent = `
                @keyframes slideIn {
                    from {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes slideOut {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(400px);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => this.remove(toast), duration);
        }

        return toast;
    }

    /**
     * Remove toast element
     */
    static remove(toast) {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }

    /**
     * Convenience methods
     */
    static success(message, duration = 3000) {
        return this.show(message, 'success', duration);
    }

    static error(message, duration = 5000) {
        return this.show(message, 'error', duration);
    }

    static warning(message, duration = 4000) {
        return this.show(message, 'warning', duration);
    }

    static info(message, duration = 4000) {
        return this.show(message, 'info', duration);
    }
}

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Toast;
}
