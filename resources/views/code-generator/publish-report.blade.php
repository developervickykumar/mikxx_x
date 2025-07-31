<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Publish Report - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .report-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .module-summary {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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

        .report-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: var(--text-color);
            font-weight: 500;
        }

        .section-header svg {
            width: 20px;
            height: 20px;
            color: #059669;
        }

        .completed-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .completed-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .completed-item:last-child {
            border-bottom: none;
        }

        .completed-item svg {
            width: 16px;
            height: 16px;
            color: #059669;
            flex-shrink: 0;
        }

        .completed-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .completed-link:hover {
            text-decoration: underline;
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

        .archive-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .archive-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .archive-checkbox input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .archive-checkbox label {
            font-size: 0.875rem;
            color: var(--text-color);
            cursor: pointer;
        }

        .archive-button {
            padding: 0.5rem 1rem;
            border: 1px solid #dc2626;
            border-radius: 0.375rem;
            background: white;
            color: #dc2626;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .archive-button:hover {
            background: #dc2626;
            color: white;
        }

        .archive-button:disabled {
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .signature-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .signature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .signature-box {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .signature-label {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .signature-line {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .audit-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .audit-table th {
            background: #f8fafc;
            padding: 0.75rem;
            text-align: left;
            font-weight: 500;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
        }

        .audit-table td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
            font-size: 0.875rem;
        }

        .audit-table tr:last-child td {
            border-bottom: none;
        }

        .timestamp {
            font-size: 0.75rem;
            color: #6b7280;
        }

        @media print {
            .action-bar {
                display: none;
            }

            .report-section {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }

        @media (max-width: 1024px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .signature-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-direction: column;
                gap: 1rem;
            }

            .export-buttons {
                width: 100%;
                justify-content: flex-start;
            }

            .archive-section {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
            }

            .audit-table {
                display: block;
                overflow-x: auto;
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
                    <li><a href="publish-status.html" class="nav-link">Publish Status</a></li>
                    <li><a href="publish-report.html" class="nav-link active">Publish Report</a></li>
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
            <h1 class="page-title">Final Publish Report</h1>
            
            <div class="report-container">
                <!-- Module Summary -->
                <div class="module-summary">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">Module Name</span>
                            <span class="summary-value">User Dashboard</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Pages</span>
                            <span class="summary-value">12</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Final Reviewer</span>
                            <span class="summary-value">John Doe</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Date Published</span>
                            <span class="summary-value">2024-02-20</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Prompt Accuracy</span>
                            <span class="summary-value score">95%</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Bug Score</span>
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

                <!-- Completed Pages -->
                <div class="report-section">
                    <div class="section-header">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Pages Completed
                    </div>
                    <ul class="completed-list">
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">Dashboard Home</a>
                        </li>
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">User Profile</a>
                        </li>
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">Settings</a>
                        </li>
                    </ul>
                </div>

                <!-- Blade Components -->
                <div class="report-section">
                    <div class="section-header">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Blade Components Used
                    </div>
                    <ul class="completed-list">
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">Header Component</a>
                        </li>
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">Navigation Menu</a>
                        </li>
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">User Card</a>
                        </li>
                    </ul>
                </div>

                <!-- Notifications Setup -->
                <div class="report-section">
                    <div class="section-header">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Notifications Setup Summary
                    </div>
                    <ul class="completed-list">
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">Profile Update Notification</a>
                        </li>
                        <li class="completed-item">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="#" class="completed-link">Settings Change Alert</a>
                        </li>
                    </ul>
                </div>

                <!-- Audit Log -->
                <div class="report-section">
                    <div class="section-header">
                        <svg viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Audit Log
                    </div>
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Phase</th>
                                <th>Completed By</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Review</td>
                                <td>John Doe</td>
                                <td><div class="timestamp">2024-02-15 10:30 AM</div></td>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <td>Build</td>
                                <td>Jane Smith</td>
                                <td><div class="timestamp">2024-02-18 02:15 PM</div></td>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <td>Publish</td>
                                <td>John Doe</td>
                                <td><div class="timestamp">2024-02-20 09:45 AM</div></td>
                                <td>Completed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Signatures -->
                <div class="signature-section">
                    <div class="signature-grid">
                        <div class="signature-box">
                            <span class="signature-label">Reviewed By</span>
                            <div class="signature-line">John Doe</div>
                        </div>
                        <div class="signature-box">
                            <span class="signature-label">Approved By</span>
                            <div class="signature-line">Jane Smith</div>
                        </div>
            </div>
            </div>
        
                <!-- Action Bar -->
                <div class="action-bar">
                    <div class="export-buttons">
                        <button class="export-button">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 11L3 6H7V1H9V6H13L8 11Z" fill="currentColor"/>
                                <path d="M14 13V14H2V13H14Z" fill="currentColor"/>
                            </svg>
                            Download PDF
                        </button>
                        <button class="export-button">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 11L3 6H7V1H9V6H13L8 11Z" fill="currentColor"/>
                                <path d="M14 13V14H2V13H14Z" fill="currentColor"/>
                            </svg>
                            Export CSV Report
                        </button>
                    </div>
                    <div class="archive-section">
                        <div class="archive-checkbox">
                            <input type="checkbox" id="archive-checkbox">
                            <label for="archive-checkbox">I confirm this module is ready to be archived</label>
                        </div>
                        <button class="archive-button" disabled>Mark as Archived</button>
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

            // Archive checkbox functionality
            const archiveCheckbox = document.getElementById('archive-checkbox');
            const archiveButton = document.querySelector('.archive-button');

            archiveCheckbox.addEventListener('change', function() {
                archiveButton.disabled = !this.checked;
            });

            // Archive button functionality
            archiveButton.addEventListener('click', function() {
                if (archiveCheckbox.checked) {
                    // Simulate archiving process
                    this.textContent = 'Archiving...';
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