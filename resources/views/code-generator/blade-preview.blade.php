<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blade File Preview - Code Generator</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .preview-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .file-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .file-select {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 1rem;
            background: white;
            cursor: pointer;
        }

        .file-path {
            color: #6b7280;
            font-size: 0.875rem;
            padding: 0.5rem 0;
        }

        .preview-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .preview-tab {
            padding: 0.5rem 1rem;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--text-color);
            position: relative;
        }

        .preview-tab.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        .preview-tab.active::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary-color);
        }

        .code-container {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .code-header {
            background: #1e293b;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .code-title {
            color: #e2e8f0;
            font-size: 0.875rem;
            font-family: monospace;
        }

        .code-actions {
            display: flex;
            gap: 0.5rem;
        }

        .code-button {
            padding: 0.375rem 0.75rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.75rem;
            transition: background 0.2s;
            background: #334155;
            color: #e2e8f0;
        }

        .code-button:hover {
            background: #475569;
        }

        .code-content {
            background: #0f172a;
            padding: 1rem;
            overflow-x: auto;
        }

        .code-block {
            font-family: 'Fira Code', 'Consolas', monospace;
            font-size: 0.875rem;
            line-height: 1.6;
            color: #e2e8f0;
            margin: 0;
            white-space: pre;
        }

        .code-block .keyword {
            color: #93c5fd;
        }

        .code-block .string {
            color: #86efac;
        }

        .code-block .comment {
            color: #94a3b8;
        }

        .code-block .directive {
            color: #f472b6;
        }

        .code-block .variable {
            color: #fbbf24;
        }

        .modified-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            color: #f59e0b;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }

        .modified-indicator::before {
            content: '•';
            font-size: 1.25rem;
        }

        @media (max-width: 768px) {
            .file-selector {
                flex-direction: column;
                align-items: stretch;
            }

            .code-actions {
                flex-wrap: wrap;
            }

            .code-button {
                flex: 1;
                text-align: center;
            }

            .preview-tabs {
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 0.25rem;
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
                    <li><a href="component-mapping.html" class="nav-link">Component Mapping</a></li>
                    <li><a href="blade-preview.html" class="nav-link active">Blade Preview</a></li>
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
            <h1 class="page-title">Blade File Preview</h1>
            
            <div class="preview-container">
                <div class="file-selector">
                    <select class="file-select">
                        <option value="home">home.html</option>
                        <option value="about">about.html</option>
                        <option value="contact">contact.html</option>
                        <option value="dashboard">dashboard.html</option>
                    </select>
                </div>

                <div class="file-path">
                    resources/views/pages/home.blade.php
                    <span class="modified-indicator">Modified</span>
                </div>

                <div class="preview-tabs">
                    <button class="preview-tab active">Blade View</button>
                    <button class="preview-tab">Controller Snippet</button>
                    <button class="preview-tab">HTML Comparison</button>
                </div>

                <div class="code-container">
                    <div class="code-header">
                        <div class="code-title">Blade Template</div>
                        <div class="code-actions">
                            <button class="code-button">Edit Blade</button>
                            <button class="code-button">Copy to Clipboard</button>
                            <button class="code-button">Download .blade.php</button>
                        </div>
                    </div>
                    <div class="code-content">
                        <pre class="code-block"><code>@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    @include('components.header')
    
    &lt;main class="container"&gt;
        &lt;div class="row"&gt;
            &lt;div class="col-md-8"&gt;
                @foreach($posts as $post)
                    @include('components.post-card', ['post' => $post])
                @endforeach
            &lt;/div&gt;
            
            &lt;div class="col-md-4"&gt;
                @include('components.sidebar')
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/main&gt;

    @include('components.footer')
@endsection

@push('scripts')
    &lt;script src="{{ asset('js/home.js') }}"&gt;&lt;/script&gt;
@endpush</code></pre>
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

            // Preview tabs functionality
            document.querySelectorAll('.preview-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.preview-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // File select functionality
            const fileSelect = document.querySelector('.file-select');
            const filePath = document.querySelector('.file-path');
            
            fileSelect.addEventListener('change', function() {
                const selectedFile = this.value;
                filePath.textContent = `resources/views/pages/${selectedFile}.blade.php`;
            });
        });
    </script>
</body>
</html> 