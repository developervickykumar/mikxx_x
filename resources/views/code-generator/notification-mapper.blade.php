<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Trigger Mapper - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .notification-container {
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

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .global-rule-button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            background: var(--primary-color);
            color: white;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .global-rule-button:hover {
            background: #1d4ed8;
        }

        .notification-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .notification-table th {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 500;
            color: #475569;
            border-bottom: 1px solid var(--border-color);
        }

        .notification-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .notification-table tr:last-child td {
            border-bottom: none;
        }

        .notification-table tr:hover {
            background: #f8fafc;
        }

        .trigger-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 0.875rem;
            background: white;
        }

        .recipient-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 0.875rem;
            background: white;
        }

        .checkbox-group {
            display: flex;
            gap: 1rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-color);
        }

        .message-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .message-link:hover {
            text-decoration: underline;
        }

        .status-toggle {
            position: relative;
            display: inline-block;
            width: 3rem;
            height: 1.5rem;
        }

        .status-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e2e8f0;
            transition: .4s;
            border-radius: 1.5rem;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 1.25rem;
            width: 1.25rem;
            left: 0.125rem;
            bottom: 0.125rem;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: var(--primary-color);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(1.5rem);
        }

        .test-button {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            background: white;
            color: var(--text-color);
            cursor: pointer;
            font-size: 0.75rem;
            transition: all 0.2s;
        }

        .test-button:hover {
            background: #f8fafc;
            border-color: var(--primary-color);
            color: var(--primary-color);
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

        .tooltip-icon {
            color: #6b7280;
            cursor: help;
            margin-left: 0.25rem;
        }

        @media (max-width: 1024px) {
            .notification-container {
                grid-template-columns: 1fr;
            }

            .summary-sidebar {
                grid-column: 1;
            }
        }

        @media (max-width: 768px) {
            .notification-table {
                display: block;
                overflow-x: auto;
            }

            .checkbox-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-bar {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
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
                    <li><a href="bug-fixer.html" class="nav-link">Bug Fixer</a></li>
                    <li><a href="role-mapper.html" class="nav-link">Role Mapper</a></li>
                    <li><a href="notification-mapper.html" class="nav-link active">Notification Mapper</a></li>
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
            <h1 class="page-title">Notification Trigger Mapper</h1>
            
            <div class="notification-container">
                <div class="main-content">
                    <div class="action-bar">
                        <button class="global-rule-button">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 3.33334V12.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M3.33334 8H12.6667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            Add Global Notification Rule
                        </button>
                    </div>

                    <table class="notification-table">
                        <thead>
                            <tr>
                                <th>Page Name</th>
                                <th>Trigger Type</th>
                                <th>Notify Via</th>
                                <th>Recipient Type</th>
                                <th>Message Template</th>
                                <th>Status</th>
                                <th>Test</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>contact.blade.php</td>
                                <td>
                                    <select class="trigger-select">
                                        <option value="submit">On Submit</option>
                                        <option value="update">On Update</option>
                                        <option value="error">On Error</option>
                                        <option value="login">On Login</option>
                                        <option value="approval">On Approval</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="checkbox-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" checked> Email
                                        </label>
                                        <label class="checkbox-label">
                                            <input type="checkbox"> Chat
                                        </label>
                                        <label class="checkbox-label">
                                            <input type="checkbox"> Fynix
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <select class="recipient-select">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                        <option value="business">Business Owner</option>
                                        <option value="all">All</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" class="message-link">Edit Template</a>
                                </td>
                                <td>
                                    <label class="status-toggle">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <button class="test-button">Send Test</button>
                                </td>
                            </tr>
                            <tr>
                                <td>dashboard.blade.php</td>
                                <td>
                                    <select class="trigger-select">
                                        <option value="login">On Login</option>
                                        <option value="submit">On Submit</option>
                                        <option value="update">On Update</option>
                                        <option value="error">On Error</option>
                                        <option value="approval">On Approval</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="checkbox-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox"> Email
                                        </label>
                                        <label class="checkbox-label">
                                            <input type="checkbox" checked> Chat
                                        </label>
                                        <label class="checkbox-label">
                                            <input type="checkbox" checked> Fynix
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <select class="recipient-select">
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                        <option value="business">Business Owner</option>
                                        <option value="all">All</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" class="message-link">Edit Template</a>
                                </td>
                                <td>
                                    <label class="status-toggle">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </td>
                                <td>
                                    <button class="test-button">Send Test</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="summary-sidebar">
                    <div class="summary-card">
                        <h3 class="summary-title">Notification Summary</h3>
                        <ul class="summary-list">
                            <li class="summary-item">
                                <span>Pages with Notifications</span>
                                <span class="summary-number">8</span>
                            </li>
                            <li class="summary-item">
                                <span>Most Common Trigger</span>
                                <span class="summary-number">On Submit</span>
                            </li>
                            <li class="summary-item">
                                <span>Email Notifications</span>
                                <span class="summary-number">12</span>
                            </li>
                            <li class="summary-item">
                                <span>Chat Notifications</span>
                                <span class="summary-number">8</span>
                            </li>
                            <li class="summary-item">
                                <span>Fynix Notifications</span>
                                <span class="summary-number">5</span>
                            </li>
                            <li class="summary-item">
                                <span>Active Rules</span>
                                <span class="summary-number">15</span>
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

            // Test button functionality
            document.querySelectorAll('.test-button').forEach(button => {
                button.addEventListener('click', function() {
                    const originalText = this.textContent;
                    this.textContent = 'Sending...';
                    this.disabled = true;
                    
                    // Simulate sending test notification
                    setTimeout(() => {
                        this.textContent = 'Sent!';
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.disabled = false;
                        }, 2000);
                    }, 1000);
                });
            });
        });
    </script>
</body>
</html> 