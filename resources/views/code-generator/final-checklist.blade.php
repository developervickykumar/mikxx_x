<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Code Review Checklist - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .checklist-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-info {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .phase-progress {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .progress-step.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        .progress-step.completed {
            color: #059669;
        }

        .progress-line {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
        }

        .progress-line.completed {
            background: #059669;
        }

        .checklist-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .section-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-content {
            padding: 1.5rem;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .checklist-item:last-child {
            border-bottom: none;
        }

        .item-status {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-done {
            background: #dcfce7;
            color: #059669;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 3rem;
            height: 1.5rem;
        }

        .toggle-switch input {
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

        .remark-button {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            background: white;
            color: var(--text-color);
            cursor: pointer;
            font-size: 0.75rem;
            transition: all 0.2s;
        }

        .remark-button:hover {
            background: #f8fafc;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .remark-textarea {
            display: none;
            width: 100%;
            margin-top: 0.5rem;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            font-size: 0.875rem;
            resize: vertical;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding: 1rem;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
        }

        .publish-button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            background: var(--primary-color);
            color: white;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background 0.2s;
        }

        .publish-button:hover {
            background: #1d4ed8;
        }

        .publish-button:disabled {
            background: #e2e8f0;
            cursor: not-allowed;
        }

        .auto-check-button {
            padding: 0.75rem 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: white;
            color: var(--text-color);
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .auto-check-button:hover {
            background: #f8fafc;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .header-info {
                grid-template-columns: 1fr;
            }

            .phase-progress {
                flex-direction: column;
                align-items: flex-start;
            }

            .progress-line {
                display: none;
            }

            .checklist-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .action-bar {
                flex-direction: column;
                gap: 1rem;
            }

            .publish-button, .auto-check-button {
                width: 100%;
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
                    <li><a href="final-checklist.html" class="nav-link active">Final Checklist</a></li>
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
            <h1 class="page-title">Final Code Review Checklist</h1>
            
            <div class="checklist-container">
                <!-- Header Info -->
                <div class="header-info">
                    <div class="info-item">
                        <span class="info-label">Module Name</span>
                        <span class="info-value">User Dashboard</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Current Phase</span>
                        <span class="info-value">Final Review</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Reviewer</span>
                        <span class="info-value">John Doe</span>
                    </div>
                </div>

                <!-- Phase Progress -->
                <div class="phase-progress">
                    <div class="progress-step completed">
                        <span>Review</span>
                    </div>
                    <div class="progress-line completed"></div>
                    <div class="progress-step completed">
                        <span>Build</span>
                    </div>
                    <div class="progress-line"></div>
                    <div class="progress-step active">
                        <span>Publish</span>
                    </div>
                </div>

                <!-- Code Quality Section -->
                <div class="checklist-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 2.5L2.5 5V10C2.5 14.1421 5.85786 17.5 10 17.5C14.1421 17.5 17.5 14.1421 17.5 10V5L10 2.5Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Code Quality
                        </h2>
                    </div>
                    <div class="section-content">
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span>No duplicate code</span>
                            <span class="item-status status-done">Done</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span>All Blade files validated</span>
                            <span class="item-status status-done">Done</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Optimization Section -->
                <div class="checklist-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 2.5L2.5 5V10C2.5 14.1421 5.85786 17.5 10 17.5C14.1421 17.5 17.5 14.1421 17.5 10V5L10 2.5Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Optimization
                        </h2>
                    </div>
                    <div class="section-content">
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span>Optimization completed</span>
                            <span class="item-status status-done">Done</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox">
                                <span class="toggle-slider"></span>
                            </label>
                            <span>Responsive layout tested</span>
                            <span class="item-status status-pending">Pending</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div class="checklist-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 2.5L2.5 5V10C2.5 14.1421 5.85786 17.5 10 17.5C14.1421 17.5 17.5 14.1421 17.5 10V5L10 2.5Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Notifications
                        </h2>
                    </div>
                    <div class="section-content">
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span>Notifications mapped</span>
                            <span class="item-status status-done">Done</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span>Email templates attached</span>
                            <span class="item-status status-done">Done</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span>Fynix triggers set</span>
                            <span class="item-status status-done">Done</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Bug Reports Section -->
                <div class="checklist-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 2.5L2.5 5V10C2.5 14.1421 5.85786 17.5 10 17.5C14.1421 17.5 17.5 14.1421 17.5 10V5L10 2.5Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Bug Reports
                        </h2>
                    </div>
                    <div class="section-content">
                        <div class="checklist-item">
                            <label class="toggle-switch">
                                <input type="checkbox" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span>Bug reports cleared</span>
                            <span class="item-status status-done">Done</span>
                            <button class="remark-button">Add Remark</button>
                            <textarea class="remark-textarea" rows="2" placeholder="Add your remarks here..."></textarea>
                        </div>
            </div>
            </div>
        
                <!-- Action Bar -->
                <div class="action-bar">
                    <button class="auto-check-button">Auto-Check All</button>
                    <button class="publish-button" disabled>Mark as Ready to Publish</button>
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

            // Toggle sections
            document.querySelectorAll('.section-header').forEach(header => {
                header.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    content.style.display = content.style.display === 'none' ? 'block' : 'none';
                });
            });

            // Remark button functionality
            document.querySelectorAll('.remark-button').forEach(button => {
                button.addEventListener('click', function() {
                    const textarea = this.nextElementSibling;
                    textarea.style.display = textarea.style.display === 'none' ? 'block' : 'none';
                });
            });

            // Toggle switch functionality
            document.querySelectorAll('.toggle-switch input').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const item = this.closest('.checklist-item');
                    const status = item.querySelector('.item-status');
                    if (this.checked) {
                        status.className = 'item-status status-done';
                        status.textContent = 'Done';
                    } else {
                        status.className = 'item-status status-pending';
                        status.textContent = 'Pending';
                    }
                    updatePublishButton();
                });
            });

            // Auto-check functionality
            document.querySelector('.auto-check-button').addEventListener('click', function() {
                document.querySelectorAll('.toggle-switch input').forEach(toggle => {
                    toggle.checked = true;
                    const item = toggle.closest('.checklist-item');
                    const status = item.querySelector('.item-status');
                    status.className = 'item-status status-done';
                    status.textContent = 'Done';
                });
                updatePublishButton();
            });

            function updatePublishButton() {
                const publishButton = document.querySelector('.publish-button');
                const allChecked = Array.from(document.querySelectorAll('.toggle-switch input')).every(input => input.checked);
                publishButton.disabled = !allChecked;
            }
        });
    </script>
</body>
</html> 