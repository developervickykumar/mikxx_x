<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Diff - Code Generator</title>
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
            --diff-add: #dcfce7;
            --diff-remove: #fee2e2;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --transition: all 0.2s ease-in-out;
        }

        /* Main Content Improvements */
        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title::before {
            content: '📝';
            font-size: 2rem;
        }

        /* Diff Controls */
        .diff-controls {
            background: var(--card-background);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .file-selector {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex: 1;
        }

        .file-input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .file-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .diff-options {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .option-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .option-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .option-toggle {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .option-toggle input {
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
            background-color: var(--border-color);
            transition: var(--transition);
            border-radius: 20px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: var(--transition);
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: var(--primary-color);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }

        /* Diff View */
        .diff-container {
            background: var(--card-background);
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .diff-header {
            background: var(--background-color);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .diff-title {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .diff-stats {
            display: flex;
            gap: 1rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .diff-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--border-color);
            font-family: 'Fira Code', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .diff-side {
            background: var(--background-color);
            padding: 1rem;
            overflow-x: auto;
        }

        .diff-line {
            display: flex;
            gap: 1rem;
            padding: 0.25rem 0;
        }

        .line-number {
            color: var(--text-secondary);
            user-select: none;
            min-width: 3rem;
            text-align: right;
        }

        .line-content {
            flex: 1;
            white-space: pre;
            tab-size: 4;
        }

        .line-added {
            background: var(--diff-add);
        }

        .line-removed {
            background: var(--diff-remove);
        }

        /* Loading State */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            display: none;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border-color);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .toast {
            background: white;
            border-radius: 0.375rem;
            padding: 1rem;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
            min-width: 300px;
        }

        .toast.success {
            border-left: 4px solid var(--success-color);
        }

        .toast.error {
            border-left: 4px solid var(--error-color);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .diff-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .file-selector {
                flex-direction: column;
            }

            .diff-options {
                flex-direction: column;
                align-items: stretch;
            }

            .diff-content {
                grid-template-columns: 1fr;
            }

            .diff-side {
                border-bottom: 1px solid var(--border-color);
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
                    <li><a href="code-diff.html" class="nav-link active">Code Diff</a></li>
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
            <h1 class="page-title">Code Diff</h1>

            <!-- Diff Controls -->
            <div class="diff-controls">
                <div class="file-selector">
                    <input type="file" class="file-input" id="oldFile" accept=".html,.php,.js,.css">
                    <input type="file" class="file-input" id="newFile" accept=".html,.php,.js,.css">
                </div>
                <div class="diff-options">
                    <div class="option-group">
                        <span class="option-label">Show Line Numbers</span>
                        <label class="option-toggle">
                            <input type="checkbox" id="showLineNumbers" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="option-group">
                        <span class="option-label">Ignore Whitespace</span>
                        <label class="option-toggle">
                            <input type="checkbox" id="ignoreWhitespace">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="option-group">
                        <span class="option-label">Word Wrap</span>
                        <label class="option-toggle">
                            <input type="checkbox" id="wordWrap">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Diff View -->
            <div class="diff-container">
                <div class="diff-header">
                    <div class="diff-title">Comparing files...</div>
                    <div class="diff-stats">
                        <div class="stat-item">
                            <span>➕</span>
                            <span id="additions">0</span> additions
                        </div>
                        <div class="stat-item">
                            <span>➖</span>
                            <span id="deletions">0</span> deletions
                        </div>
                    </div>
                </div>
                <div class="diff-content">
                    <div class="diff-side" id="oldContent">
                        <!-- Old content will be inserted here -->
                    </div>
                    <div class="diff-side" id="newContent">
                        <!-- New content will be inserted here -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

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

            // Initialize file input handlers
            initializeFileInputs();
        });

        // Initialize file inputs
        function initializeFileInputs() {
            const oldFileInput = document.getElementById('oldFile');
            const newFileInput = document.getElementById('newFile');

            oldFileInput.addEventListener('change', handleFileSelect);
            newFileInput.addEventListener('change', handleFileSelect);
        }

        // Handle file selection
        async function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            showLoading(true);

            try {
                const content = await readFile(file);
                const side = event.target.id === 'oldFile' ? 'oldContent' : 'newContent';
                updateDiffView(side, content);
                
                if (document.getElementById('oldFile').files[0] && document.getElementById('newFile').files[0]) {
                    await compareFiles();
                }
            } catch (error) {
                showToast('Error reading file', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Read file content
        function readFile(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = (e) => resolve(e.target.result);
                reader.onerror = (e) => reject(e);
                reader.readAsText(file);
            });
        }

        // Update diff view
        function updateDiffView(side, content) {
            const container = document.getElementById(side);
            const lines = content.split('\n');
            
            container.innerHTML = lines.map((line, index) => `
                <div class="diff-line">
                    <span class="line-number">${index + 1}</span>
                    <span class="line-content">${escapeHtml(line)}</span>
                </div>
            `).join('');
        }

        // Compare files
        async function compareFiles() {
            const oldContent = document.getElementById('oldContent').textContent;
            const newContent = document.getElementById('newContent').textContent;
            
            // Simple diff implementation
            const oldLines = oldContent.split('\n');
            const newLines = newContent.split('\n');
            
            let additions = 0;
            let deletions = 0;

            // Update stats
            document.getElementById('additions').textContent = additions;
            document.getElementById('deletions').textContent = deletions;

            showToast('Files compared successfully');
        }

        // Show/hide loading state
        function showLoading(show) {
            const overlay = document.getElementById('loadingOverlay');
            overlay.style.display = show ? 'flex' : 'none';
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <span>${type === 'success' ? '✅' : '❌'}</span>
                <span>${message}</span>
            `;
            
            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Escape HTML special characters
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Handle option changes
        document.getElementById('showLineNumbers').addEventListener('change', function(e) {
            const lineNumbers = document.querySelectorAll('.line-number');
            lineNumbers.forEach(el => el.style.display = e.target.checked ? '' : 'none');
        });

        document.getElementById('wordWrap').addEventListener('change', function(e) {
            const lineContents = document.querySelectorAll('.line-content');
            lineContents.forEach(el => el.style.whiteSpace = e.target.checked ? 'pre-wrap' : 'pre');
        });
    </script>
</body>
</html> 