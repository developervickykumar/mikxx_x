<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Auto Code Generator - HTML to Blade</title>
    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('css/styles.css') }}" as="style">
    <link rel="preload" href="{{ asset('fonts/main-font.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('js/i18n.js') }}" as="script">
    <link rel="preload" href="{{ asset('js/analytics.js') }}" as="script">
    <link rel="preload" href="{{ asset('js/security.js') }}" as="script">
    <!-- Add security.js -->
    <script src="{{ asset('js/security.js') }}"></script>
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
            --code-bg: #1e1e1e;
            --code-text: #d4d4d4;
            --code-comment: #6a9955;
            --code-keyword: #569cd6;
            --code-string: #ce9178;
            --code-function: #dcdcaa;
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

        /* Template Selection */
        .template-selection {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .selection-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .selection-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .selection-title::before {
            content: '📝';
            font-size: 1.5rem;
        }

        .select-wrapper {
            position: relative;
            max-width: 400px;
        }

        .select-wrapper::after {
            content: '▼';
            font-size: 0.75rem;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        #templateSelect {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: var(--text-color);
            background: var(--surface-color);
            appearance: none;
            cursor: pointer;
            transition: var(--transition);
        }

        #templateSelect:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Code Output */
        .code-output {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .output-tabs {
            display: flex;
            background: var(--hover-color);
            border-bottom: 1px solid var(--border-color);
        }

        .output-tab {
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 2px solid transparent;
        }

        .output-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            background: var(--surface-color);
        }

        .output-content {
            display: none;
            padding: 1rem;
        }

        .output-content.active {
            display: block;
        }

        .code-block {
            background: var(--code-bg);
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .code-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .code-title {
            font-size: 0.875rem;
            color: var(--code-text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .code-actions {
            display: flex;
            gap: 0.5rem;
        }

        .code-button {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            color: var(--code-text);
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .code-button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        pre {
            margin: 0;
            padding: 1rem;
            overflow-x: auto;
        }

        code {
            font-family: 'Fira Code', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-controls">
            <div class="control-group">
                <button class="action-button primary" id="generateButton">
                    <span>Generate Code</span>
                </button>
                <button class="action-button secondary" id="previewButton">
                    <span>Preview</span>
                </button>
            </div>
            <div class="control-group">
                <div class="toggle-switch">
                    <input type="checkbox" id="darkModeToggle">
                    <label for="darkModeToggle">Dark Mode</label>
                </div>
            </div>
        </div>

        <div class="template-selection">
            <div class="selection-header">
                <h2 class="selection-title">Select Template</h2>
            </div>
            <div class="select-wrapper">
                <select id="templateSelect">
                    <option value="">Choose a template...</option>
                    <option value="basic">Basic Template</option>
                    <option value="advanced">Advanced Template</option>
                    <option value="custom">Custom Template</option>
                </select>
            </div>
        </div>

        <div class="code-output">
            <div class="output-tabs">
                <div class="output-tab active" data-tab="blade">Blade</div>
                <div class="output-tab" data-tab="php">PHP</div>
                <div class="output-tab" data-tab="js">JavaScript</div>
                <div class="output-tab" data-tab="css">CSS</div>
            </div>
            <div class="output-content active" id="bladeOutput">
                <div class="code-block">
                    <div class="code-header">
                        <div class="code-title">Blade Template</div>
                        <div class="code-actions">
                            <button class="code-button" id="copyBlade">Copy</button>
                            <button class="code-button" id="downloadBlade">Download</button>
                        </div>
                    </div>
                    <pre><code id="bladeCode"></code></pre>
                </div>
            </div>
            <div class="output-content" id="phpOutput">
                <div class="code-block">
                    <div class="code-header">
                        <div class="code-title">PHP Code</div>
                        <div class="code-actions">
                            <button class="code-button" id="copyPhp">Copy</button>
                            <button class="code-button" id="downloadPhp">Download</button>
                        </div>
                    </div>
                    <pre><code id="phpCode"></code></pre>
                </div>
            </div>
            <div class="output-content" id="jsOutput">
                <div class="code-block">
                    <div class="code-header">
                        <div class="code-title">JavaScript Code</div>
                        <div class="code-actions">
                            <button class="code-button" id="copyJs">Copy</button>
                            <button class="code-button" id="downloadJs">Download</button>
                        </div>
                    </div>
                    <pre><code id="jsCode"></code></pre>
                </div>
            </div>
            <div class="output-content" id="cssOutput">
                <div class="code-block">
                    <div class="code-header">
                        <div class="code-title">CSS Code</div>
                        <div class="code-actions">
                            <button class="code-button" id="copyCss">Copy</button>
                            <button class="code-button" id="downloadCss">Download</button>
                        </div>
                    </div>
                    <pre><code id="cssCode"></code></pre>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const templateSelect = document.getElementById('templateSelect');
            const outputTabs = document.querySelectorAll('.output-tab');
            const outputContents = document.querySelectorAll('.output-content');
            const generateButton = document.getElementById('generateButton');
            const previewButton = document.getElementById('previewButton');

            // Dark mode toggle
            darkModeToggle.addEventListener('change', function() {
                document.body.setAttribute('data-theme', this.checked ? 'dark' : 'light');
                localStorage.setItem('darkMode', this.checked);
            });

            // Initialize dark mode from localStorage
            if (localStorage.getItem('darkMode') === 'true') {
                darkModeToggle.checked = true;
                document.body.setAttribute('data-theme', 'dark');
            }

            // Output tabs
            outputTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabName = this.dataset.tab;
                    outputTabs.forEach(t => t.classList.remove('active'));
                    outputContents.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    document.getElementById(tabName + 'Output').classList.add('active');
                });
            });

            // Generate code
            generateButton.addEventListener('click', function() {
                const template = templateSelect.value;
                if (!template) {
                    alert('Please select a template');
                    return;
                }

                // Here you would typically make an API call to generate the code
                console.log('Generating code for template:', template);
            });

            // Preview code
            previewButton.addEventListener('click', function() {
                const template = templateSelect.value;
                if (!template) {
                    alert('Please select a template');
                    return;
                }

                // Here you would typically make an API call to preview the code
                console.log('Previewing code for template:', template);
            });

            // Copy code buttons
            document.querySelectorAll('.code-button[id^="copy"]').forEach(button => {
                button.addEventListener('click', function() {
                    const codeId = this.id.replace('copy', '').toLowerCase() + 'Code';
                    const code = document.getElementById(codeId).textContent;
                    navigator.clipboard.writeText(code).then(() => {
                        this.textContent = 'Copied!';
                        setTimeout(() => {
                            this.textContent = 'Copy';
                        }, 2000);
                    });
                });
            });

            // Download code buttons
            document.querySelectorAll('.code-button[id^="download"]').forEach(button => {
                button.addEventListener('click', function() {
                    const codeId = this.id.replace('download', '').toLowerCase() + 'Code';
                    const code = document.getElementById(codeId).textContent;
                    const blob = new Blob([code], { type: 'text/plain' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `code.${this.id.replace('download', '').toLowerCase()}`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                });
            });
        });
    </script>
    @endpush
</body>
</html> 