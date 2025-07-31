// Authentication and Authorization System
const Auth = {
    // Configuration
    config: {
        tokenKey: 'auth_token',
        refreshTokenKey: 'refresh_token',
        tokenExpiryKey: 'token_expiry',
        roles: {
            ADMIN: 'admin',
            MANAGER: 'manager',
            USER: 'user',
            GUEST: 'guest'
        },
        permissions: {
            VIEW_ANALYTICS: 'view_analytics',
            MANAGE_USERS: 'manage_users',
            MANAGE_SETTINGS: 'manage_settings',
            EXPORT_DATA: 'export_data',
            VIEW_REPORTS: 'view_reports'
        },
        rolePermissions: {
            admin: [
                'view_analytics',
                'manage_users',
                'manage_settings',
                'export_data',
                'view_reports'
            ],
            manager: [
                'view_analytics',
                'view_reports',
                'export_data'
            ],
            user: [
                'view_reports'
            ],
            guest: []
        }
    },

    // State
    state: {
        user: null,
        token: null,
        refreshToken: null,
        tokenExpiry: null,
        isAuthenticated: false,
        currentRole: null
    },

    // Initialize authentication
    init() {
        this.loadStoredAuth();
        this.setupAuthListeners();
        this.checkTokenExpiry();
    },

    // Load stored authentication data
    loadStoredAuth() {
        this.state.token = localStorage.getItem(this.config.tokenKey);
        this.state.refreshToken = localStorage.getItem(this.config.refreshTokenKey);
        this.state.tokenExpiry = localStorage.getItem(this.config.tokenExpiryKey);
        
        if (this.state.token) {
            this.state.isAuthenticated = true;
            this.decodeAndSetUser();
        }
    },

    // Setup authentication event listeners
    setupAuthListeners() {
        // Listen for token expiry
        setInterval(() => this.checkTokenExpiry(), 60000);

        // Listen for storage changes (for multi-tab support)
        window.addEventListener('storage', (e) => {
            if (e.key === this.config.tokenKey) {
                this.loadStoredAuth();
            }
        });
    },

    // Check token expiry and refresh if needed
    checkTokenExpiry() {
        if (!this.state.tokenExpiry) return;

        const expiryTime = new Date(this.state.tokenExpiry).getTime();
        const currentTime = new Date().getTime();
        const timeUntilExpiry = expiryTime - currentTime;

        if (timeUntilExpiry <= 0) {
            this.logout();
        } else if (timeUntilExpiry <= 300000) { // 5 minutes
            this.refreshToken();
        }
    },

    // Login user
    async login(email, password) {
        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            if (!response.ok) {
                throw new Error('Login failed');
            }

            const data = await response.json();
            this.setAuthData(data);
            return true;
        } catch (error) {
            console.error('Login error:', error);
            return false;
        }
    },

    // Register new user
    async register(userData) {
        try {
            const response = await fetch('/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            if (!response.ok) {
                throw new Error('Registration failed');
            }

            const data = await response.json();
            this.setAuthData(data);
            return true;
        } catch (error) {
            console.error('Registration error:', error);
            return false;
        }
    },

    // Logout user
    logout() {
        this.state.user = null;
        this.state.token = null;
        this.state.refreshToken = null;
        this.state.tokenExpiry = null;
        this.state.isAuthenticated = false;
        this.state.currentRole = null;

        localStorage.removeItem(this.config.tokenKey);
        localStorage.removeItem(this.config.refreshTokenKey);
        localStorage.removeItem(this.config.tokenExpiryKey);

        // Dispatch logout event
        window.dispatchEvent(new CustomEvent('auth:logout'));
    },

    // Refresh authentication token
    async refreshToken() {
        if (!this.state.refreshToken) return false;

        try {
            const response = await fetch('/api/auth/refresh', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    refreshToken: this.state.refreshToken
                })
            });

            if (!response.ok) {
                throw new Error('Token refresh failed');
            }

            const data = await response.json();
            this.setAuthData(data);
            return true;
        } catch (error) {
            console.error('Token refresh error:', error);
            this.logout();
            return false;
        }
    },

    // Set authentication data
    setAuthData(data) {
        this.state.token = data.token;
        this.state.refreshToken = data.refreshToken;
        this.state.tokenExpiry = data.expiry;
        this.state.isAuthenticated = true;

        localStorage.setItem(this.config.tokenKey, data.token);
        localStorage.setItem(this.config.refreshTokenKey, data.refreshToken);
        localStorage.setItem(this.config.tokenExpiryKey, data.expiry);

        this.decodeAndSetUser();
    },

    // Decode JWT token and set user data
    decodeAndSetUser() {
        try {
            const tokenData = JSON.parse(atob(this.state.token.split('.')[1]));
            this.state.user = {
                id: tokenData.sub,
                email: tokenData.email,
                name: tokenData.name,
                role: tokenData.role
            };
            this.state.currentRole = tokenData.role;
        } catch (error) {
            console.error('Token decode error:', error);
            this.logout();
        }
    },

    // Check if user has permission
    hasPermission(permission) {
        if (!this.state.currentRole) return false;
        
        const rolePermissions = this.config.rolePermissions[this.state.currentRole];
        return rolePermissions && rolePermissions.includes(permission);
    },

    // Check if user has any of the given permissions
    hasAnyPermission(permissions) {
        return permissions.some(permission => this.hasPermission(permission));
    },

    // Check if user has all of the given permissions
    hasAllPermissions(permissions) {
        return permissions.every(permission => this.hasPermission(permission));
    },

    // Get user's role
    getRole() {
        return this.state.currentRole;
    },

    // Get user's permissions
    getPermissions() {
        if (!this.state.currentRole) return [];
        return this.config.rolePermissions[this.state.currentRole] || [];
    },

    // Get current user
    getCurrentUser() {
        return this.state.user;
    },

    // Check if user is authenticated
    isAuthenticated() {
        return this.state.isAuthenticated;
    },

    // Get authentication token
    getToken() {
        return this.state.token;
    }
};

// Initialize authentication when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    Auth.init();
});

// Export for use in other files
window.Auth = Auth; 