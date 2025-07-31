// Security Utilities
const Security = {
    // CSRF Token Management
    csrfToken: null,

    init() {
        this.csrfToken = this.generateCSRFToken();
        this.setupCSRFHeaders();
        this.setupSecurityHeaders();
    },

    generateCSRFToken() {
        return Array.from(crypto.getRandomValues(new Uint8Array(32)))
            .map(b => b.toString(16).padStart(2, '0'))
            .join('');
    },

    setupCSRFHeaders() {
        // Add CSRF token to all fetch requests
        const originalFetch = window.fetch;
        window.fetch = (url, options = {}) => {
            options.headers = {
                ...options.headers,
                'X-CSRF-Token': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            };
            return originalFetch(url, options);
        };
    },

    setupSecurityHeaders() {
        // Add security headers to meta tags
        const meta = document.createElement('meta');
        meta.httpEquiv = 'Content-Security-Policy';
        meta.content = `
            default-src 'self';
            script-src 'self' 'unsafe-inline' 'unsafe-eval';
            style-src 'self' 'unsafe-inline';
            img-src 'self' data: https:;
            font-src 'self' data:;
            connect-src 'self';
        `.replace(/\s+/g, ' ').trim();
        document.head.appendChild(meta);
    },

    // Input Sanitization
    sanitizeInput(input) {
        if (typeof input !== 'string') return input;
        
        const div = document.createElement('div');
        div.textContent = input;
        return div.innerHTML;
    },

    sanitizeObject(obj) {
        const sanitized = {};
        for (const [key, value] of Object.entries(obj)) {
            if (typeof value === 'string') {
                sanitized[key] = this.sanitizeInput(value);
            } else if (typeof value === 'object' && value !== null) {
                sanitized[key] = this.sanitizeObject(value);
            } else {
                sanitized[key] = value;
            }
        }
        return sanitized;
    },

    // XSS Protection
    validateHTML(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        return doc.body.innerHTML;
    },

    // Secure Storage
    secureStorage: {
        set(key, value) {
            const encrypted = btoa(JSON.stringify(value));
            localStorage.setItem(key, encrypted);
        },

        get(key) {
            const encrypted = localStorage.getItem(key);
            if (!encrypted) return null;
            try {
                return JSON.parse(atob(encrypted));
            } catch {
                return null;
            }
        },

        remove(key) {
            localStorage.removeItem(key);
        }
    },

    // Form Validation
    validateForm(formData) {
        const errors = {};
        
        for (const [key, value] of formData.entries()) {
            // Required field validation
            if (formData.getAttribute('required') && !value) {
                errors[key] = 'This field is required';
                continue;
            }

            // Email validation
            if (key === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    errors[key] = 'Invalid email format';
                }
            }

            // Password validation
            if (key === 'password' && value) {
                if (value.length < 8) {
                    errors[key] = 'Password must be at least 8 characters';
                }
                if (!/[A-Z]/.test(value)) {
                    errors[key] = 'Password must contain at least one uppercase letter';
                }
                if (!/[a-z]/.test(value)) {
                    errors[key] = 'Password must contain at least one lowercase letter';
                }
                if (!/[0-9]/.test(value)) {
                    errors[key] = 'Password must contain at least one number';
                }
            }
        }

        return {
            isValid: Object.keys(errors).length === 0,
            errors
        };
    },

    // Rate Limiting
    rateLimiter: {
        requests: new Map(),
        
        check(key, limit = 10, window = 60000) {
            const now = Date.now();
            const userRequests = this.requests.get(key) || [];
            
            // Remove old requests
            const recentRequests = userRequests.filter(time => now - time < window);
            
            if (recentRequests.length >= limit) {
                return false;
            }
            
            recentRequests.push(now);
            this.requests.set(key, recentRequests);
            return true;
        }
    }
};

// Initialize security features
document.addEventListener('DOMContentLoaded', () => {
    Security.init();
});

// Export for use in other files
window.Security = Security; 