<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>HTML Editor - Code Generator</title>
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Editor Layout */
        .editor-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            height: calc(100vh - 120px);
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .editor-layout {
                grid-template-columns: 1fr;
                height: auto;
            }
        }

        /* Top Controls */
        .top-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
        }

        .control-group {
            display: flex;
            gap: 0.5rem;
        }

        /* Editor Panel */
        .editor-panel {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .editor-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .editor-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .editor-title::before {
            content: '📝';
            font-size: 1.2rem;
        }

        .editor-content {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        #codeEditor {
            width: 100%;
            height: 100%;
            padding: 1rem;
            border: none;
            font-family: 'Fira Code', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
            color: var(--text-color);
            background: var(--surface-color);
            resize: none;
            outline: none;
        }

        /* Preview Panel */
        .preview-panel {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .preview-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .preview-title::before {
            content: '👁️';
            font-size: 1.2rem;
        }

        .preview-content {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        #previewFrame {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }

        /* Buttons */
        .button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .button-primary {
            background: var(--primary-color);
            color: white;
        }

        .button-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .button-secondary {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .button-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
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

        /* Accessibility */
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
            .editor-panel,
            .preview-panel {
                border: 2px solid CanvasText;
            }
        }
    </style>
</head>
<body>
    <!-- Skip to main content link -->
    <a href="#main-content" class="skip-link" tabindex="0">Skip to main content</a>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer" role="alert" aria-live="polite"></div>

    <div class="container">
        <!-- Top Controls -->
        <div class="top-controls">
            <div class="control-group">
                <button id="downloadBtn" class="button button-primary" aria-label="Download HTML">
                    <span>📥</span>
                    <span>Download HTML</span>
                </button>
            </div>
            <div class="control-group">
                <button id="backBtn" class="button button-secondary" aria-label="Back to Library">
                    <span>←</span>
                    <span>Back to Library</span>
                </button>
            </div>
        </div>

        <main id="main-content" class="editor-layout" role="main">
            <!-- HTML Editor Panel -->
            <section class="editor-panel" aria-labelledby="editor-title">
                <div class="editor-header">
                    <h2 id="editor-title" class="editor-title">HTML Editor</h2>
                    <div class="control-group">
                        <button id="saveBtn" class="button button-secondary" aria-label="Save changes">
                            <span>💾</span>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>
                <div class="editor-content">
                    <textarea
                        id="codeEditor"
                        class="code-editor"
                        spellcheck="false"
                        aria-label="HTML code editor"
                    ></textarea>
                </div>
            </section>

            <!-- Live Preview Panel -->
            <section class="preview-panel" aria-labelledby="preview-title">
                <div class="preview-header">
                    <h2 id="preview-title" class="preview-title">Live Preview</h2>
                    <div class="control-group">
                        <button id="refreshBtn" class="button button-secondary" aria-label="Refresh preview">
                            <span>🔄</span>
                            <span>Refresh Preview</span>
                        </button>
                    </div>
                </div>
                <div class="preview-content">
                    <iframe id="previewFrame" title="HTML preview" sandbox="allow-same-origin"></iframe>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Theme Management
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }

        // Initialize theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            setTheme(savedTheme);
        } else if (prefersDarkScheme.matches) {
            setTheme('dark');
        }

        // Toast Notifications
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : '⚠️'}</span>
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

        // Editor Functions
        function initializeEditor() {
            const codeEditor = document.getElementById('codeEditor');
            const savedCode = localStorage.getItem('generatedHTML');
            
            if (savedCode) {
                codeEditor.value = savedCode;
                updatePreview();
            } else {
                codeEditor.value = `<!-- Your HTML code here -->
<div class="container">
    <h1>Welcome to the HTML Editor</h1>
    <p>Start editing your HTML code here...</p>
</div>`;
                updatePreview();
            }
        }

        function updatePreview() {
            const codeEditor = document.getElementById('codeEditor');
            const previewFrame = document.getElementById('previewFrame');
            const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            
            previewDoc.open();
            previewDoc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <style>
                        body { font-family: system-ui, sans-serif; line-height: 1.5; padding: 2rem; }
                    </style>
                </head>
                <body>
                    ${codeEditor.value}
                </body>
                </html>
            `);
            previewDoc.close();
        }

        function saveChanges() {
            const codeEditor = document.getElementById('codeEditor');
            localStorage.setItem('generatedHTML', codeEditor.value);
            showToast('Changes saved successfully');
        }

        function downloadHTML() {
            const codeEditor = document.getElementById('codeEditor');
            const blob = new Blob([codeEditor.value], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'generated-template.html';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            showToast('HTML file downloaded');
        }

        function goBack() {
            window.location.href = 'template-library.html';
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            const codeEditor = document.getElementById('codeEditor');
            const refreshBtn = document.getElementById('refreshBtn');
            const saveBtn = document.getElementById('saveBtn');
            const downloadBtn = document.getElementById('downloadBtn');
            const backBtn = document.getElementById('backBtn');

            // Initialize editor with saved or default content
            initializeEditor();

            // Add event listeners
            refreshBtn.addEventListener('click', updatePreview);
            saveBtn.addEventListener('click', saveChanges);
            downloadBtn.addEventListener('click', downloadHTML);
            backBtn.addEventListener('click', goBack);

            // Auto-update preview on input (with debounce)
            let debounceTimer;
            codeEditor.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(updatePreview, 500);
            });

            // Add keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    saveChanges();
                }
                if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                    e.preventDefault();
                    updatePreview();
                }
            });

            // Add keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Tab') {
                    document.body.classList.add('keyboard-navigation');
                }
            });

            document.addEventListener('mousedown', () => {
                document.body.classList.remove('keyboard-navigation');
            });
        });

        // Error Handling
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
            showToast('An error occurred. Please try again.', 'error');
        });

        window.addEventListener('unhandledrejection', function(e) {
            console.error('Unhandled promise rejection:', e.reason);
            showToast('An error occurred. Please try again.', 'error');
        });

        // Cleanup
        window.addEventListener('unload', function() {
            const highestTimeoutId = setTimeout(() => {}, 0);
            for (let i = 0; i < highestTimeoutId; i++) {
                clearTimeout(i);
            }
        });
    </script>
</body>
</html> 