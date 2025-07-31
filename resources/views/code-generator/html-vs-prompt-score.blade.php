<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML vs Prompt Accuracy Score - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .score-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .score-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
        }

        .circular-progress {
            position: relative;
            width: 200px;
            height: 200px;
            flex-shrink: 0;
        }

        .circular-progress svg {
            transform: rotate(-90deg);
        }

        .circular-progress circle {
            fill: none;
            stroke-width: 8;
        }

        .circular-progress .bg {
            stroke: var(--hover-color);
        }

        .circular-progress .progress {
            stroke: var(--primary-color);
            stroke-linecap: round;
            transition: stroke-dashoffset 0.5s ease;
        }

        .score-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-color);
        }

        .score-details {
            flex: 1;
        }

        .score-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .score-description {
            color: #6b7280;
            line-height: 1.6;
        }

        .breakdown-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .breakdown-table th {
            background: var(--hover-color);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-color);
        }

        .breakdown-table td {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
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

        .accuracy-score {
            font-weight: 600;
        }

        .accuracy-high {
            color: #166534;
        }

        .accuracy-medium {
            color: #92400e;
        }

        .accuracy-low {
            color: #991b1b;
        }

        .feedback-section {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .feedback-section h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .feedback-textarea {
            width: 100%;
            min-height: 120px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.6;
            resize: vertical;
            margin-bottom: 1rem;
        }

        .complete-button {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }

        .complete-button:hover {
            background: #1d4ed8;
        }

        @media (max-width: 768px) {
            .score-header {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem;
            }

            .circular-progress {
                margin-bottom: 1.5rem;
            }

            .breakdown-table {
                display: block;
                overflow-x: auto;
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
                    <li><a href="report-view.html" class="nav-link">Report View</a></li>
                    <li><a href="html-vs-prompt-score.html" class="nav-link active">HTML vs Prompt Score</a></li>
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
            <h1 class="page-title">HTML vs Prompt Accuracy Score</h1>
            
            <div class="score-container">
                <div class="score-header">
                    <div class="circular-progress">
                        <svg width="200" height="200" viewBox="0 0 200 200">
                            <circle class="bg" cx="100" cy="100" r="90" />
                            <circle class="progress" cx="100" cy="100" r="90" 
                                    stroke-dasharray="565.48" 
                                    stroke-dashoffset="90.48" />
                        </svg>
                        <div class="score-value">84%</div>
                    </div>
                    <div class="score-details">
                        <h2 class="score-title">Overall Accuracy Score</h2>
                        <p class="score-description">
                            This score represents how well the generated HTML/CSS/JS files match the requirements specified in the original prompt. 
                            A higher score indicates better alignment between the prompt and implementation.
                        </p>
                    </div>
                </div>

                <table class="breakdown-table">
                    <thead>
                        <tr>
                            <th>Module Name</th>
                            <th>Expected by Prompt?</th>
                            <th>Present in HTML?</th>
                            <th>Accuracy Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Navigation Bar</td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="accuracy-score accuracy-high">95%</span></td>
                        </tr>
                        <tr>
                            <td>Footer</td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="accuracy-score accuracy-high">90%</span></td>
                        </tr>
                        <tr>
                            <td>Sidebar</td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="status-badge status-no">No</span></td>
                            <td><span class="accuracy-score accuracy-low">0%</span></td>
                        </tr>
                        <tr>
                            <td>Search Form</td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="accuracy-score accuracy-medium">75%</span></td>
                        </tr>
                        <tr>
                            <td>User Profile</td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="status-badge status-yes">Yes</span></td>
                            <td><span class="accuracy-score accuracy-high">85%</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="feedback-section">
                    <h2>Your Review on Prompt Accuracy</h2>
                    <textarea class="feedback-textarea" placeholder="Enter your feedback about the prompt accuracy and implementation..."></textarea>
                    <button class="complete-button">Mark Review Phase as Completed</button>
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
        });
    </script>
</body>
</html> 