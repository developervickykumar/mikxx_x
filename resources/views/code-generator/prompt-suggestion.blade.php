<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Prompt Suggestions - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --text-color: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --background-color: #ffffff;
            --card-background: #f8fafc;
            --hover-color: #f1f5f9;
            --success-color: #059669;
            --warning-color: #d97706;
            --error-color: #dc2626;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --transition: all 0.2s ease-in-out;
        }

        .prompt-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Score Box Improvements */
        .score-box {
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .score-box:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .score-details {
            display: flex;
            justify-content: space-around;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .score-metric {
            text-align: center;
        }

        .metric-value {
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .metric-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Prompt Grid Improvements */
        .prompt-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .prompt-section {
            position: relative;
            display: flex;
            flex-direction: column;
            background: var(--card-background);
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .prompt-section:hover {
            box-shadow: var(--shadow-md);
        }

        .prompt-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .prompt-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .prompt-tools {
            display: flex;
            gap: 0.5rem;
        }

        .tool-button {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: var(--background-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
        }

        .tool-button:hover {
            background: var(--hover-color);
            color: var(--primary-color);
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
            transition: var(--transition);
        }

        .prompt-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .prompt-textarea:read-only {
            background: var(--hover-color);
            cursor: default;
        }

        /* Recommendations Improvements */
        .recommendations {
            background: var(--card-background);
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .recommendations:hover {
            box-shadow: var(--shadow-md);
        }

        .recommendations-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .recommendation-filters {
            display: flex;
            gap: 0.5rem;
        }

        .filter-button {
            padding: 0.25rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            font-size: 0.75rem;
            background: var(--background-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-button.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .recommendation-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            margin-bottom: 0.75rem;
            background: var(--background-color);
            transition: var(--transition);
        }

        .recommendation-item:hover {
            border-color: var(--primary-color);
            transform: translateX(4px);
        }

        .recommendation-item:last-child {
            margin-bottom: 0;
        }

        .recommendation-severity {
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .severity-high {
            background: #fee2e2;
            color: var(--error-color);
        }

        .severity-medium {
            background: #fef3c7;
            color: var(--warning-color);
        }

        .severity-low {
            background: #dcfce7;
            color: var(--success-color);
        }

        /* Action Buttons Improvements */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .accept-button {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .accept-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .accept-button.loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .accept-button.loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 1000;
        }

        .toast {
            padding: 1rem;
            border-radius: 0.5rem;
            background: var(--text-color);
            color: white;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .prompt-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .accept-button {
                width: 100%;
            }

            .recommendations-header {
                flex-direction: column;
                gap: 1rem;
            }

            .recommendation-filters {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }

            .filter-button {
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
                    <li><a href="prompt-suggestion.html" class="nav-link active">Prompt Suggestion</a></li>
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
            <h1 class="page-title">AI Prompt Suggestions</h1>
            
            <div class="prompt-container">
                <div class="score-box">
                    <div class="score-value">82%</div>
                    <div class="score-label">Prompt Accuracy Score</div>
                    <div class="score-details">
                        <div class="score-metric">
                            <div class="metric-value">95%</div>
                            <div class="metric-label">Clarity</div>
                        </div>
                        <div class="score-metric">
                            <div class="metric-value">88%</div>
                            <div class="metric-label">Completeness</div>
                        </div>
                        <div class="score-metric">
                            <div class="metric-value">75%</div>
                            <div class="metric-label">Specificity</div>
                        </div>
                    </div>
                </div>

                <div class="prompt-grid">
                    <div class="prompt-section">
                        <div class="prompt-header">
                            <div class="prompt-label">Original Prompt</div>
                            <div class="prompt-tools">
                                <button class="tool-button" onclick="copyPrompt('original')" title="Copy to clipboard">
                                    📋 Copy
                                </button>
                            </div>
                        </div>
                        <textarea id="originalPrompt" class="prompt-textarea" readonly>Create a responsive navigation system with a clean, modern design. Include a logo area, main menu items, and a mobile-friendly hamburger menu. The navigation should be sticky and have smooth transitions.</textarea>
                    </div>

                    <div class="prompt-section">
                        <div class="prompt-header">
                            <div class="prompt-label">Suggested Improved Prompt</div>
                            <div class="prompt-tools">
                                <button class="tool-button" onclick="copyPrompt('suggested')" title="Copy to clipboard">
                                    📋 Copy
                                </button>
                                <button class="tool-button" onclick="resetPrompt()" title="Reset changes">
                                    🔄 Reset
                                </button>
                            </div>
                        </div>
                        <textarea id="suggestedPrompt" class="prompt-textarea">Create a responsive navigation system with a clean, modern design. Include:
- Logo area with hover effect
- Main menu items with dropdown support
- Mobile-friendly hamburger menu with smooth animations
- Sticky positioning with shadow on scroll
- Accessibility features (ARIA labels, keyboard navigation)
- Dark/light mode toggle
- Search functionality with autocomplete
- User profile dropdown menu
- Notification badge system
- Smooth transitions and hover effects</textarea>
                        
                        <div class="action-buttons">
                            <button class="accept-button" id="acceptButton" onclick="acceptPrompt()">
                                <span>✅</span> Accept & Save
                            </button>
                        </div>

                        <div class="checkbox-container">
                            <input type="checkbox" id="applyNextPhase">
                            <label for="applyNextPhase">Apply Suggested Prompt for Next Phase</label>
                        </div>
                    </div>
                </div>

                <div class="recommendations">
                    <div class="recommendations-header">
                        <h2>AI-Detected Recommendations</h2>
                        <div class="recommendation-filters">
                            <button class="filter-button active" data-filter="all">All</button>
                            <button class="filter-button" data-filter="high">High Priority</button>
                            <button class="filter-button" data-filter="medium">Medium Priority</button>
                            <button class="filter-button" data-filter="low">Low Priority</button>
                        </div>
                    </div>
                    <ul class="recommendation-list">
                        <li class="recommendation-item" data-severity="high">
                            <span class="recommendation-severity severity-high">High</span>
                            <span class="recommendation-icon">⚠️</span>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Missing Form Validations</div>
                                <div class="recommendation-description">Add client-side validation for form inputs and implement error handling.</div>
                            </div>
                        </li>
                        <li class="recommendation-item" data-severity="medium">
                            <span class="recommendation-severity severity-medium">Medium</span>
                            <span class="recommendation-icon">🔄</span>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Unused Components</div>
                                <div class="recommendation-description">Remove unused CSS classes and JavaScript functions to improve performance.</div>
                            </div>
                        </li>
                        <li class="recommendation-item" data-severity="low">
                            <span class="recommendation-severity severity-low">Low</span>
                            <span class="recommendation-icon">📦</span>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Component Suggestions</div>
                                <div class="recommendation-description">Consider using a reusable card component for consistent styling across the application.</div>
                            </div>
                        </li>
                        <li class="recommendation-item" data-severity="medium">
                            <span class="recommendation-severity severity-medium">Medium</span>
                            <span class="recommendation-icon">🎨</span>
                            <div class="recommendation-content">
                                <div class="recommendation-title">Layout Improvements</div>
                                <div class="recommendation-description">Implement a grid system for better responsive behavior and consistent spacing.</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Copy prompt to clipboard
        function copyPrompt(type) {
            const textarea = document.getElementById(type + 'Prompt');
            navigator.clipboard.writeText(textarea.value)
                .then(() => showToast('Prompt copied to clipboard! 📋'))
                .catch(err => showToast('Failed to copy prompt 😕', 'error'));
        }

        // Reset suggested prompt
        function resetPrompt() {
            const suggestedPrompt = document.getElementById('suggestedPrompt');
            suggestedPrompt.value = document.getElementById('originalPrompt').value;
            showToast('Prompt reset to original! 🔄');
        }

        // Accept prompt
        function acceptPrompt() {
            const acceptButton = document.getElementById('acceptButton');
            acceptButton.classList.add('loading');
            acceptButton.disabled = true;

            // Simulate API call
            setTimeout(() => {
                acceptButton.classList.remove('loading');
                acceptButton.disabled = false;
                showToast('Prompt accepted and saved! ✅');
            }, 1500);
        }

        // Filter recommendations
        document.querySelectorAll('.filter-button').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.dataset.filter;
                
                // Update active state
                document.querySelectorAll('.filter-button').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                // Filter items
                document.querySelectorAll('.recommendation-item').forEach(item => {
                    if (filter === 'all' || item.dataset.severity === filter) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Toast notifications
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.textContent = message;
            
            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set active phase button
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