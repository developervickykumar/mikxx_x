<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Content Suggestion</title>
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
            --danger-color: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            color: var(--text-color);
            background: var(--background-color);
        }

        /* Navigation */
        .top-nav {
            background: var(--background-color);
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-size: 0.875rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--hover-color);
            color: var(--primary-color);
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .toolbar-actions {
            display: flex;
            gap: 1rem;
        }

        /* Template Select Panel */
        .select-panel {
            background: var(--card-background);
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .panel-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .select-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .form-select {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background: var(--background-color);
        }

        /* Suggestion Controls */
        .suggestion-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .filter-group {
            display: flex;
            gap: 0.5rem;
        }

        .filter-button {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            background: var(--background-color);
            color: var(--text-secondary);
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-button:hover, .filter-button.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* AI Suggestion Cards */
        .suggestion-grid {
            display: grid;
            gap: 1.5rem;
        }

        .suggestion-card {
            background: var(--card-background);
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .suggestion-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .suggestion-title {
            font-size: 1.125rem;
            font-weight: 500;
        }

        .severity-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .severity-low {
            background: #dcfce7;
            color: var(--success-color);
        }

        .severity-medium {
            background: #fef3c7;
            color: var(--warning-color);
        }

        .severity-high {
            background: #fee2e2;
            color: var(--danger-color);
        }

        .suggestion-content {
            margin-bottom: 1.5rem;
        }

        .suggestion-description {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .suggestion-fix {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.375rem;
            font-family: monospace;
            font-size: 0.875rem;
            overflow-x: auto;
        }

        .suggestion-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        /* Status Message */
        .status-message {
            background: var(--card-background);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .status-icon {
            font-size: 1.5rem;
        }

        /* Buttons */
        .button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .button-primary {
            background: var(--primary-color);
            color: white;
        }

        .button-primary:hover {
            background: #1d4ed8;
        }

        .button-secondary {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .button-secondary:hover {
            background: #e2e8f0;
        }

        .button-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .button-outline:hover {
            background: var(--hover-color);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .toolbar {
                flex-direction: column;
                gap: 1rem;
            }

            .toolbar-actions {
                width: 100%;
                flex-direction: column;
            }

            .select-grid {
                grid-template-columns: 1fr;
            }

            .suggestion-controls {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-group {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-content">
            <a href="html-builder-dashboard.html" class="brand">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                HTML Builder
            </a>
            <div class="nav-links">
                <a href="html-builder-dashboard.html" class="nav-link">Dashboard</a>
                <a href="new-html-builder.html" class="nav-link">Builder</a>
                <a href="template-library.html" class="nav-link">Templates</a>
                <a href="ai-content-suggestion.html" class="nav-link active">AI Suggestions</a>
                <a href="export-html-output.html" class="nav-link">Export</a>
                <a href="#" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="toolbar-actions">
                <button class="button button-secondary" onclick="location.href='template-library.html'">Back to Library</button>
                <button class="button button-primary" onclick="location.href='edit-html-template.html'">Edit Template</button>
            </div>
            <button class="button button-outline">Download Report (PDF)</button>
        </div>

        <!-- Template Select Panel -->
        <div class="select-panel">
            <h2 class="panel-title">Select Template for AI Analysis</h2>
            <div class="select-grid">
                <div class="form-group">
                    <label class="form-label">Choose Template</label>
                    <select class="form-select">
                        <option value="">Select a template...</option>
                        <option value="hero1">Hero Section - Modern</option>
                        <option value="form1">Contact Form - Responsive</option>
                        <option value="pricing1">Pricing Table - Clean</option>
                        <option value="email1">Email Layout - Newsletter</option>
                    </select>
                </div>
                <button class="button button-primary">Analyze with AI</button>
            </div>
        </div>

        <!-- Status Message -->
        <div class="status-message">
            <span class="status-icon">🔍</span>
            <div>
                <strong>AI Analysis Complete</strong>
                <p style="color: var(--text-secondary); margin-top: 0.25rem;">3 issues found in the template</p>
            </div>
        </div>

        <!-- Suggestion Controls -->
        <div class="suggestion-controls">
            <div class="filter-group">
                <button class="filter-button active">All Suggestions</button>
                <button class="filter-button">SEO</button>
                <button class="filter-button">Accessibility</button>
                <button class="filter-button">Code Quality</button>
            </div>
        </div>

        <!-- AI Suggestion Cards -->
        <div class="suggestion-grid">
            <!-- Suggestion Card 1 -->
            <div class="suggestion-card">
                <div class="suggestion-header">
                    <h3 class="suggestion-title">Missing Alt Tags</h3>
                    <span class="severity-badge severity-high">High Priority</span>
                </div>
                <div class="suggestion-content">
                    <p class="suggestion-description">Image tags found without alt attributes. This affects accessibility and SEO.</p>
                    <div class="suggestion-fix">
                        &lt;img src="hero.jpg" alt="Hero section background image"&gt;
                    </div>
                </div>
                <div class="suggestion-actions">
                    <button class="button button-outline">Copy Fix</button>
                    <button class="button button-primary">Apply Fix</button>
                </div>
            </div>

            <!-- Suggestion Card 2 -->
            <div class="suggestion-card">
                <div class="suggestion-header">
                    <h3 class="suggestion-title">Missing Meta Description</h3>
                    <span class="severity-badge severity-medium">Medium Priority</span>
                </div>
                <div class="suggestion-content">
                    <p class="suggestion-description">No meta description found. This is important for SEO and social sharing.</p>
                    <div class="suggestion-fix">
                        &lt;meta name="description" content="Your compelling page description here"&gt;
                    </div>
                </div>
                <div class="suggestion-actions">
                    <button class="button button-outline">Copy Fix</button>
                    <button class="button button-primary">Apply Fix</button>
                </div>
            </div>

            <!-- Suggestion Card 3 -->
            <div class="suggestion-card">
                <div class="suggestion-header">
                    <h3 class="suggestion-title">Color Contrast Issue</h3>
                    <span class="severity-badge severity-low">Low Priority</span>
                </div>
                <div class="suggestion-content">
                    <p class="suggestion-description">Text color (#999999) on white background has insufficient contrast ratio.</p>
                    <div class="suggestion-fix">
                        .text-content { color: #666666; }
                    </div>
                </div>
                <div class="suggestion-actions">
                    <button class="button button-outline">Copy Fix</button>
                    <button class="button button-primary">Apply Fix</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter button handling
        document.querySelectorAll('.filter-button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.filter-button').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Copy fix to clipboard
        document.querySelectorAll('.button-outline').forEach(button => {
            button.addEventListener('click', function() {
                const fix = this.closest('.suggestion-card').querySelector('.suggestion-fix').textContent;
                navigator.clipboard.writeText(fix).then(() => {
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    setTimeout(() => {
                        this.textContent = originalText;
                    }, 2000);
                });
            });
        });
    </script>
</body>
</html> 