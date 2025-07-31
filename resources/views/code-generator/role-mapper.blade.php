<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Role & Usage Mapping - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .role-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 1.5rem;
        }

        .main-content {
            grid-column: 1;
        }

        .summary-sidebar {
            grid-column: 2;
        }

        .search-bar {
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 1rem;
            background: white;
        }

        .role-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .role-table th {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 500;
            color: #475569;
            border-bottom: 1px solid var(--border-color);
        }

        .role-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .role-table tr:last-child td {
            border-bottom: none;
        }

        .role-table tr:hover {
            background: #f8fafc;
        }

        .role-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 0.875rem;
            background: white;
        }

        .purpose-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 0.875rem;
            background: white;
        }

        .radio-group {
            display: flex;
            gap: 1rem;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-color);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-color);
        }

        .save-button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            background: var(--primary-color);
            color: white;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background 0.2s;
        }

        .save-button:hover {
            background: #1d4ed8;
        }

        .summary-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .summary-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        .summary-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.875rem;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-number {
            font-weight: 600;
            color: var(--primary-color);
        }

        .batch-actions {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .batch-actions-text {
            color: #475569;
            font-size: 0.875rem;
        }

        @media (max-width: 1024px) {
            .role-container {
                grid-template-columns: 1fr;
            }

            .summary-sidebar {
                grid-column: 1;
            }
        }

        @media (max-width: 768px) {
            .role-table {
                display: block;
                overflow-x: auto;
            }

            .radio-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .batch-actions {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        /* Lazy Loading Styles */
        .lazy-load {
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }

        .lazy-load.loaded {
            opacity: 1;
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 4px;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Virtual Scrolling */
        .virtual-scroll-container {
            height: 600px;
            overflow-y: auto;
            position: relative;
        }

        .virtual-scroll-content {
            position: absolute;
            width: 100%;
        }

        /* Performance Monitoring */
        .performance-metrics {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="phase-buttons">
                <button class="phase-button" data-phase="review">Review</button>
                <button class="phase-button active" data-phase="build">Build</button>
                <button class="phase-button" data-phase="publish">Publish</button>
            </div>
        </nav>

        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <!-- Dashboard -->
            <div class="category">
                <h3 class="category-title">Dashboard</h3>
                <ul class="nav-links">
                    <li><a href="dashboard.html" class="nav-link">Dashboard</a></li>
                    <li><a href="module-summary.html" class="nav-link">Module Summary</a></li>
                </ul>
            </div>

            <!-- Phase 1: Review -->
            <div class="category">
                <h3 class="category-title">Phase 1: Review</h3>
                <ul class="nav-links">
                    <li><a href="upload-files.html" class="nav-link">Upload Files</a></li>
                    <li><a href="prompt-review.html" class="nav-link">Prompt Review</a></li>
                    <li><a href="html-analysis.html" class="nav-link">HTML Analysis</a></li>
                    <li><a href="prompt-suggestion.html" class="nav-link">Prompt Suggestion</a></li>
                    <li><a href="report-view.html" class="nav-link">Report View</a></li>
                    <li><a href="html-vs-prompt-score.html" class="nav-link">HTML vs Prompt Score</a></li>
                </ul>
            </div>

            <!-- Phase 2: Build -->
            <div class="category">
                <h3 class="category-title">Phase 2: Build</h3>
                <ul class="nav-links">
                    <li><a href="component-mapping.html" class="nav-link">Component Mapping</a></li>
                    <li><a href="blade-preview.html" class="nav-link">Blade Preview</a></li>
                    <li><a href="bug-fixer.html" class="nav-link">Bug Fixer</a></li>
                    <li><a href="role-mapper.html" class="nav-link active">Role Mapper</a></li>
                    <li><a href="notification-mapper.html" class="nav-link">Notification Mapper</a></li>
                </ul>
            </div>

            <!-- Phase 3: Publish -->
            <div class="category">
                <h3 class="category-title">Phase 3: Publish</h3>
                <ul class="nav-links">
                    <li><a href="final-checklist.html" class="nav-link">Final Checklist</a></li>
                    <li><a href="publish-confirmation.html" class="nav-link">Publish Confirmation</a></li>
                    <li><a href="publish-status.html" class="nav-link">Publish Status</a></li>
                    <li><a href="publish-report.html" class="nav-link">Publish Report</a></li>
                </ul>
            </div>

            <!-- Shared -->
            <div class="category">
                <h3 class="category-title">Shared</h3>
                <ul class="nav-links">
                    <li><a href="file-viewer.html" class="nav-link">File Viewer</a></li>
                    <li><a href="code-diff.html" class="nav-link">Code Diff</a></li>
                    <li><a href="progress-tracker.html" class="nav-link">Progress Tracker</a></li>
                    <li><a href="ai-suggestion-popup.html" class="nav-link">AI Suggestion Popup</a></li>
                    <li><a href="audit-logs.html" class="nav-link">Audit Logs</a></li>
                </ul>
            </div>

            <!-- Optional -->
            <div class="category">
                <h3 class="category-title">Optional</h3>
                <ul class="nav-links">
                    <li><a href="user-activity-log.html" class="nav-link">User Activity Log</a></li>
                    <li><a href="multi-user-collaboration.html" class="nav-link">Multi-user Collaboration</a></li>
                    <li><a href="notification-center.html" class="nav-link">Notification Center</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1 class="page-title">Page Role & Usage Mapping</h1>
            
            <div class="role-container">
                <div class="main-content">
                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Search pages...">
                    </div>

                    <!-- Performance Metrics -->
                    <div class="performance-metrics" id="performanceMetrics"></div>

                    <!-- Role Mapping Table -->
                    <div class="role-mapping-container">
                        <div class="virtual-scroll-container" id="virtualScroll">
                            <div class="virtual-scroll-content">
                                <table class="role-table">
                                    <thead>
                                        <tr>
                                            <th>Page Name</th>
                                            <th>Assigned Role</th>
                                            <th>Page Purpose</th>
                                            <th>Used By</th>
                                            <th>Visibility</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="roleTableBody">
                                        <!-- Table rows will be dynamically loaded -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="batch-actions">
                        <span class="batch-actions-text">3 pages selected for batch assignment</span>
                        <button class="save-button">Apply to Selected</button>
                    </div>
                </div>

                <div class="summary-sidebar">
                    <div class="summary-card">
                        <h3 class="summary-title">Mapping Summary</h3>
                        <ul class="summary-list">
                            <li class="summary-item">
                                <span>Pages Mapped</span>
                                <span class="summary-number">12</span>
                            </li>
                            <li class="summary-item">
                                <span>Pages Pending</span>
                                <span class="summary-number">8</span>
                            </li>
                            <li class="summary-item">
                                <span>Multi-role Pages</span>
                                <span class="summary-number">3</span>
                            </li>
                            <li class="summary-item">
                                <span>Admin Pages</span>
                                <span class="summary-number">5</span>
                            </li>
                            <li class="summary-item">
                                <span>User Pages</span>
                                <span class="summary-number">7</span>
                            </li>
                            <li class="summary-item">
                                <span>Business Pages</span>
                                <span class="summary-number">4</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Set active phase button and nav link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const phaseMap = {
                'upload-files.html': 'review',
                'prompt-review.html': 'review',
                'html-analysis.html': 'review',
                'prompt-suggestion.html': 'review',
                'report-view.html': 'review',
                'html-vs-prompt-score.html': 'review',
                'component-mapping.html': 'build',
                'blade-preview.html': 'build',
                'bug-fixer.html': 'build',
                'role-mapper.html': 'build',
                'notification-mapper.html': 'build',
                'final-checklist.html': 'publish',
                'publish-confirmation.html': 'publish',
                'publish-status.html': 'publish',
                'publish-report.html': 'publish'
            };

            const currentPhase = phaseMap[currentPage];
            if (currentPhase) {
                const phaseButton = document.querySelector(`[data-phase="${currentPhase}"]`);
                if (phaseButton) {
                    phaseButton.classList.add('active');
                }
            }

            // Set active nav link
            const currentNavLink = document.querySelector(`.nav-link[href="${currentPage}"]`);
            if (currentNavLink) {
                currentNavLink.classList.add('active');
            }

            // Save button functionality
            document.querySelectorAll('.save-button').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    // Add your save logic here
                    this.textContent = 'Saved!';
                    setTimeout(() => {
                        this.textContent = 'Save Mapping';
                    }, 2000);
                });
            });

            // Search functionality
            const searchInput = document.querySelector('.search-input');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.role-table tbody tr');
                
                rows.forEach(row => {
                    const pageName = row.querySelector('td:first-child').textContent.toLowerCase();
                    row.style.display = pageName.includes(searchTerm) ? '' : 'none';
                });
            });
        });

        // Performance Monitoring
        const performanceMetrics = {
            startTime: performance.now(),
            measurements: {},
            mark(name) {
                this.measurements[name] = performance.now() - this.startTime;
                this.updateDisplay();
            },
            updateDisplay() {
                const metrics = document.getElementById('performanceMetrics');
                metrics.innerHTML = Object.entries(this.measurements)
                    .map(([name, time]) => `${name}: ${time.toFixed(2)}ms`)
                    .join('<br>');
            }
        };

        // Lazy Loading
        const lazyLoadObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    element.classList.add('loaded');
                    lazyLoadObserver.unobserve(element);
                }
            });
        });

        document.querySelectorAll('.lazy-load').forEach(element => {
            lazyLoadObserver.observe(element);
        });

        // Virtual Scrolling
        class VirtualScroller {
            constructor(container, itemHeight, totalItems, renderItem) {
                this.container = container;
                this.itemHeight = itemHeight;
                this.totalItems = totalItems;
                this.renderItem = renderItem;
                this.visibleItems = Math.ceil(container.clientHeight / itemHeight);
                this.startIndex = 0;
                this.endIndex = this.visibleItems;

                this.setupScroll();
                this.render();
            }

            setupScroll() {
                this.container.addEventListener('scroll', () => {
                    this.startIndex = Math.floor(this.container.scrollTop / this.itemHeight);
                    this.endIndex = Math.min(
                        this.startIndex + this.visibleItems,
                        this.totalItems
                    );
                    this.render();
                });
            }

            render() {
                const content = document.getElementById('roleTableBody');
                content.style.height = `${this.totalItems * this.itemHeight}px`;
                content.style.transform = `translateY(${this.startIndex * this.itemHeight}px)`;

                const fragment = document.createDocumentFragment();
                for (let i = this.startIndex; i < this.endIndex; i++) {
                    const item = this.renderItem(i);
                    fragment.appendChild(item);
                }
                content.innerHTML = '';
                content.appendChild(fragment);
            }
        }

        // Cache Management
        const cache = {
            data: new Map(),
            maxAge: 5 * 60 * 1000, // 5 minutes

            set(key, value) {
                this.data.set(key, {
                    value,
                    timestamp: Date.now()
                });
            },

            get(key) {
                const item = this.data.get(key);
                if (!item) return null;

                if (Date.now() - item.timestamp > this.maxAge) {
                    this.data.delete(key);
                    return null;
                }

                return item.value;
            },

            clear() {
                this.data.clear();
            }
        };

        // Debounce Function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Throttle Function
        function throttle(func, limit) {
            let inThrottle;
            return function executedFunction(...args) {
                if (!inThrottle) {
                    func(...args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        }

        // Initialize Virtual Scroller
        const roleData = Array.from({ length: 1000 }, (_, i) => ({
            pageName: `Page ${i + 1}`,
            role: 'User',
            purpose: 'View',
            usedBy: 'All',
            visibility: true
        }));

        const virtualScroller = new VirtualScroller(
            document.getElementById('virtualScroll'),
            50, // item height
            roleData.length,
            (index) => {
                const item = roleData[index];
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.pageName}</td>
                    <td>
                        <select class="form-control">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control">
                            <option value="view">View</option>
                            <option value="edit">Edit</option>
                            <option value="delete">Delete</option>
                        </select>
                    </td>
                    <td>
                        <div class="radio-group">
                            <label>
                                <input type="radio" name="usedBy_${index}" value="all" checked>
                                All
                            </label>
                            <label>
                                <input type="radio" name="usedBy_${index}" value="specific">
                                Specific
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="checkbox" checked>
                    </td>
                    <td>
                        <button class="action-button" onclick="saveRoleMapping(${index})">
                            Save Role Mapping
                        </button>
                    </td>
                `;
                return tr;
            }
        );

        // Performance Monitoring
        performanceMetrics.mark('Initial Load');

        // Handle Role Mapping Save
        const saveRoleMapping = debounce(async (index) => {
            const row = document.querySelector(`tr[data-index="${index}"]`);
            const data = {
                pageName: row.querySelector('td:first-child').textContent,
                role: row.querySelector('select').value,
                purpose: row.querySelectorAll('select')[1].value,
                usedBy: row.querySelector('input[type="radio"]:checked').value,
                visibility: row.querySelector('input[type="checkbox"]').checked
            };

            try {
                // Check cache first
                const cached = cache.get(`role_${index}`);
                if (cached && JSON.stringify(cached) === JSON.stringify(data)) {
                    showToast('No changes to save');
                    return;
                }

                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // Update cache
                cache.set(`role_${index}`, data);
                
                showToast('Role mapping saved successfully');
            } catch (error) {
                showToast('Failed to save role mapping', 'error');
            }
        }, 300);

        // Handle Search
        const handleSearch = debounce((query) => {
            const filteredData = roleData.filter(item =>
                item.pageName.toLowerCase().includes(query.toLowerCase())
            );
            virtualScroller.updateData(filteredData);
        }, 300);

        // Handle Filter
        const handleFilter = throttle((filter) => {
            const filteredData = roleData.filter(item =>
                item.role === filter
            );
            virtualScroller.updateData(filteredData);
        }, 500);

        // Export Data
        const exportData = async (format) => {
            try {
                const data = Array.from(cache.data.values())
                    .map(item => item.value);

                if (format === 'csv') {
                    const csv = convertToCSV(data);
                    downloadFile(csv, 'role-mapping.csv', 'text/csv');
                } else if (format === 'pdf') {
                    const pdf = await generatePDF(data);
                    downloadFile(pdf, 'role-mapping.pdf', 'application/pdf');
                }
            } catch (error) {
                showToast('Failed to export data', 'error');
            }
        };

        // Utility Functions
        function convertToCSV(data) {
            const headers = ['Page Name', 'Role', 'Purpose', 'Used By', 'Visibility'];
            const rows = data.map(item => [
                item.pageName,
                item.role,
                item.purpose,
                item.usedBy,
                item.visibility
            ]);
            return [headers, ...rows].map(row => row.join(',')).join('\n');
        }

        function downloadFile(content, filename, type) {
            const blob = new Blob([content], { type });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.click();
            URL.revokeObjectURL(url);
        }

        // Cleanup on page unload
        window.addEventListener('unload', () => {
            cache.clear();
            lazyLoadObserver.disconnect();
        });
    </script>
</body>
</html> 