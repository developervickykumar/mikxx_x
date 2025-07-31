<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm & Finalize Publishing - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .summary-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .summary-label {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .summary-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .summary-value.score {
            color: #059669;
        }

        .summary-value.warning {
            color: #d97706;
        }

        .phase-checklist {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 0.5rem;
        }

        .phase-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .phase-item.completed {
            color: #059669;
        }

        .phase-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        .phase-divider {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
        }

        .phase-divider.completed {
            background: #059669;
        }

        .confirmation-block {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .warning-message {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
            color: #92400e;
        }

        .warning-icon {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
        }

        .confirmation-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .confirmation-checkbox input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .confirmation-checkbox label {
            font-size: 0.875rem;
            color: var(--text-color);
            cursor: pointer;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
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

        .report-button {
            padding: 0.75rem 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: white;
            color: var(--text-color);
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .report-button:hover {
            background: #f8fafc;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .summary-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .phase-checklist {
                flex-direction: column;
                align-items: flex-start;
            }

            .phase-divider {
                display: none;
            }

            .action-buttons {
                flex-direction: column;
            }

            .publish-button, .report-button {
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
                    <li><a href="final-checklist.html" class="nav-link">Final Checklist</a></li>
                    <li><a href="publish-confirmation.html" class="nav-link active">Publish Confirmation</a></li>
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
            <h1 class="page-title">Confirm & Finalize Publishing</h1>
            
            <div class="confirmation-container">
                <!-- Summary Section -->
                <div class="summary-section">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Module Name</span>
                            <span class="summary-value">User Dashboard</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Reviewer</span>
                            <span class="summary-value">John Doe</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Pages</span>
                            <span class="summary-value">12</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Bugs Found</span>
                            <span class="summary-value score">0</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Optimization Score</span>
                            <span class="summary-value score">100%</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Notifications</span>
                            <span class="summary-value">Configured</span>
                        </div>
                    </div>
                </div>

                <!-- Phase Checklist -->
                <div class="phase-checklist">
                    <div class="phase-item completed">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.3333 4L6 11.3333L2.66667 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Review</span>
                    </div>
                    <div class="phase-divider completed"></div>
                    <div class="phase-item completed">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.3333 4L6 11.3333L2.66667 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Build</span>
                    </div>
                    <div class="phase-divider"></div>
                    <div class="phase-item active">
                        <span>Publish</span>
                    </div>
                </div>

                <!-- Confirmation Block -->
                <div class="confirmation-block">
                    <div class="warning-message">
                        <svg class="warning-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p>Are you sure you want to mark this module as published? This cannot be undone.</p>
                    </div>

                    <div class="confirmation-checkbox">
                        <input type="checkbox" id="confirm-checkbox">
                        <label for="confirm-checkbox">I have reviewed everything above and confirm readiness.</label>
                    </div>

                    <div class="action-buttons">
                        <button class="publish-button" disabled>Publish Now</button>
                        <a href="publish-report.html" class="report-button">View Full Report</a>
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

            // Confirmation checkbox functionality
            const confirmCheckbox = document.getElementById('confirm-checkbox');
            const publishButton = document.querySelector('.publish-button');

            confirmCheckbox.addEventListener('change', function() {
                publishButton.disabled = !this.checked;
            });

            // Publish button functionality
            publishButton.addEventListener('click', function() {
                if (confirmCheckbox.checked) {
                    // Simulate publishing process
                    this.textContent = 'Publishing...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        window.location.href = 'publish-status.html';
                    }, 2000);
                }
            });
        });
    </script>
</body>
</html> 