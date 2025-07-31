<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Component Mapping & Reuse - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .component-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .search-box {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: white;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .filter-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .component-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }

        .section-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .component-list {
            padding: 1.5rem;
        }

        .component-card {
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
            background: white;
        }

        .component-card:last-child {
            margin-bottom: 0;
        }

        .component-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .component-name {
            font-weight: 600;
            color: var(--text-color);
            font-size: 1.1rem;
        }

        .occurrence-count {
            background: var(--hover-color);
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            color: var(--text-color);
        }

        .preview-box {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            font-family: monospace;
            font-size: 0.875rem;
            color: #475569;
            overflow-x: auto;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
        }

        .action-button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background 0.2s;
        }

        .primary-button {
            background: var(--primary-color);
            color: white;
        }

        .primary-button:hover {
            background: #1d4ed8;
        }

        .secondary-button {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .secondary-button:hover {
            background: #e2e8f0;
        }

        .group-selected {
            background: var(--hover-color);
            padding: 1rem;
            border-radius: 0.375rem;
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .group-selected-text {
            color: var(--text-color);
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .component-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .action-button {
                width: 100%;
                text-align: center;
            }

            .preview-box {
                font-size: 0.75rem;
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
                    <li><a href="component-mapping.html" class="nav-link active">Component Mapping</a></li>
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
            <h1 class="page-title">Component Mapping & Reuse</h1>
            
            <div class="component-container">
                <input type="text" class="search-box" placeholder="Search components...">

                <div class="filter-tabs">
                    <button class="filter-tab active">All</button>
                    <button class="filter-tab">Layout</button>
                    <button class="filter-tab">UI Elements</button>
                    <button class="filter-tab">Forms</button>
                    <button class="filter-tab">Tables</button>
                </div>

                <!-- Suggested Components Section -->
                <section class="component-section">
                    <div class="section-header">
                        <h2 class="section-title">Suggested Reusable Components</h2>
                    </div>
                    <div class="component-list">
                        <div class="component-card">
                            <div class="component-header">
                                <div class="component-name">Navigation Bar</div>
                                <span class="occurrence-count">Found in 5 files</span>
                            </div>
                            <div class="preview-box">
                                &lt;nav class="navbar"&gt;
                                &lt;div class="nav-brand"&gt;Logo&lt;/div&gt;
                                &lt;ul class="nav-links"&gt;...&lt;/ul&gt;
                                &lt;/nav&gt;
                            </div>
                            <div class="action-buttons">
                                <button class="action-button primary-button">Convert to Blade Component</button>
                                <button class="action-button secondary-button">Preview</button>
                            </div>
                        </div>

                        <div class="component-card">
                            <div class="component-header">
                                <div class="component-name">Card Layout</div>
                                <span class="occurrence-count">Found in 8 files</span>
                            </div>
                            <div class="preview-box">
                                &lt;div class="card"&gt;
                                &lt;div class="card-header"&gt;...&lt;/div&gt;
                                &lt;div class="card-body"&gt;...&lt;/div&gt;
                                &lt;/div&gt;
                            </div>
                            <div class="action-buttons">
                                <button class="action-button primary-button">Convert to Blade Component</button>
                                <button class="action-button secondary-button">Preview</button>
                            </div>
                        </div>

                        <div class="component-card">
                            <div class="component-header">
                                <div class="component-name">Form Input Group</div>
                                <span class="occurrence-count">Found in 12 files</span>
                            </div>
                            <div class="preview-box">
                                &lt;div class="form-group"&gt;
                                &lt;label&gt;...&lt;/label&gt;
                                &lt;input type="text" class="form-control"&gt;
                                &lt;/div&gt;
                            </div>
                            <div class="action-buttons">
                                <button class="action-button primary-button">Convert to Blade Component</button>
                                <button class="action-button secondary-button">Preview</button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Mapped Components Section -->
                <section class="component-section">
                    <div class="section-header">
                        <h2 class="section-title">Already Mapped Components</h2>
                    </div>
                    <div class="component-list">
                        <div class="component-card">
                            <div class="component-header">
                                <div class="component-name">Button Component</div>
                                <span class="occurrence-count">Used 15 times</span>
                            </div>
                            <div class="preview-box">
                                @component('components.button')
                                @slot('text', 'Click Me')
                                @slot('type', 'primary')
                                @endcomponent
                            </div>
                            <div class="action-buttons">
                                <button class="action-button secondary-button">Edit Component</button>
                                <button class="action-button secondary-button">View Usage</button>
                            </div>
                        </div>

                        <div class="component-card">
                            <div class="component-header">
                                <div class="component-name">Alert Message</div>
                                <span class="occurrence-count">Used 7 times</span>
                            </div>
                            <div class="preview-box">
                                @component('components.alert')
                                @slot('type', 'success')
                                @slot('message', 'Operation completed')
                                @endcomponent
                            </div>
                            <div class="action-buttons">
                                <button class="action-button secondary-button">Edit Component</button>
                                <button class="action-button secondary-button">View Usage</button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Group Selected Section -->
                <div class="group-selected">
                    <span class="group-selected-text">3 components selected</span>
                    <button class="action-button primary-button">Group into Shared Partial</button>
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
                    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html> 