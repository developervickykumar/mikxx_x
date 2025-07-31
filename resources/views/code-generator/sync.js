// Offline/Online Synchronization System
const Sync = {
    // Configuration
    config: {
        syncInterval: 5 * 60 * 1000, // 5 minutes
        maxRetries: 3,
        retryDelay: 1000, // 1 second
        queueKey: 'sync_queue',
        lastSyncKey: 'last_sync',
        conflictResolution: 'server-wins', // or 'client-wins', 'manual'
        syncEndpoints: {
            analytics: '/api/sync/analytics',
            userData: '/api/sync/user-data',
            settings: '/api/sync/settings'
        }
    },

    // State
    state: {
        isOnline: navigator.onLine,
        isSyncing: false,
        syncQueue: [],
        lastSync: null,
        retryCount: 0,
        pendingChanges: new Map()
    },

    // Initialize sync system
    init() {
        this.loadSyncQueue();
        this.loadLastSync();
        this.setupSyncListeners();
        this.startSyncInterval();
    },

    // Load sync queue from storage
    loadSyncQueue() {
        const queue = localStorage.getItem(this.config.queueKey);
        this.state.syncQueue = queue ? JSON.parse(queue) : [];
    },

    // Load last sync timestamp
    loadLastSync() {
        const lastSync = localStorage.getItem(this.config.lastSyncKey);
        this.state.lastSync = lastSync ? new Date(lastSync) : null;
    },

    // Setup sync event listeners
    setupSyncListeners() {
        // Online/offline status
        window.addEventListener('online', () => {
            this.state.isOnline = true;
            this.sync();
        });

        window.addEventListener('offline', () => {
            this.state.isOnline = false;
        });

        // Storage changes (for multi-tab support)
        window.addEventListener('storage', (e) => {
            if (e.key === this.config.queueKey) {
                this.loadSyncQueue();
            }
        });
    },

    // Start periodic sync
    startSyncInterval() {
        setInterval(() => {
            if (this.state.isOnline && !this.state.isSyncing) {
                this.sync();
            }
        }, this.config.syncInterval);
    },

    // Add item to sync queue
    addToQueue(item) {
        this.state.syncQueue.push({
            ...item,
            timestamp: new Date().toISOString(),
            retryCount: 0
        });
        this.saveSyncQueue();
    },

    // Save sync queue to storage
    saveSyncQueue() {
        localStorage.setItem(this.config.queueKey, JSON.stringify(this.state.syncQueue));
    },

    // Update last sync timestamp
    updateLastSync() {
        this.state.lastSync = new Date();
        localStorage.setItem(this.config.lastSyncKey, this.state.lastSync.toISOString());
    },

    // Main sync function
    async sync() {
        if (this.state.isSyncing || !this.state.isOnline) return;

        this.state.isSyncing = true;
        this.state.retryCount = 0;

        try {
            await this.processSyncQueue();
            this.updateLastSync();
        } catch (error) {
            console.error('Sync error:', error);
        } finally {
            this.state.isSyncing = false;
        }
    },

    // Process sync queue
    async processSyncQueue() {
        while (this.state.syncQueue.length > 0) {
            const item = this.state.syncQueue[0];
            
            try {
                await this.syncItem(item);
                this.state.syncQueue.shift(); // Remove processed item
                this.saveSyncQueue();
            } catch (error) {
                if (item.retryCount < this.config.maxRetries) {
                    item.retryCount++;
                    await this.delay(this.config.retryDelay * item.retryCount);
                } else {
                    // Move failed item to end of queue
                    this.state.syncQueue.push(this.state.syncQueue.shift());
                    break;
                }
            }
        }
    },

    // Sync individual item
    async syncItem(item) {
        const endpoint = this.config.syncEndpoints[item.type];
        if (!endpoint) throw new Error(`Unknown sync type: ${item.type}`);

        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${Auth.getToken()}`
            },
            body: JSON.stringify(item.data)
        });

        if (!response.ok) {
            throw new Error(`Sync failed: ${response.statusText}`);
        }

        return response.json();
    },

    // Handle data conflicts
    async resolveConflict(localData, serverData) {
        switch (this.config.conflictResolution) {
            case 'server-wins':
                return serverData;
            case 'client-wins':
                return localData;
            case 'manual':
                return this.manualConflictResolution(localData, serverData);
            default:
                return serverData;
        }
    },

    // Manual conflict resolution
    async manualConflictResolution(localData, serverData) {
        return new Promise((resolve) => {
            const event = new CustomEvent('sync:conflict', {
                detail: {
                    localData,
                    serverData,
                    resolve: (data) => resolve(data)
                }
            });
            window.dispatchEvent(event);
        });
    },

    // Track pending changes
    trackChange(type, data) {
        const changes = this.state.pendingChanges.get(type) || [];
        changes.push({
            data,
            timestamp: new Date().toISOString()
        });
        this.state.pendingChanges.set(type, changes);
    },

    // Get pending changes
    getPendingChanges(type) {
        return this.state.pendingChanges.get(type) || [];
    },

    // Clear pending changes
    clearPendingChanges(type) {
        if (type) {
            this.state.pendingChanges.delete(type);
        } else {
            this.state.pendingChanges.clear();
        }
    },

    // Delay function
    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    },

    // Force sync
    forceSync() {
        if (this.state.isOnline) {
            this.sync();
        }
    },

    // Get sync status
    getStatus() {
        return {
            isOnline: this.state.isOnline,
            isSyncing: this.state.isSyncing,
            queueLength: this.state.syncQueue.length,
            lastSync: this.state.lastSync,
            pendingChanges: Object.fromEntries(this.state.pendingChanges)
        };
    }
};

// Initialize sync system when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    Sync.init();
});

// Export for use in other files
window.Sync = Sync; 