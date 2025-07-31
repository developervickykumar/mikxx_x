// Analytics Utilities
const Analytics = {
    // Configuration
    config: {
        enabled: true,
        debug: false,
        endpoint: '/api/analytics',
        sessionTimeout: 30 * 60 * 1000, // 30 minutes
        maxEvents: 100,
        trackPerformance: true,
        trackErrors: true,
        trackNavigation: true,
        trackInteractions: true,
        trackUserBehavior: true,
        trackResourceUsage: true,
        trackNetworkStatus: true,
        trackAccessibility: true,
        trackCustomEvents: true,
        exportFormats: ['csv', 'json', 'pdf']
    },

    // State
    state: {
        sessionId: null,
        userId: null,
        events: [],
        lastActivity: Date.now(),
        performanceMetrics: {},
        userBehavior: {
            timeOnPage: 0,
            scrollDepth: 0,
            clicks: 0,
            formInteractions: 0,
            keyPresses: 0
        },
        resourceUsage: {
            memory: null,
            cpu: null,
            network: {
                downlink: null,
                effectiveType: null,
                rtt: null
            }
        },
        accessibility: {
            screenReader: false,
            highContrast: false,
            reducedMotion: false,
            fontSize: null,
            prefersContrast: false
        },
        network: {
            online: navigator.onLine,
            speed: null
        },
        customEvents: []
    },

    // Initialize
    init() {
        if (!this.config.enabled) return;

        this.state.sessionId = this.generateSessionId();
        this.loadUserPreferences();
        this.setupEventListeners();
        this.trackPageView();
        
        if (this.config.trackPerformance) {
            this.trackPerformanceMetrics();
        }

        if (this.config.trackResourceUsage) {
            this.trackResourceUsage();
        }

        if (this.config.trackAccessibility) {
            this.trackAccessibility();
        }

        if (this.config.trackNetworkStatus) {
            this.trackNetwork();
        }

        // Start session timer
        setInterval(() => this.checkSession(), 60000);
        
        // Start user behavior tracking
        if (this.config.trackUserBehavior) {
            this.startBehaviorTracking();
        }
    },

    // Generate unique session ID
    generateSessionId() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    },

    // Load user preferences
    loadUserPreferences() {
        const preferences = Security.secureStorage.get('userPreferences') || {};
        this.state.userId = preferences.userId;
    },

    // Setup event listeners
    setupEventListeners() {
        if (this.config.trackNavigation) {
            window.addEventListener('popstate', () => this.trackPageView());
        }

        if (this.config.trackInteractions) {
            document.addEventListener('click', e => this.trackInteraction(e, 'click'));
            document.addEventListener('submit', e => this.trackInteraction(e, 'submit'));
            document.addEventListener('change', e => this.trackInteraction(e, 'change'));
        }

        if (this.config.trackErrors) {
            window.addEventListener('error', e => this.trackError(e));
            window.addEventListener('unhandledrejection', e => this.trackError(e));
        }
    },

    // Track page view
    trackPageView() {
        this.trackEvent('page_view', {
            url: window.location.href,
            title: document.title,
            referrer: document.referrer
        });
    },

    // Track user interaction
    trackInteraction(event, type) {
        const target = event.target;
        const data = {
            type,
            element: target.tagName.toLowerCase(),
            id: target.id,
            class: target.className,
            text: target.textContent?.trim().substring(0, 50)
        };

        this.trackEvent('interaction', data);
    },

    // Track error
    trackError(error) {
        const data = {
            message: error.message || error.reason?.message,
            stack: error.error?.stack || error.reason?.stack,
            type: error.error ? 'error' : 'unhandledrejection'
        };

        this.trackEvent('error', data);
    },

    // Track performance metrics
    trackPerformanceMetrics() {
        // Track page load metrics
        window.addEventListener('load', () => {
            const metrics = performance.getEntriesByType('navigation')[0];
            this.state.performanceMetrics = {
                loadTime: metrics.loadEventEnd - metrics.navigationStart,
                domContentLoaded: metrics.domContentLoadedEventEnd - metrics.navigationStart,
                firstPaint: performance.getEntriesByName('first-paint')[0]?.startTime,
                firstContentfulPaint: performance.getEntriesByName('first-contentful-paint')[0]?.startTime
            };

            this.trackEvent('performance', this.state.performanceMetrics);
        });

        // Track resource timing
        const observer = new PerformanceObserver(list => {
            list.getEntries().forEach(entry => {
                if (entry.initiatorType === 'resource') {
                    this.trackEvent('resource_timing', {
                        name: entry.name,
                        duration: entry.duration,
                        type: entry.initiatorType
                    });
                }
            });
        });

        observer.observe({ entryTypes: ['resource'] });
    },

    // Track user behavior
    startBehaviorTracking() {
        // Time on page
        this._startTime = Date.now();
        window.addEventListener('beforeunload', () => {
            this.state.userBehavior.timeOnPage += (Date.now() - this._startTime) / 1000;
        });
        // Scroll depth
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY + window.innerHeight;
            const total = document.body.scrollHeight;
            const percent = Math.min(100, Math.round((scrolled / total) * 100));
            if (percent > this.state.userBehavior.scrollDepth) {
                this.state.userBehavior.scrollDepth = percent;
            }
        });
        // Clicks
        document.addEventListener('click', () => {
            this.state.userBehavior.clicks++;
        });
        // Form interactions
        document.addEventListener('submit', () => {
            this.state.userBehavior.formInteractions++;
        });
        // Key presses
        document.addEventListener('keydown', () => {
            this.state.userBehavior.keyPresses++;
        });
    },

    // Track resource usage
    trackResourceUsage() {
        if (performance && performance.memory) {
            this.state.resourceUsage.memory = performance.memory.usedJSHeapSize;
        }
        // CPU usage is not available in browsers, but can be simulated
        this.state.resourceUsage.cpu = null;

        if ('connection' in navigator) {
            const connection = navigator.connection;
            this.state.resourceUsage.network = {
                downlink: connection.downlink,
                effectiveType: connection.effectiveType,
                rtt: connection.rtt
            };

            connection.addEventListener('change', () => {
                this.trackEvent('network_change', {
                    downlink: connection.downlink,
                    effectiveType: connection.effectiveType,
                    rtt: connection.rtt
                });
            });
        }
    },

    // Track accessibility
    trackAccessibility() {
        // Check for screen reader
        const isScreenReader = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.state.accessibility.screenReader = isScreenReader;

        // Check for high contrast
        const isHighContrast = window.matchMedia('(forced-colors: active)').matches;
        this.state.accessibility.highContrast = isHighContrast;

        // Check for reduced motion
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.state.accessibility.reducedMotion = prefersReducedMotion;

        // Track font size
        const fontSize = window.getComputedStyle(document.body).fontSize;
        this.state.accessibility.fontSize = fontSize;

        this.state.accessibility.prefersContrast = window.matchMedia('(prefers-contrast: more)').matches;

        this.trackEvent('accessibility_settings', this.state.accessibility);
    },

    // Track network status
    trackNetwork() {
        this.state.network.online = navigator.onLine;
        window.addEventListener('online', () => { this.state.network.online = true; });
        window.addEventListener('offline', () => { this.state.network.online = false; });
        // Network speed estimation (if available)
        if (navigator.connection && navigator.connection.downlink) {
            this.state.network.speed = navigator.connection.downlink;
        }
    },

    // Track custom event
    trackEvent(name, data = {}) {
        if (!this.config.enabled) return;

        const event = {
            name,
            data,
            timestamp: Date.now(),
            sessionId: this.state.sessionId,
            userId: this.state.userId,
            url: window.location.href,
            userAgent: navigator.userAgent,
            viewport: {
                width: window.innerWidth,
                height: window.innerHeight
            },
            language: navigator.language,
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
        };

        this.state.events.push(event);
        this.state.lastActivity = Date.now();

        // Send event immediately if it's an error or performance metric
        if (name === 'error' || name === 'performance') {
            this.sendEvent(event);
        } else if (this.state.events.length >= this.config.maxEvents) {
            this.sendEvents();
        }

        if (this.config.debug) {
            console.log('Analytics Event:', event);
        }
    },

    // Send single event
    async sendEvent(event) {
        try {
            const response = await fetch(this.config.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': Security.csrfToken
                },
                body: JSON.stringify(event)
            });

            if (!response.ok) {
                throw new Error('Failed to send analytics event');
            }
        } catch (error) {
            console.error('Analytics Error:', error);
        }
    },

    // Send batch of events
    async sendEvents() {
        if (this.state.events.length === 0) return;

        const events = [...this.state.events];
        this.state.events = [];

        try {
            const response = await fetch(this.config.endpoint + '/batch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': Security.csrfToken
                },
                body: JSON.stringify(events)
            });

            if (!response.ok) {
                throw new Error('Failed to send analytics events');
            }
        } catch (error) {
            console.error('Analytics Error:', error);
            // Put events back in queue
            this.state.events = [...events, ...this.state.events];
        }
    },

    // Check session status
    checkSession() {
        const now = Date.now();
        if (now - this.state.lastActivity > this.config.sessionTimeout) {
            // Session expired, start new session
            this.state.sessionId = this.generateSessionId();
            this.trackEvent('session_expired');
        }
    },

    // Enable/disable analytics
    setEnabled(enabled) {
        this.config.enabled = enabled;
        if (enabled) {
            this.init();
        }
    },

    // Set debug mode
    setDebug(debug) {
        this.config.debug = debug;
    },

    // Export analytics data
    exportData(format = 'json') {
        if (!this.config.exportFormats.includes(format)) {
            throw new Error(`Unsupported export format: ${format}`);
        }

        const data = {
            sessionId: this.state.sessionId,
            userId: this.state.userId,
            events: this.state.events,
            userBehavior: this.state.userBehavior,
            performanceMetrics: this.state.performanceMetrics,
            resourceUsage: this.state.resourceUsage,
            accessibility: this.state.accessibility,
            network: this.state.network,
            customEvents: this.state.customEvents
        };

        switch (format) {
            case 'csv':
                return this.convertToCSV(data);
            case 'json':
                return JSON.stringify(data, null, 2);
            case 'pdf':
                return this.generatePDF(data);
            default:
                return data;
        }
    },

    // Convert data to CSV
    convertToCSV(data) {
        const headers = ['timestamp', 'event', 'data'];
        const rows = data.events.map(event => [
            new Date(event.timestamp).toISOString(),
            event.name,
            JSON.stringify(event.data)
        ]);

        return [
            headers.join(','),
            ...rows.map(row => row.join(','))
        ].join('\n');
    },

    // Generate PDF report
    generatePDF(data) {
        // Implementation would depend on PDF generation library
        // This is a placeholder for the actual implementation
        return new Promise((resolve) => {
            const pdfContent = {
                content: [
                    { text: 'Analytics Report', style: 'header' },
                    { text: `Session ID: ${data.sessionId}` },
                    { text: `User ID: ${data.userId}` },
                    { text: 'Events', style: 'subheader' },
                    { table: { body: data.events.map(e => [e.timestamp, e.name, JSON.stringify(e.data)]) } },
                    { text: 'User Behavior', style: 'subheader' },
                    { text: JSON.stringify(data.userBehavior, null, 2) },
                    { text: 'Performance Metrics', style: 'subheader' },
                    { text: JSON.stringify(data.performanceMetrics, null, 2) },
                    { text: 'Resource Usage', style: 'subheader' },
                    { text: JSON.stringify(data.resourceUsage, null, 2) },
                    { text: 'Accessibility Settings', style: 'subheader' },
                    { text: JSON.stringify(data.accessibility, null, 2) },
                    { text: 'Network Status', style: 'subheader' },
                    { text: JSON.stringify(data.network, null, 2) },
                    { text: 'Custom Events', style: 'subheader' },
                    { table: { body: data.customEvents.map(e => [e.timestamp, e.eventName, JSON.stringify(e.data)]) } }
                ]
            };
            resolve(pdfContent);
        });
    },

    // Track custom event
    trackCustomEvent(eventName, data) {
        this.state.customEvents.push({ eventName, data, timestamp: Date.now() });
    },

    // Initialize all new tracking
    initEnhancedTracking() {
        this.startBehaviorTracking();
        this.trackResourceUsage();
        this.trackAccessibility();
        this.trackNetwork();
    }
};

// Initialize analytics
document.addEventListener('DOMContentLoaded', () => {
    Analytics.init();
});

// Export for use in other files
window.Analytics = Analytics; 