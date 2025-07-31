<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Report Summary - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .report-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .status-badge {
            display: inline-block;
            background: var(--active-color);
            color: var(--primary-color);
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .download-btn {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
            margin-bottom: 2rem;
        }
        .download-btn:hover {
            background: #1d4ed8;
        }
        .collapsible-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            overflow: hidden;
        }
        .collapsible-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 1.25rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            background: var(--hover-color);
            border: none;
            outline: none;
            width: 100%;
        }
        .collapsible-header .icon {
            font-size: 1.3rem;
        }
        .collapsible-content {
            padding: 1.25rem 1.5rem;
            display: none;
            border-top: 1px solid var(--border-color);
        }
        .collapsible-section.open .collapsible-content {
            display: block;
        }
        .issue-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .issue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        .issue-item:last-child {
            border-bottom: none;
        }
        .issue-title {
            font-weight: 500;
            color: var(--text-color);
        }
        .issue-actions {
            display: flex;
            gap: 0.5rem;
        }
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            color: var(--primary-color);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            transition: background 0.15s;
        }
        .icon-btn:hover {
            background: var(--active-color);
        }
        .progress-bar-container {
            background: var(--hover-color);
            border-radius: 0.25rem;
            height: 1.25rem;
            width: 100%;
            margin: 0.75rem 0 1.25rem 0;
            overflow: hidden;
        }
        .progress-bar {
            background: var(--primary-color);
            height: 100%;
            width: 60%;
            border-radius: 0.25rem 0 0 0.25rem;
            transition: width 0.3s;
        }
        @media (max-width: 768px) {
            .report-container {
                padding: 0 0.5rem;
            }
            .collapsible-header, .collapsible-content {
                padding-left: 1rem;
                padding-right: 1rem;
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
                    <li><a href="html-analysis.html" class="nav-link">HTML Analysis</a></li>
                    <li><a href="prompt-suggestion.html" class="nav-link">Prompt Suggestion</a></li>
                    <li><a href="report-view.html" class="nav-link active">Report View</a></li>
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
            <h1 class="page-title">Review Report Summary</h1>
            <div class="report-container">
                <span class="status-badge">Phase Status: In Review</span>
                <br>
                <button class="download-btn">Download Full Report</button>

                <!-- Matched Modules -->
                <section class="collapsible-section open">
                    <button class="collapsible-header" type="button">
                        <span class="icon">✅</span> Matched Modules
                    </button>
                    <div class="collapsible-content">
                        <ul class="issue-list">
                            <li class="issue-item">
                                <span class="issue-title">Navbar (navbar.html)</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                            <li class="issue-item">
                                <span class="issue-title">Footer (footer.html)</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Missing Modules -->
                <section class="collapsible-section open">
                    <button class="collapsible-header" type="button">
                        <span class="icon">❌</span> Missing Modules
                    </button>
                    <div class="collapsible-content">
                        <ul class="issue-list">
                            <li class="issue-item">
                                <span class="issue-title">Sidebar (sidebar.html)</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Duplicate Sections -->
                <section class="collapsible-section open">
                    <button class="collapsible-header" type="button">
                        <span class="icon">🔁</span> Duplicate Sections
                    </button>
                    <div class="collapsible-content">
                        <ul class="issue-list">
                            <li class="issue-item">
                                <span class="issue-title">Header found in index.html and dashboard.html</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- Optimization Opportunities -->
                <section class="collapsible-section open">
                    <button class="collapsible-header" type="button">
                        <span class="icon">⚙️</span> Optimization Opportunities
                    </button>
                    <div class="collapsible-content">
                        <div style="margin-bottom: 0.5rem; font-size: 0.95rem; color: #6b7280;">Optimization Progress</div>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: 60%"></div>
                        </div>
                        <ul class="issue-list">
                            <li class="issue-item">
                                <span class="issue-title">Minify CSS files</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                            <li class="issue-item">
                                <span class="issue-title">Remove unused JS functions</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- AI Suggestions -->
                <section class="collapsible-section open">
                    <button class="collapsible-header" type="button">
                        <span class="icon">💡</span> AI Suggestions
                    </button>
                    <div class="collapsible-content">
                        <ul class="issue-list">
                            <li class="issue-item">
                                <span class="issue-title">Enable bulk entry for module uploads</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                            <li class="issue-item">
                                <span class="issue-title">Add smart tools for prompt refinement</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                            <li class="issue-item">
                                <span class="issue-title">Implement auto notifications for report changes</span>
                                <span class="issue-actions">
                                    <button class="icon-btn" title="Mark as Fixed">✔️</button>
                                    <button class="icon-btn" title="Ignore">🚫</button>
                                </span>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script>
        // Collapsible logic
        document.querySelectorAll('.collapsible-header').forEach(header => {
            header.addEventListener('click', function() {
                const section = this.parentElement;
                section.classList.toggle('open');
            });
        });
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
        });
    </script>
</body>
</html> 