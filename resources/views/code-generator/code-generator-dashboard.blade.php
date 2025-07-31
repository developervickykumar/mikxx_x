<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title data-i18n="title">Code Generator Dashboard</title>
    <!-- Preload critical assets -->
    <link rel="preload" href="styles.css" as="style">
    <link rel="preload" href="fonts/main-font.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="i18n.js" as="script">
    <link rel="preload" href="analytics.js" as="script">
    <link rel="preload" href="security.js" as="script">
    <!-- Add security.js -->
    <script src="security.js"></script>
    <!-- Add security headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    <style>
        :root {
            --primary-color: #2563eb;
            --success-color: #059669;
            --warning-color: #d97706;
            --error-color: #dc2626;
            --border-color: #e5e7eb;
            --text-color: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f8fafc;
            --surface-color: #ffffff;
            --hover-color: #f1f5f9;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --transition: all 0.2s ease-in-out;
        }

        /* Dark Mode Variables */
        [data-theme="dark"] {
            --primary-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --border-color: #374151;
            --text-color: #f3f4f6;
            --text-muted: #9ca3af;
            --bg-light: #1f2937;
            --surface-color: #111827;
            --hover-color: #374151;
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
            background: var(--bg-light);
            transition: var(--transition);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Top Navigation Improvements */
        .top-nav {
            background: var(--surface-color);
            padding: 1rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
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
            transition: var(--transition);
        }

        .brand:hover {
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .brand svg {
            width: 24px;
            height: 24px;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .quick-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            background: var(--hover-color);
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Main Content Improvements */
        .workflow-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .phase-card {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .phase-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .phase-header {
            padding: 1.5rem;
            background: var(--bg-light);
            border-bottom: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .phase-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease-out;
        }

        .phase-card:hover .phase-header::before {
            transform: scaleX(1);
        }

        .phase-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .phase-title::before {
            content: '📋';
            font-size: 1.5rem;
        }

        .phase-description {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .phase-steps {
            padding: 1rem;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            text-decoration: none;
            color: var(--text-color);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .step-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-color);
            opacity: 0;
            transition: var(--transition);
            z-index: 0;
        }

        .step-item:hover {
            background: var(--hover-color);
            transform: translateX(4px);
        }

        .step-item:hover::before {
            opacity: 0.1;
        }

        .step-item[data-status="completed"] {
            color: var(--success-color);
        }

        .step-item[data-status="pending"] {
            color: var(--text-muted);
            opacity: 0.7;
            cursor: not-allowed;
        }

        .step-item[data-status="in-progress"] {
            color: var(--primary-color);
        }

        .step-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .step-content {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .step-title {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .step-description {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            background: var(--bg-light);
            position: relative;
            z-index: 1;
            transition: var(--transition);
        }

        .status-badge.completed {
            background: #dcfce7;
            color: var(--success-color);
        }

        .status-badge.in-progress {
            background: #dbeafe;
            color: var(--primary-color);
        }

        .status-badge.pending {
            background: #f3f4f6;
            color: var(--text-muted);
        }

        .progress-bar {
            height: 0.5rem;
            background: var(--border-color);
            border-radius: 0.25rem;
            margin-top: 1rem;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-color);
            border-radius: 0.25rem;
            transition: width 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.2) 50%,
                rgba(255, 255, 255, 0.1) 100%
            );
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .progress-fill.completed {
            background: var(--success-color);
        }

        .progress-fill.in-progress {
            background: var(--primary-color);
        }

        .progress-fill.pending {
            background: var(--text-muted);
        }

        .progress-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .progress-text::before {
            content: '📊';
            font-size: 1rem;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            bottom: 1rem;
            left: 1rem;
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .theme-toggle svg {
            width: 20px;
            height: 20px;
            color: var(--text-color);
        }

        /* Loading States */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
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
            background: var(--surface-color);
            border-radius: 0.375rem;
            padding: 1rem;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease-out;
            min-width: 300px;
            border-left: 4px solid var(--primary-color);
        }

        .toast.success {
            border-left-color: var(--success-color);
        }

        .toast.error {
            border-left-color: var(--error-color);
        }

        .toast.warning {
            border-left-color: var(--warning-color);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive Design Improvements */
        @media (max-width: 1024px) {
            .workflow-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .workflow-container {
                grid-template-columns: 1fr;
            }

            .nav-content {
                flex-direction: column;
                gap: 1rem;
            }

            .quick-links {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .nav-link {
                padding: 0.75rem 1rem;
                width: 100%;
                text-align: center;
            }

            .phase-card {
                margin-bottom: 1rem;
            }

            .phase-header {
                padding: 1rem;
            }

            .phase-steps {
                padding: 0.75rem;
            }

            .step-item {
                padding: 0.75rem;
            }

            .status-badge {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }
        }

        /* Print Styles */
        @media print {
            .theme-toggle,
            .mobile-menu-button,
            .mobile-nav,
            .top-nav,
            .action-buttons {
                display: none !important;
            }

            .workflow-container {
                display: block;
                padding: 0;
            }

            .phase-card {
                break-inside: avoid;
                page-break-inside: avoid;
                margin-bottom: 2rem;
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .step-item {
                border-bottom: 1px solid #eee;
            }

            .status-badge {
                border: 1px solid currentColor;
            }

            a {
                text-decoration: none;
                color: black;
            }

            .progress-bar {
                border: 1px solid #ddd;
            }
        }

        /* Accessibility Improvements */
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }

        .focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        .focus-visible:not(:focus-visible) {
            outline: none;
        }

        /* Skip to main content link */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: var(--primary-color);
            color: white;
            padding: 8px;
            z-index: 100;
            transition: top 0.3s;
        }

        .skip-link:focus {
            top: 0;
        }

        /* High contrast mode support */
        @media (forced-colors: active) {
            .phase-card {
                border: 2px solid CanvasText;
            }
        }
    </style>
</head>
<body>
    <!-- Skip to main content link -->
    <a href="#main-content" class="skip-link" tabindex="0">Skip to main content</a>

    <!-- Theme Toggle -->
    <button class="theme-toggle" aria-label="Toggle dark mode">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
    </button>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer" role="alert" aria-live="polite"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    <!-- Top Navigation -->
    <nav class="top-nav" role="navigation" aria-label="Main navigation">
        <div class="nav-content">
            <a href="#" class="brand" aria-label="Code Generator Home">
                <svg class="step-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                Code Generator
            </a>
            <div class="quick-links" role="menubar">
                <a href="#" class="nav-link active" role="menuitem" aria-current="page">Dashboard</a>
                <a href="#" class="nav-link" role="menuitem">Modules</a>
                <a href="#" class="nav-link" role="menuitem">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" class="container" role="main">
        <div class="workflow-container">
            <!-- Phase 1: Review -->
            <section class="phase-card" aria-labelledby="phase1-title">
                <div class="phase-header">
                    <h2 id="phase1-title" class="phase-title">Phase 1: Review</h2>
                    <p class="phase-description">Upload and analyze HTML files</p>
                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-fill completed" style="width: 100%"></div>
                    </div>
                    <div class="progress-text">100% Complete</div>
                </div>
                <div class="phase-steps" role="list">
                    <a href="upload-files.html" class="step-item" data-status="completed" role="listitem" aria-label="Upload Files & Prompt - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Upload Files & Prompt</div>
                            <div class="step-description">Upload HTML files and initial prompt</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                    <a href="prompt-review.html" class="step-item" data-status="completed" role="listitem" aria-label="View Original Prompt - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">View Original Prompt</div>
                            <div class="step-description">Review the initial prompt</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                    <a href="html-analysis.html" class="step-item" data-status="completed" role="listitem" aria-label="Analyze HTML Structure - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Analyze HTML Structure</div>
                            <div class="step-description">Review HTML structure and components</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                    <a href="prompt-suggestion.html" class="step-item" data-status="completed" role="listitem" aria-label="AI Prompt Suggestion - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">AI Prompt Suggestion</div>
                            <div class="step-description">Get AI suggestions for prompt improvement</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                    <a href="report-view.html" class="step-item" data-status="completed" role="listitem" aria-label="View Review Report - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">View Review Report</div>
                            <div class="step-description">Review the analysis report</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                    <a href="html-vs-prompt-score.html" class="step-item" data-status="completed" role="listitem" aria-label="Check Prompt Accuracy Score - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Check Prompt Accuracy Score</div>
                            <div class="step-description">Review prompt accuracy metrics</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                </div>
            </section>

            <!-- Phase 2: Build -->
            <section class="phase-card" aria-labelledby="phase2-title">
                <div class="phase-header">
                    <h2 id="phase2-title" class="phase-title">Phase 2: Build</h2>
                    <p class="phase-description">Convert and optimize code</p>
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-fill in-progress" style="width: 60%"></div>
                    </div>
                    <div class="progress-text">60% Complete</div>
                </div>
                <div class="phase-steps" role="list">
                    <a href="component-mapping.html" class="step-item" data-status="completed" role="listitem" aria-label="Component Mapping - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Component Mapping</div>
                            <div class="step-description">Map HTML to Blade components</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                    <a href="blade-preview.html" class="step-item" data-status="completed" role="listitem" aria-label="Blade Preview - Completed">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Blade Preview</div>
                            <div class="step-description">Preview converted Blade templates</div>
                        </div>
                        <span class="status-badge completed" aria-label="Status: Completed">Completed</span>
                    </a>
                    <a href="bug-fixer.html" class="step-item" data-status="in-progress" role="listitem" aria-label="Bug Fixing Dashboard - In Progress">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Bug Fixing Dashboard</div>
                            <div class="step-description">Fix identified issues</div>
                        </div>
                        <span class="status-badge in-progress" aria-label="Status: In Progress">In Progress</span>
                    </a>
                    <a href="role-mapper.html" class="step-item" data-status="pending" role="listitem" aria-label="Role Assignment - Pending">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Role Assignment</div>
                            <div class="step-description">Assign user roles and permissions</div>
                        </div>
                        <span class="status-badge pending" aria-label="Status: Pending">Pending</span>
                    </a>
                    <a href="notification-mapper.html" class="step-item" data-status="pending" role="listitem" aria-label="Notification Mapper - Pending">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Notification Mapper</div>
                            <div class="step-description">Configure system notifications</div>
                        </div>
                        <span class="status-badge pending" aria-label="Status: Pending">Pending</span>
                    </a>
                </div>
            </section>

            <!-- Phase 3: Publish -->
            <section class="phase-card" aria-labelledby="phase3-title">
                <div class="phase-header">
                    <h2 id="phase3-title" class="phase-title">Phase 3: Publish</h2>
                    <p class="phase-description">Final review and deployment</p>
                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-fill pending" style="width: 0%"></div>
                    </div>
                    <div class="progress-text">0% Complete</div>
                </div>
                <div class="phase-steps" role="list">
                    <a href="final-checklist.html" class="step-item" data-status="pending" role="listitem" aria-label="Final Checklist - Pending">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Final Checklist</div>
                            <div class="step-description">Review final requirements</div>
                        </div>
                        <span class="status-badge pending" aria-label="Status: Pending">Pending</span>
                    </a>
                    <a href="publish-confirmation.html" class="step-item" data-status="pending" role="listitem" aria-label="Confirm Publish - Pending">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Confirm Publish</div>
                            <div class="step-description">Confirm deployment settings</div>
                        </div>
                        <span class="status-badge pending" aria-label="Status: Pending">Pending</span>
                    </a>
                    <a href="publish-status.html" class="step-item" data-status="pending" role="listitem" aria-label="Publish Status Dashboard - Pending">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Publish Status Dashboard</div>
                            <div class="step-description">Monitor deployment progress</div>
                        </div>
                        <span class="status-badge pending" aria-label="Status: Pending">Pending</span>
                    </a>
                    <a href="publish-report.html" class="step-item" data-status="pending" role="listitem" aria-label="Final Publish Report - Pending">
                        <svg class="step-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <div class="step-content">
                            <div class="step-title">Final Publish Report</div>
                            <div class="step-description">View deployment summary</div>
                        </div>
                        <span class="status-badge pending" aria-label="Status: Pending">Pending</span>
                    </a>
                </div>
            </section>
        </div>
    </main>

    <!-- Language Selector -->
    <div class="language-selector">
        <select id="languageSelect" aria-label="Select language"></select>
    </div>
    
    <!-- Analytics Debug Panel -->
    <div id="analytics-debug" class="analytics-debug" style="display: none;">
        <div class="analytics-header">
            <h3>Analytics Debug Panel</h3>
            <div class="analytics-controls">
                <button onclick="Analytics.setDebug(!Analytics.config.debug)">Toggle Debug</button>
                <select onchange="exportAnalyticsData(this.value)">
                    <option value="">Export Data</option>
                    <option value="json">JSON</option>
                    <option value="csv">CSV</option>
                    <option value="pdf">PDF</option>
                    <option value="xml">XML</option>
                    <option value="xlsx">XLSX</option>
                </select>
                <button onclick="document.getElementById('analytics-debug').style.display='none'">Close</button>
            </div>
        </div>
        <div class="analytics-content" id="analytics-content">
            <!-- Session Management -->
            <section>
                <h4>Session Info</h4>
                <div id="session-info"></div>
                <button onclick="resetSession()">Reset Session</button>
            </section>
            <!-- User Behavior -->
            <section>
                <h4>User Behavior</h4>
                <div id="user-behavior-info"></div>
                <svg id="behavior-chart" width="300" height="100"></svg>
            </section>
            <!-- Resource Usage -->
            <section>
                <h4>Resource Usage</h4>
                <div id="resource-usage-info"></div>
                <svg id="resource-chart" width="300" height="100"></svg>
            </section>
            <!-- Accessibility -->
            <section>
                <h4>Accessibility</h4>
                <div id="accessibility-info"></div>
            </section>
            <!-- Network -->
            <section>
                <h4>Network</h4>
                <div id="network-info"></div>
            </section>
            <!-- Custom Events -->
            <section>
                <h4>Custom Events</h4>
                <div id="custom-events-info"></div>
            </section>
        </div>
    </div>

    <!-- Analytics Section -->
    <section class="analytics-section">
        <h2>Advanced Analytics</h2>
        
        <!-- Report Builder -->
        <div class="report-builder">
            <select id="report-builder" class="report-select">
                <option value="">Select Report Type</option>
            </select>
        </div>

        <!-- Report Container -->
        <div id="report-container" class="report-container"></div>

        <!-- Analytics Charts -->
        <div class="analytics-grid">
            <!-- Funnel Analysis -->
            <div class="chart-card">
                <h3>Conversion Funnel</h3>
                <div class="chart-container">
                    <canvas id="funnel-chart"></canvas>
                </div>
            </div>

            <!-- Retention Analysis -->
            <div class="chart-card">
                <h3>User Retention</h3>
                <div class="chart-container">
                    <canvas id="retention-chart"></canvas>
                </div>
            </div>

            <!-- Heatmap Analysis -->
            <div class="chart-card">
                <h3>User Activity Heatmap</h3>
                <div class="chart-container">
                    <canvas id="heatmap-chart"></canvas>
                </div>
            </div>

            <!-- User Flow Analysis -->
            <div class="chart-card">
                <h3>User Flow</h3>
                <div class="chart-container">
                    <div id="user-flow-chart"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Auth Section -->
    <div id="auth-section" class="auth-section" style="display: none;">
        <div class="auth-container">
            <div class="auth-tabs">
                <button class="auth-tab active" data-tab="login">Login</button>
                <button class="auth-tab" data-tab="register">Register</button>
            </div>
            
            <div class="auth-content">
                <!-- Login Form -->
                <form id="login-form" class="auth-form">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <!-- Register Form -->
                <form id="register-form" class="auth-form" style="display: none;">
                    <div class="form-group">
                        <label for="register-name">Name</label>
                        <input type="text" id="register-name" required>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Password</label>
                        <input type="password" id="register-password" required>
                    </div>
                    <div class="form-group">
                        <label for="register-confirm-password">Confirm Password</label>
                        <input type="password" id="register-confirm-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>

    <!-- User Profile -->
    <div id="user-profile" class="user-profile" style="display: none;">
        <div class="profile-header">
            <img id="user-avatar" src="default-avatar.png" alt="User Avatar">
            <div class="profile-info">
                <h3 id="user-name">User Name</h3>
                <p id="user-role">Role</p>
            </div>
        </div>
        <div class="profile-actions">
            <button id="edit-profile" class="btn btn-secondary">Edit Profile</button>
            <button id="logout" class="btn btn-danger">Logout</button>
        </div>
    </div>

    <!-- Sync Status -->
    <div id="sync-status" class="sync-status">
        <div class="sync-indicator">
            <span class="sync-icon"></span>
            <span class="sync-text">Syncing...</span>
        </div>
        <div class="sync-details">
            <p>Last sync: <span id="last-sync-time">Never</span></p>
            <p>Pending changes: <span id="pending-changes-count">0</span></p>
        </div>
    </div>

    <!-- Required Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vis-network/9.1.2/vis-network.min.js"></script>
    <script src="advanced-analytics.js"></script>

    <script>
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(err => {
                        console.error('ServiceWorker registration failed:', err);
                    });
            });
        }

        // State Management
        const state = {
            currentPhase: 'review',
            phases: {
                review: {
                    completed: true,
                    progress: 100,
                    steps: [
                        { id: 'upload', status: 'completed' },
                        { id: 'prompt', status: 'completed' },
                        { id: 'analysis', status: 'completed' },
                        { id: 'suggestion', status: 'completed' },
                        { id: 'report', status: 'completed' },
                        { id: 'score', status: 'completed' }
                    ]
                },
                build: {
                    completed: false,
                    progress: 60,
                    steps: [
                        { id: 'component', status: 'completed' },
                        { id: 'preview', status: 'completed' },
                        { id: 'bug', status: 'in-progress' },
                        { id: 'role', status: 'pending' },
                        { id: 'notification', status: 'pending' }
                    ]
                },
                publish: {
                    completed: false,
                    progress: 0,
                    steps: [
                        { id: 'checklist', status: 'pending' },
                        { id: 'confirm', status: 'pending' },
                        { id: 'status', status: 'pending' },
                        { id: 'report', status: 'pending' }
                    ]
                }
            },
            notifications: [],
            offlineActions: []
        };

        // State Management Functions
        const stateManager = {
            updatePhase(phase, data) {
                state.phases[phase] = { ...state.phases[phase], ...data };
                this.updateUI();
            },

            updateStep(phase, stepId, status) {
                const step = state.phases[phase].steps.find(s => s.id === stepId);
                if (step) {
                    step.status = status;
                    this.updateProgress(phase);
                    this.updateUI();
                }
            },

            updateProgress(phase) {
                const phaseData = state.phases[phase];
                const totalSteps = phaseData.steps.length;
                const completedSteps = phaseData.steps.filter(s => s.status === 'completed').length;
                phaseData.progress = (completedSteps / totalSteps) * 100;
                phaseData.completed = completedSteps === totalSteps;
            },

            addNotification(message, type = 'info') {
                state.notifications.push({ message, type, timestamp: Date.now() });
                this.updateUI();
            },

            addOfflineAction(action) {
                state.offlineActions.push(action);
                this.updateUI();
            },

            updateUI() {
                // Update phase progress bars
                Object.entries(state.phases).forEach(([phase, data]) => {
                    const progressBar = document.querySelector(`[data-phase="${phase}"] .progress-fill`);
                    const progressText = document.querySelector(`[data-phase="${phase}"] .progress-text`);
                    if (progressBar && progressText) {
                        progressBar.style.width = `${data.progress}%`;
                        progressText.textContent = `${Math.round(data.progress)}% Complete`;
                    }
                });

                // Update step statuses
                Object.entries(state.phases).forEach(([phase, data]) => {
                    data.steps.forEach(step => {
                        const stepElement = document.querySelector(`[data-phase="${phase}"] [data-step="${step.id}"]`);
                        if (stepElement) {
                            stepElement.dataset.status = step.status;
                            const badge = stepElement.querySelector('.status-badge');
                            if (badge) {
                                badge.textContent = step.status.charAt(0).toUpperCase() + step.status.slice(1);
                                badge.className = `status-badge ${step.status}`;
                            }
                        }
                    });
                });

                // Update notifications
                const toastContainer = document.getElementById('toastContainer');
                if (toastContainer) {
                    state.notifications.forEach(notification => {
                        showToast(notification.message, notification.type);
                    });
                    state.notifications = [];
                }
            }
        };

        // Initialize state
        document.addEventListener('DOMContentLoaded', () => {
            stateManager.updateUI();
        });

        // Performance Monitoring
        const performanceMetrics = {
            startTime: performance.now(),
            measurements: {},
            mark(name) {
                this.measurements[name] = performance.now() - this.startTime;
                this.updateDisplay();
            },
            updateDisplay() {
                const metrics = document.getElementById('performanceMetrics');
                if (metrics) {
                    metrics.innerHTML = Object.entries(this.measurements)
                        .map(([name, time]) => `${name}: ${time.toFixed(2)}ms`)
                        .join('<br>');
                }
            }
        };

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });

        // Focus Management
        function trapFocus(element) {
            const focusableElements = element.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            element.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusable) {
                            e.preventDefault();
                            lastFocusable.focus();
                        }
                    } else {
                        if (document.activeElement === lastFocusable) {
                            e.preventDefault();
                            firstFocusable.focus();
                        }
                    }
                }
            });
        }

        // Toast Notifications
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>${message}</span>
            `;

            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            // Announce to screen readers
            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', 'polite');
            announcement.className = 'visually-hidden';
            announcement.textContent = message;
            document.body.appendChild(announcement);

            setTimeout(() => {
                toast.remove();
                announcement.remove();
            }, 3000);
        }

        // Error Handling
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
            showToast('An error occurred. Please try again.', 'error');
        });

        window.addEventListener('unhandledrejection', function(e) {
            console.error('Unhandled promise rejection:', e.reason);
            showToast('An error occurred. Please try again.', 'error');
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Performance monitoring
            performanceMetrics.mark('DOM Content Loaded');

            // Initialize focus management
            document.querySelectorAll('.phase-card').forEach(card => {
                trapFocus(card);
            });

            // Initialize keyboard navigation
            document.querySelectorAll('a, button').forEach(element => {
                element.addEventListener('focus', function() {
                    this.classList.add('focus-visible');
                });

                element.addEventListener('blur', function() {
                    this.classList.remove('focus-visible');
                });
            });

            // Initialize phase buttons
            document.querySelectorAll('.phase-button').forEach(button => {
                button.addEventListener('click', function() {
                    const phase = this.dataset.phase;
                    document.querySelectorAll('.phase-button').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');
                    showToast(`Switched to ${phase} phase`);
                });
            });
        });

        // Cleanup
        window.addEventListener('unload', function() {
            // Clear any pending timeouts or intervals
            const highestTimeoutId = setTimeout(() => {}, 0);
            for (let i = 0; i < highestTimeoutId; i++) {
                clearTimeout(i);
            }
        });

        // Mobile Menu Toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileNav = document.querySelector('.mobile-nav');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

        mobileMenuButton.addEventListener('click', () => {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            mobileNav.classList.toggle('active');
            document.body.style.overflow = isExpanded ? '' : 'hidden';
        });

        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileNav.classList.remove('active');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });

        // Close mobile menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileNav.classList.contains('active')) {
                mobileNav.classList.remove('active');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });

        // Close mobile menu on click outside
        mobileNav.addEventListener('click', (e) => {
            if (e.target === mobileNav) {
                mobileNav.classList.remove('active');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });

        // Security Integration
        document.addEventListener('DOMContentLoaded', () => {
            // Sanitize all user inputs
            document.querySelectorAll('input, textarea').forEach(input => {
                input.addEventListener('input', (e) => {
                    e.target.value = Security.sanitizeInput(e.target.value);
                });
            });

            // Add CSRF token to all forms
            document.querySelectorAll('form').forEach(form => {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_csrf';
                csrfInput.value = Security.csrfToken;
                form.appendChild(csrfInput);
            });

            // Rate limiting for API calls
            const apiCall = async (url, options = {}) => {
                if (!Security.rateLimiter.check('api', 10, 60000)) {
                    throw new Error('Rate limit exceeded. Please try again later.');
                }
                return fetch(url, options);
            };

            // Secure storage for user preferences
            const userPreferences = Security.secureStorage.get('userPreferences') || {};
            if (userPreferences.darkMode) {
                document.body.classList.add('dark-mode');
            }
        });

        // Initialize internationalization
        document.addEventListener('DOMContentLoaded', () => {
            // Set up language selector
            const languageSelect = document.getElementById('languageSelect');
            languageSelect.value = i18n.currentLang;
            
            languageSelect.addEventListener('change', (e) => {
                i18n.setLanguage(e.target.value);
                Analytics.trackEvent('language_change', { language: e.target.value });
            });
            
            // Set document direction based on language
            document.documentElement.dir = i18n.currentLang === 'ar' ? 'rtl' : 'ltr';
            
            // Update all translatable elements
            i18n.updateDocument();
        });
        
        // Initialize analytics debug panel
        document.addEventListener('DOMContentLoaded', () => {
            const debugPanel = document.getElementById('analytics-debug');
            const debugLog = document.getElementById('analyticsLog');
            
            // Toggle debug panel with Ctrl+Shift+D
            document.addEventListener('keydown', (e) => {
                if (e.ctrlKey && e.shiftKey && e.key === 'D') {
                    e.preventDefault();
                    debugPanel.style.display = debugPanel.style.display === 'none' ? 'block' : 'none';
                    Analytics.setDebug(debugPanel.classList.contains('visible'));
                }
            });
            
            // Log analytics events
            const originalTrackEvent = Analytics.trackEvent;
            Analytics.trackEvent = function(name, data) {
                originalTrackEvent.call(this, name, data);
                
                if (this.config.debug) {
                    const event = { name, data, timestamp: new Date().toISOString() };
                    debugLog.textContent = JSON.stringify(event, null, 2) + '\n' + debugLog.textContent;
                }
            };
        });
        
        // Track important user interactions
        document.addEventListener('click', (e) => {
            const target = e.target;
            
            // Track phase navigation
            if (target.matches('.phase-card')) {
                Analytics.trackEvent('phase_navigation', {
                    phase: target.dataset.phase,
                    action: 'click'
                });
            }
            
            // Track step completion
            if (target.matches('.step-checkbox')) {
                Analytics.trackEvent('step_completion', {
                    phase: target.closest('.phase-card').dataset.phase,
                    step: target.dataset.step,
                    completed: target.checked
                });
            }
        });
        
        // Track performance metrics
        window.addEventListener('load', () => {
            const metrics = Analytics.state.performanceMetrics;
            console.log('Performance Metrics:', metrics);
        });

        // Analytics Debug Panel Functions
        function updateAnalyticsDebug() {
            if (!Analytics.config.debug) return;

            // Update Session Info
            document.getElementById('session-info').innerHTML = `
                <div class="analytics-metric">
                    <span class="label">Session ID:</span>
                    <span class="value">${Analytics.state.sessionId}</span>
                </div>
                <div class="analytics-metric">
                    <span class="label">User ID:</span>
                    <span class="value">${Analytics.state.userId || 'Not set'}</span>
                </div>
                <div class="analytics-metric">
                    <span class="label">Last Activity:</span>
                    <span class="value">${new Date(Analytics.state.lastActivity).toLocaleTimeString()}</span>
                </div>
            `;

            // Update User Behavior
            document.getElementById('user-behavior-info').textContent = JSON.stringify(Analytics.state.userBehavior, null, 2);
            drawBehaviorChart(Analytics.state.userBehavior);

            // Update Resource Usage
            document.getElementById('resource-usage-info').textContent = JSON.stringify(Analytics.state.resourceUsage, null, 2);
            drawResourceChart(Analytics.state.resourceUsage);

            // Update Accessibility Info
            document.getElementById('accessibility-info').textContent = JSON.stringify(Analytics.state.accessibility, null, 2);

            // Update Network Info
            document.getElementById('network-info').textContent = JSON.stringify(Analytics.state.network, null, 2);

            // Update Custom Events Info
            document.getElementById('custom-events-info').textContent = JSON.stringify(Analytics.state.customEvents, null, 2);
        }

        // Update debug panel every second
        setInterval(updateAnalyticsDebug, 1000);

        // Export analytics data
        function exportAnalyticsData(format) {
            if (!format) return;
            
            try {
                const data = Analytics.exportData(format);
                const blob = new Blob([data], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `analytics-export-${new Date().toISOString()}.${format}`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            } catch (error) {
                console.error('Error exporting analytics data:', error);
                alert('Error exporting analytics data. Please try again.');
            }
        }

        // Language selector dynamic population
        function populateLanguageSelector() {
            const select = document.getElementById('languageSelect');
            select.innerHTML = '';
            I18n.getAvailableLanguages().forEach(lang => {
                const option = document.createElement('option');
                option.value = lang.code;
                option.textContent = lang.name;
                if (lang.code === I18n.currentLang) option.selected = true;
                select.appendChild(option);
            });
        }
        document.addEventListener('DOMContentLoaded', populateLanguageSelector);
        document.addEventListener('languageChanged', populateLanguageSelector);

        // Simple SVG bar chart for user behavior
        function drawBehaviorChart(data) {
            const svg = document.getElementById('behavior-chart');
            svg.innerHTML = '';
            const keys = Object.keys(data);
            const max = Math.max(...Object.values(data), 1);
            keys.forEach((k, i) => {
                const val = data[k];
                svg.innerHTML += `<rect x='${i*50+10}' y='${100-(val/max)*90}' width='30' height='${(val/max)*90}' fill='#4a90e2'/><text x='${i*50+25}' y='95' font-size='10' text-anchor='middle'>${k}</text>`;
            });
        }
        // Simple SVG bar chart for resource usage
        function drawResourceChart(data) {
            const svg = document.getElementById('resource-chart');
            svg.innerHTML = '';
            const keys = Object.keys(data);
            const max = Math.max(...Object.values(data).map(v=>typeof v==='number'?v:0), 1);
            keys.forEach((k, i) => {
                const val = typeof data[k]==='number'?data[k]:0;
                svg.innerHTML += `<rect x='${i*50+10}' y='${100-(val/max)*90}' width='30' height='${(val/max)*90}' fill='#7ed957'/><text x='${i*50+25}' y='95' font-size='10' text-anchor='middle'>${k}</text>`;
            });
        }
        // Session management
        function resetSession() {
            Analytics.state.sessionId = Analytics.generateSessionId();
            Analytics.state.lastActivity = Date.now();
            Analytics.trackEvent('session_reset');
            updateAnalyticsDebug();
        }
    </script>
</body>
</html> 