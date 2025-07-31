<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>AI HTML Generator - Code Generator</title>
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

        /* Generator Container */
        .generator-container {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 800px;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Prompt Input */
        .prompt-section {
            margin-bottom: 2rem;
        }

        .prompt-label {
            display: block;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            color: var(--text-color);
        }

        .prompt-input {
            width: 100%;
            min-height: 150px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--text-color);
            background: var(--surface-color);
            resize: vertical;
            transition: var(--transition);
        }

        .prompt-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .prompt-input::placeholder {
            color: var(--text-muted);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .action-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease-out;
        }

        .action-button:hover::before {
            transform: translateX(0);
        }

        .primary-button {
            background: var(--primary-color);
            color: white;
        }

        .primary-button:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .secondary-button {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .secondary-button:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        /* Output Section */
        .output-section {
            margin-top: 2rem;
            display: none;
        }

        .output-section.visible {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .output-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .output-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .output-title::before {
            content: '📝';
            font-size: 1.2rem;
        }

        .output-actions {
            display: flex;
            gap: 0.5rem;
        }

        .output-code {
            background: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 1rem;
            font-family: 'Fira Code', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
            color: var(--text-color);
            overflow-x: auto;
            position: relative;
        }

        .output-code::before {
            content: 'Generated HTML';
            position: absolute;
            top: -0.5rem;
            left: 1rem;
            background: var(--surface-color);
            padding: 0 0.5rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Loading State */
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .generator-container {
                padding: 1rem;
                margin: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-button {
                width: 100%;
                justify-content: center;
            }

            .output-actions {
                flex-direction: column;
                width: 100%;
            }

            .output-actions button {
                width: 100%;
            }
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
            .generator-container {
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

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    <div class="container">
        <main id="main-content" class="generator-container" role="main">
            <h1 class="page-title">AI HTML Generator</h1>
            
            <!-- Prompt Input Section -->
            <section class="prompt-section" aria-labelledby="prompt-label">
                <label id="prompt-label" class="prompt-label" for="promptInput">
                    Enter your prompt to generate HTML
                </label>
                <textarea
                    id="promptInput"
                    class="prompt-input"
                    placeholder="Describe the HTML structure you want to generate..."
                    rows="6"
                    aria-describedby="prompt-description"
                ></textarea>
                <div id="prompt-description" class="visually-hidden">
                    Enter a detailed description of the HTML structure you want to generate. Be specific about layout, components, and styling requirements.
                </div>
            </section>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button id="generateBtn" class="action-button primary-button" aria-label="Generate HTML">
                    <span>Generate HTML</span>
                </button>
            </div>

            <!-- Output Section -->
            <section id="outputSection" class="output-section" aria-labelledby="output-title">
                <div class="output-header">
                    <h2 id="output-title" class="output-title">Generated HTML</h2>
                    <div class="output-actions">
                        <button id="copyBtn" class="action-button secondary-button" aria-label="Copy to clipboard">
                            <span>Copy to Clipboard</span>
                        </button>
                        <button id="sendToEditorBtn" class="action-button secondary-button" aria-label="Send to editor">
                            <span>Send to Editor</span>
                        </button>
                    </div>
                </div>
                <pre id="outputCode" class="output-code"><code></code></pre>
            </section>
        </main>
    </div>

    <script>
        // Theme Management
        const themeToggle = document.querySelector('.theme-toggle');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
            showToast(`Switched to ${newTheme} theme`);
        }

        // Initialize theme
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            setTheme(savedTheme);
        } else if (prefersDarkScheme.matches) {
            setTheme('dark');
        }

        // Loading State Management
        function showLoading(show) {
            const overlay = document.getElementById('loadingOverlay');
            overlay.style.display = show ? 'flex' : 'none';
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

        // Mock AI Response
        function generateMockHTML(prompt) {
            // This is a mock function that would be replaced with actual AI integration
            return `<section class="hero">
    <h1>Welcome to AI Builder</h1>
    <p>This is a hero section generated from your prompt: "${prompt}"</p>
    <div class="cta-buttons">
        <button class="primary">Get Started</button>
        <button class="secondary">Learn More</button>
    </div>
</section>`;
        }

        // HTML Generation
        async function generateHTML() {
            const promptInput = document.getElementById('promptInput');
            const outputSection = document.getElementById('outputSection');
            const outputCode = document.getElementById('outputCode').querySelector('code');
            const prompt = promptInput.value.trim();

            if (!prompt) {
                showToast('Please enter a prompt', 'warning');
                return;
            }

            try {
                showLoading(true);
                
                // Simulate AI processing delay
                await new Promise(resolve => setTimeout(resolve, 2000));
                
                const generatedHTML = generateMockHTML(prompt);
                outputCode.textContent = generatedHTML;
                outputSection.classList.add('visible');
                
                showToast('HTML generated successfully');
            } catch (error) {
                console.error('Error generating HTML:', error);
                showToast('Failed to generate HTML', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Copy to Clipboard
        async function copyToClipboard() {
            const outputCode = document.getElementById('outputCode').querySelector('code');
            const text = outputCode.textContent;

            try {
                await navigator.clipboard.writeText(text);
                showToast('Copied to clipboard');
            } catch (error) {
                console.error('Error copying to clipboard:', error);
                showToast('Failed to copy to clipboard', 'error');
            }
        }

        // Send to Editor
        function sendToEditor() {
            const outputCode = document.getElementById('outputCode').querySelector('code');
            const html = outputCode.textContent;
            
            // Store the HTML in localStorage for the editor page
            localStorage.setItem('generatedHTML', html);
            
            // Redirect to the editor page
            window.location.href = 'edit-html-template.html';
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            const generateBtn = document.getElementById('generateBtn');
            const copyBtn = document.getElementById('copyBtn');
            const sendToEditorBtn = document.getElementById('sendToEditorBtn');
            const promptInput = document.getElementById('promptInput');

            generateBtn.addEventListener('click', generateHTML);
            copyBtn.addEventListener('click', copyToClipboard);
            sendToEditorBtn.addEventListener('click', sendToEditor);

            // Add keyboard shortcut for generation (Ctrl/Cmd + Enter)
            promptInput.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    generateHTML();
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