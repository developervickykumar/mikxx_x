<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Structure & Module Analysis - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .analysis-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .summary-panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .summary-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .table-container {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .analysis-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .analysis-table th {
            background: var(--hover-color);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-color);
            white-space: nowrap;
        }

        .analysis-table td {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .analysis-table tr:hover {
            background: var(--hover-color);
        }

        .file-type {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .type-html {
            background: #e0f2fe;
            color: #0369a1;
        }

        .type-css {
            background: #f0fdf4;
            color: #166534;
        }

        .type-js {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-yes {
            background: #f0fdf4;
            color: #166534;
        }

        .status-no {
            background: #fee2e2;
            color: #991b1b;
        }

        .missing-sections {
            color: #6b7280;
            font-size: 0.75rem;
        }

        .suggestions {
            color: #6b7280;
            font-size: 0.75rem;
        }

        .download-button {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
            margin-bottom: 1.5rem;
        }

        .download-button:hover {
            background: #1d4ed8;
        }

        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .analysis-table {
                min-width: 800px;
            }

            .summary-panel {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="phase-buttons">
                <button class="phase-button active" data-phase="review">Review</button>
                <button class="phase-button" data-phase="build">Build</button>
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
                    <li><a href="html-analysis.html" class="nav-link active">HTML Analysis</a></li>
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
            <h1 class="page-title">HTML Structure & Module Analysis</h1>
            
            <div class="analysis-container">
                <button class="download-button">Download Analysis Report</button>

                <div class="summary-panel">
                    <div class="summary-card">
                        <div class="summary-value">12</div>
                        <div class="summary-label">Total Files</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">85%</div>
                        <div class="summary-label">Matched to Prompt</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">3</div>
                        <div class="summary-label">Duplicates Found</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">5</div>
                        <div class="summary-label">Optimization Required</div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="analysis-table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Type</th>
                                <th>Matched to Prompt</th>
                                <th>Duplicates Found</th>
                                <th>Missing Sections</th>
                                <th>Optimization Suggestions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>index.html</td>
                                <td><span class="file-type type-html">HTML</span></td>
                                <td><span class="status-badge status-yes">Yes</span></td>
                                <td><span class="status-badge status-no">No</span></td>
                                <td class="missing-sections">Footer component</td>
                                <td class="suggestions">Minify HTML, Optimize images</td>
                            </tr>
                            <tr>
                                <td>styles.css</td>
                                <td><span class="file-type type-css">CSS</span></td>
                                <td><span class="status-badge status-yes">Yes</span></td>
                                <td><span class="status-badge status-yes">Yes</span></td>
                                <td class="missing-sections">-</td>
                                <td class="suggestions">Split into modules, Remove unused CSS</td>
                            </tr>
                            <tr>
                                <td>main.js</td>
                                <td><span class="file-type type-js">JS</span></td>
                                <td><span class="status-badge status-no">No</span></td>
                                <td><span class="status-badge status-no">No</span></td>
                                <td class="missing-sections">Error handling</td>
                                <td class="suggestions">Minify JS, Add error boundaries</td>
                            </tr>
                            <tr>
                                <td>navbar.html</td>
                                <td><span class="file-type type-html">HTML</span></td>
                                <td><span class="status-badge status-yes">Yes</span></td>
                                <td><span class="status-badge status-yes">Yes</span></td>
                                <td class="missing-sections">Mobile menu</td>
                                <td class="suggestions">Extract to component</td>
                            </tr>
                            <tr>
                                <td>utils.js</td>
                                <td><span class="file-type type-js">JS</span></td>
                                <td><span class="status-badge status-yes">Yes</span></td>
                                <td><span class="status-badge status-no">No</span></td>
                                <td class="missing-sections">-</td>
                                <td class="suggestions">Add unit tests</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Set active phase button based on current page
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
        });
    </script>
</body>
</html> 