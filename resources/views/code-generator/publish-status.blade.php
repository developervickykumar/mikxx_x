<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Status & Progress - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .status-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .summary-counters {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .counter-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
        }

        .counter-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.25rem;
        }

        .counter-label {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .filters-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .status-filter {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: white;
            color: var(--text-color);
            min-width: 150px;
        }

        .search-box {
            flex: 1;
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: white;
            color: var(--text-color);
        }

        .export-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .export-button {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: white;
            color: var(--text-color);
            cursor: pointer;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .export-button:hover {
            background: #f8fafc;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .status-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .status-table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 500;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
        }

        .status-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .status-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-drafted {
            background: #f3f4f6;
            color: #6b7280;
        }

        .status-review {
            background: #fef3c7;
            color: #d97706;
        }

        .status-build {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-ready {
            background: #dcfce7;
            color: #059669;
        }

        .status-published {
            background: #f0fdf4;
            color: #16a34a;
        }

        .progress-bar {
            width: 100%;
            height: 0.5rem;
            background: #e5e7eb;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-color);
            border-radius: 0.25rem;
            transition: width 0.3s ease;
        }

        .action-button {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            background: white;
            color: var(--text-color);
            cursor: pointer;
            font-size: 0.75rem;
            transition: all 0.2s;
        }

        .action-button:hover {
            background: #f8fafc;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .timestamp {
            font-size: 0.75rem;
            color: #6b7280;
        }

        @media (max-width: 1024px) {
            .summary-counters {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .summary-counters {
                grid-template-columns: repeat(2, 1fr);
            }

            .filters-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .export-buttons {
                justify-content: flex-start;
            }

            .status-table {
                display: block;
                overflow-x: auto;
            }

            .status-table th,
            .status-table td {
                white-space: nowrap;
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
                <button class="phase-button" data-phase="build">Build</button>
                <button class="phase-button active" data-phase="publish">Publish</button>
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
                    <li><a href="publish-status.html" class="nav-link active">Publish Status</a></li>
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
            <h1 class="page-title">Publish Status & Progress</h1>
            
            <div class="status-container">
                <!-- Summary Counters -->
                <div class="summary-counters">
                    <div class="counter-card">
                        <div class="counter-value">24</div>
                        <div class="counter-label">Total Modules</div>
                    </div>
                    <div class="counter-card">
                        <div class="counter-value">5</div>
                        <div class="counter-label">Drafted</div>
                    </div>
                    <div class="counter-card">
                        <div class="counter-value">8</div>
                        <div class="counter-label">In Review</div>
                    </div>
                    <div class="counter-card">
                        <div class="counter-value">6</div>
                        <div class="counter-label">In Build</div>
                    </div>
                    <div class="counter-card">
                        <div class="counter-value">3</div>
                        <div class="counter-label">Ready to Publish</div>
                    </div>
                    <div class="counter-card">
                        <div class="counter-value">2</div>
                        <div class="counter-label">Published</div>
                    </div>
                </div>

                <!-- Filters and Export -->
                <div class="filters-bar">
                    <select class="status-filter">
                        <option value="">All Statuses</option>
                        <option value="drafted">Drafted</option>
                        <option value="review">In Review</option>
                        <option value="build">In Build</option>
                        <option value="ready">Ready to Publish</option>
                        <option value="published">Published</option>
                    </select>
                    <input type="text" class="search-box" placeholder="Search by module name...">
                    <div class="export-buttons">
                        <button class="export-button">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 11L3 6H7V1H9V6H13L8 11Z" fill="currentColor"/>
                                <path d="M14 13V14H2V13H14Z" fill="currentColor"/>
                            </svg>
                            Download CSV
                        </button>
                        <button class="export-button">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 11L3 6H7V1H9V6H13L8 11Z" fill="currentColor"/>
                                <path d="M14 13V14H2V13H14Z" fill="currentColor"/>
                            </svg>
                            Download PDF
                        </button>
                    </div>
                </div>

                <!-- Status Table -->
                <table class="status-table">
                    <thead>
                        <tr>
                            <th>Module Name</th>
                            <th>Status</th>
                            <th>Last Updated By</th>
                            <th>Progress</th>
                            <th>Created</th>
                            <th>Published</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>User Dashboard</td>
                            <td><span class="status-badge status-published">Published</span></td>
                            <td>John Doe</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 100%"></div>
                                </div>
                            </td>
                            <td>
                                <div class="timestamp">2024-02-15</div>
                            </td>
                            <td>
                                <div class="timestamp">2024-02-20</div>
                            </td>
                            <td>
                                <button class="action-button">View Report</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Admin Panel</td>
                            <td><span class="status-badge status-ready">Ready to Publish</span></td>
                            <td>Jane Smith</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 100%"></div>
                                </div>
                            </td>
                            <td>
                                <div class="timestamp">2024-02-16</div>
                            </td>
                            <td>
                                <div class="timestamp">-</div>
                            </td>
                            <td>
                                <button class="action-button">Open Module</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Settings Page</td>
                            <td><span class="status-badge status-build">In Build</span></td>
                            <td>Mike Johnson</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 75%"></div>
                                </div>
                            </td>
                            <td>
                                <div class="timestamp">2024-02-17</div>
                            </td>
                            <td>
                                <div class="timestamp">-</div>
                            </td>
                            <td>
                                <button class="action-button">Open Module</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

            // Search functionality
            const searchBox = document.querySelector('.search-box');
            searchBox.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.status-table tbody tr');
                
                rows.forEach(row => {
                    const moduleName = row.querySelector('td:first-child').textContent.toLowerCase();
                    row.style.display = moduleName.includes(searchTerm) ? '' : 'none';
                });
            });

            // Status filter functionality
            const statusFilter = document.querySelector('.status-filter');
            statusFilter.addEventListener('change', function() {
                const selectedStatus = this.value.toLowerCase();
                const rows = document.querySelectorAll('.status-table tbody tr');
                
                rows.forEach(row => {
                    const status = row.querySelector('.status-badge').textContent.toLowerCase();
                    row.style.display = !selectedStatus || status === selectedStatus ? '' : 'none';
                });
            });
        });
    </script>
</body>
</html> 