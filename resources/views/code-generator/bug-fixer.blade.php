<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Tracker & Fixer - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --text-color: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --background-color: #ffffff;
            --card-background: #f8fafc;
            --hover-color: #f1f5f9;
            --success-color: #059669;
            --warning-color: #d97706;
            --error-color: #dc2626;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --transition: all 0.2s ease-in-out;
        }

        .bug-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Summary Panel Improvements */
        .summary-panel {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .summary-card {
            background: var(--card-background);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-color);
        }

        .summary-card.critical::before {
            background: var(--error-color);
        }

        .summary-card.fixed::before {
            background: var(--success-color);
        }

        .summary-card.pending::before {
            background: var(--warning-color);
        }

        .summary-number {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .summary-icon {
            font-size: 1.5rem;
        }

        .summary-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .summary-trend {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
        }

        .trend-up {
            color: var(--success-color);
        }

        .trend-down {
            color: var(--error-color);
        }

        /* Filter Bar Improvements */
        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background: var(--card-background);
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .filter-tab {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: var(--background-color);
            cursor: pointer;
            font-size: 0.875rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-tab:hover {
            background: var(--hover-color);
        }

        .filter-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .filter-tab .count {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.125rem 0.375rem;
            border-radius: 1rem;
            font-size: 0.75rem;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        /* Bug Table Improvements */
        .bug-table-container {
            background: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .bug-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--background-color);
        }

        .bug-table th {
            background: var(--card-background);
            padding: 1rem;
            text-align: left;
            font-weight: 500;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .bug-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
            vertical-align: top;
        }

        .bug-table tr:last-child td {
            border-bottom: none;
        }

        .bug-table tr:hover {
            background: var(--hover-color);
        }

        .bug-table tr.selected {
            background: rgba(37, 99, 235, 0.05);
        }

        /* Form Controls Improvements */
        .form-group {
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control.error {
            border-color: var(--error-color);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: none;
        }

        .has-error .error-message {
            display: block;
        }

        /* Badge Improvements */
        .severity-badge, .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .severity-high {
            background: #fee2e2;
            color: var(--error-color);
        }

        .severity-medium {
            background: #fef3c7;
            color: var(--warning-color);
        }

        .severity-low {
            background: #dcfce7;
            color: var(--success-color);
        }

        .status-pending {
            background: #fef3c7;
            color: var(--warning-color);
        }

        .status-fixed {
            background: #dcfce7;
            color: var(--success-color);
        }

        /* Button Improvements */
        .action-button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            background: var(--primary-color);
            color: white;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .action-button:disabled {
            background: var(--border-color);
            cursor: not-allowed;
            transform: none;
        }

        .fix-button {
            padding: 0.375rem 0.75rem;
            border: none;
            border-radius: 0.25rem;
            background: var(--primary-color);
            color: white;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .fix-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .fix-button:disabled {
            background: var(--border-color);
            cursor: not-allowed;
            transform: none;
        }

        /* Bulk Actions Improvements */
        .bulk-actions {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--card-background);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
        }

        .bulk-actions:hover {
            box-shadow: var(--shadow-sm);
        }

        .bulk-actions-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Loading States */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 24px;
            height: 24px;
            border: 2px solid var(--primary-color);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 2;
        }

        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .toast {
            background: white;
            border-radius: 0.375rem;
            padding: 1rem;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
            min-width: 300px;
        }

        .toast.success {
            border-left: 4px solid var(--success-color);
        }

        .toast.error {
            border-left: 4px solid var(--error-color);
        }

        .toast.warning {
            border-left: 4px solid var(--warning-color);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive Improvements */
        @media (max-width: 1024px) {
            .summary-panel {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .filter-bar {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-tabs {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }

            .search-box {
                width: 100%;
            }

            .bug-table-container {
                overflow-x: auto;
            }

            .bug-table {
                min-width: 800px;
            }

            .bulk-actions {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
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
                    <li><a href="bug-fixer.html" class="nav-link active">Bug Fixer</a></li>
                    <li><a href="role-mapper.html" class="nav-link">Role Mapper</a></li>
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
            <h1 class="page-title">Bug Tracker & Fixer</h1>
            
            <div class="bug-container">
                <!-- Summary Panel -->
                <div class="summary-panel">
                    <div class="summary-card">
                        <div class="summary-number">
                            <span class="summary-icon">🐛</span>
                            24
                        </div>
                        <div class="summary-label">Total Bugs</div>
                        <div class="summary-trend trend-down">
                            <span>↓</span> 12% from last week
                        </div>
                    </div>
                    <div class="summary-card critical">
                        <div class="summary-number">
                            <span class="summary-icon">⚠️</span>
                            5
                        </div>
                        <div class="summary-label">Critical Bugs</div>
                        <div class="summary-trend trend-up">
                            <span>↑</span> 2 new today
                        </div>
                    </div>
                    <div class="summary-card fixed">
                        <div class="summary-number">
                            <span class="summary-icon">✅</span>
                            12
                        </div>
                        <div class="summary-label">Fixed Bugs</div>
                        <div class="summary-trend trend-up">
                            <span>↑</span> 5 this week
                        </div>
                    </div>
                    <div class="summary-card pending">
                        <div class="summary-number">
                            <span class="summary-icon">⏳</span>
                            12
                        </div>
                        <div class="summary-label">Pending Fixes</div>
                        <div class="summary-trend trend-down">
                            <span>↓</span> 3 resolved today
                        </div>
                    </div>
                </div>

                <!-- Filter Bar -->
                <div class="filter-bar">
                    <div class="filter-tabs">
                        <button class="filter-tab active">
                            All
                            <span class="count">24</span>
                        </button>
                        <button class="filter-tab">
                            Pending
                            <span class="count">12</span>
                        </button>
                        <button class="filter-tab">
                            Fixed
                            <span class="count">12</span>
                        </button>
                        <button class="filter-tab">
                            Critical
                            <span class="count">5</span>
                        </button>
                    </div>
                    <div class="search-box">
                        <span class="search-icon">🔍</span>
                        <input type="text" class="search-input" placeholder="Search bugs...">
                    </div>
                    <button class="action-button">
                        <span>🔄</span>
                        Re-scan for Bugs
                    </button>
                </div>

                <!-- Toast Container -->
                <div class="toast-container" id="toastContainer"></div>

                <!-- Bug Table -->
                <div class="bug-table-container">
                    <table class="bug-table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                                </th>
                                <th>File Name</th>
                                <th>Bug Type</th>
                                <th>Severity</th>
                                <th>Suggested Fix</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bug-row" data-bug-id="1">
                                <td>
                                    <input type="checkbox" class="bug-select" onchange="updateBulkActions()">
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="index.html" required
                                            data-validate="required" data-error-message="File name is required">
                                        <div class="error-message"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" required data-validate="required">
                                            <option value="">Select Type</option>
                                            <option value="syntax">Syntax Error</option>
                                            <option value="logic">Logic Error</option>
                                            <option value="performance">Performance Issue</option>
                                        </select>
                                        <div class="error-message"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control severity-select" required data-validate="required">
                                            <option value="">Select Severity</option>
                                            <option value="high">High</option>
                                            <option value="medium">Medium</option>
                                            <option value="low">Low</option>
                                        </select>
                                        <div class="error-message"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="2" required data-validate="required"
                                            data-error-message="Suggested fix is required"></textarea>
                                        <div class="error-message"></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-pending">Pending</span>
                                </td>
                                <td>
                                    <button class="fix-button" onclick="handleFix(this)">
                                        <span>🔧</span>
                                        Mark as Fixed
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>home.blade.php</td>
                                <td>Missing Tag</td>
                                <td><span class="severity-badge severity-high">High</span></td>
                                <td>Add missing closing &lt;/div&gt; tag</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><button class="fix-button">Mark as Fixed</button></td>
                            </tr>
                            <tr>
                                <td>about.blade.php</td>
                                <td>JS Error</td>
                                <td><span class="severity-badge severity-medium">Medium</span></td>
                                <td>Fix undefined variable in script</td>
                                <td><span class="status-badge status-fixed">Fixed</span></td>
                                <td><button class="fix-button" disabled>Fixed</button></td>
                            </tr>
                            <tr>
                                <td>contact.blade.php</td>
                                <td>Misaligned Layout</td>
                                <td><span class="severity-badge severity-low">Low</span></td>
                                <td>Adjust padding in mobile view</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><button class="fix-button">Mark as Fixed</button></td>
                            </tr>
                            <tr>
                                <td>dashboard.blade.php</td>
                                <td>Invalid Blade Syntax</td>
                                <td><span class="severity-badge severity-high">High</span></td>
                                <td>Fix @foreach loop syntax</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><button class="fix-button">Mark as Fixed</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Bulk Actions -->
                <div class="bulk-actions">
                    <span class="bulk-actions-text">
                        <span>📋</span>
                        <span id="selectedCount">0</span> bugs selected for bulk action
                    </span>
                    <button class="action-button" onclick="applyBulkFixes()">
                        <span>🔧</span>
                        Apply All Fixes
                    </button>
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

            // Filter tabs functionality
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const filter = this.textContent.trim().toLowerCase();
                    
                    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const rows = document.querySelectorAll('.bug-row');
                    rows.forEach(row => {
                        const status = row.querySelector('.status-badge').textContent.toLowerCase();
                        const severity = row.querySelector('.severity-badge')?.textContent.toLowerCase();
                        
                        if (filter === 'all' || 
                            (filter === 'pending' && status === 'pending') ||
                            (filter === 'fixed' && status === 'fixed') ||
                            (filter === 'critical' && severity === 'high')) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });

            // Fix button functionality
            document.querySelectorAll('.fix-button:not(:disabled)').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const statusBadge = row.querySelector('.status-badge');
                    statusBadge.className = 'status-badge status-fixed';
                    statusBadge.textContent = 'Fixed';
                    this.disabled = true;
                    this.textContent = 'Fixed';
                });
            });
        });

        // Form Validation
        function validateForm(form) {
            let isValid = true;
            const inputs = form.querySelectorAll('[data-validate]');

            inputs.forEach(input => {
                const value = input.value.trim();
                const validationType = input.dataset.validate;
                const errorMessage = input.dataset.errorMessage || 'This field is required';
                const errorElement = input.parentElement.querySelector('.error-message');

                if (validationType === 'required' && !value) {
                    isValid = false;
                    input.parentElement.classList.add('has-error');
                    errorElement.textContent = errorMessage;
                } else {
                    input.parentElement.classList.remove('has-error');
                    errorElement.textContent = '';
                }
            });

            return isValid;
        }

        // Toast Notifications
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>${message}</span>
            `;

            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Loading State
        function setLoading(element, isLoading) {
            if (isLoading) {
                element.classList.add('loading');
            } else {
                element.classList.remove('loading');
            }
        }

        // Handle Fix Button Click
        async function handleFix(button) {
            const row = button.closest('.bug-row');
            
            if (!validateForm(row)) {
                showToast('Please fill in all required fields', 'error');
                return;
            }

            setLoading(row, true);

            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1000));

                const statusBadge = row.querySelector('.status-badge');
                statusBadge.textContent = 'Fixed';
                statusBadge.classList.remove('pending');
                statusBadge.classList.add('fixed');

                button.disabled = true;
                button.textContent = 'Fixed';

                showToast('Bug marked as fixed successfully');
            } catch (error) {
                showToast('Failed to update bug status', 'error');
            } finally {
                setLoading(row, false);
            }
        }

        // Toggle select all
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.bug-select');
            checkboxes.forEach(box => box.checked = checkbox.checked);
            updateBulkActions();
        }

        // Update bulk actions
        function updateBulkActions() {
            const selectedCount = document.querySelectorAll('.bug-select:checked').length;
            document.getElementById('selectedCount').textContent = selectedCount;
        }

        // Apply bulk fixes
        async function applyBulkFixes() {
            const selectedBugs = document.querySelectorAll('.bug-select:checked');
            if (selectedBugs.length === 0) {
                showToast('Please select bugs to fix', 'warning');
                return;
            }

            const container = document.querySelector('.bug-table-container');
            setLoading(container, true);

            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1500));

                selectedBugs.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const statusBadge = row.querySelector('.status-badge');
                    const fixButton = row.querySelector('.fix-button');

                    statusBadge.className = 'status-badge status-fixed';
                    statusBadge.textContent = 'Fixed';
                    fixButton.disabled = true;
                    fixButton.innerHTML = '<span>✅</span> Fixed';
                });

                showToast(`${selectedBugs.length} bugs marked as fixed successfully`);
            } catch (error) {
                showToast('Failed to apply fixes', 'error');
            } finally {
                setLoading(container, false);
            }
        }

        // Search functionality
        const searchInput = document.querySelector('.search-input');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.bug-row');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html> 