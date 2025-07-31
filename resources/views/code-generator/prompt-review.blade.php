<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Original Prompt - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .review-container {
            display: flex;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .prompt-section {
            flex: 1;
        }

        .stats-sidebar {
            width: 300px;
            flex-shrink: 0;
        }

        .prompt-textarea {
            width: 100%;
            min-height: 300px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.6;
            resize: vertical;
            background: white;
        }

        .prompt-textarea:read-only {
            background: var(--hover-color);
            cursor: default;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .edit-button {
            background: var(--primary-color);
            color: white;
        }

        .edit-button:hover {
            background: #1d4ed8;
        }

        .regenerate-button {
            background: white;
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .regenerate-button:hover {
            background: var(--hover-color);
        }

        .stats-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-title {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .stats-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .stats-phase {
            background: var(--active-color);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .review-container {
                flex-direction: column;
            }

            .stats-sidebar {
                width: 100%;
            }

            .button-group {
                flex-direction: column;
            }

            .action-button {
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
                    <li><a href="prompt-review.html" class="nav-link active">Prompt Review</a></li>
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
            <h1 class="page-title">Review Original Prompt</h1>
            
            <div class="review-container">
                <div class="prompt-section">
                    <div class="content-section">
                        <textarea id="promptText" class="prompt-textarea" readonly>This is the original prompt that was used to generate the code. It will be populated with the actual prompt text from the previous step.</textarea>
                        
                        <div class="button-group">
                            <button id="editButton" class="action-button edit-button">Edit Prompt</button>
                            <button class="action-button regenerate-button">Regenerate Analysis</button>
                        </div>
                    </div>
                </div>

                <div class="stats-sidebar">
                    <div class="stats-card">
                        <div class="stats-title">Total Uploaded Files</div>
                        <div class="stats-value">12</div>
                    </div>
                    
                    <div class="stats-card">
                        <div class="stats-title">HTML Modules</div>
                        <div class="stats-value">5</div>
                    </div>
                    
                    <div class="stats-card">
                        <div class="stats-title">Current Phase</div>
                        <div class="stats-phase">Review</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const promptText = document.getElementById('promptText');
        const editButton = document.getElementById('editButton');
        let isEditing = false;

        editButton.addEventListener('click', () => {
            isEditing = !isEditing;
            promptText.readOnly = !isEditing;
            editButton.textContent = isEditing ? 'Save Changes' : 'Edit Prompt';
            
            if (!isEditing) {
                // TODO: Implement save functionality
                console.log('Saving prompt changes...');
            }
        });
    </script>
</body>
</html> 