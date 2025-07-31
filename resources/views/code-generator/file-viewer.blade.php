<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Viewer - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="phase-buttons">
                <button class="phase-button" data-phase="review">Review</button>
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
            <h1 class="page-title">File Viewer</h1>
            <div class="content-section">
                
            <div class="content-section">
                <h2>Overview</h2>
                <p>This is the File Viewer page. Content will be added here.</p>
            </div>
            <div class="content-section">
                <h2>Details</h2>
                <p>Additional content and functionality will be implemented here.</p>
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