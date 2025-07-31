<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Laravel Code Injector - Auto Code Implementer</title>
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

        /* File Type Tabs */
        .file-tabs {
            display: flex;
            background: var(--hover-color);
            border-radius: 0.5rem 0.5rem 0 0;
            overflow: hidden;
        }

        .file-tab {
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 2px solid transparent;
            background: var(--surface-color);
        }

        .file-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        /* File Content Section */
        .file-content {
            background: var(--surface-color);
            border-radius: 0 0 0.5rem 0.5rem;
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .file-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .file-name {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .file-name input {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: var(--text-color);
            background: var(--surface-color);
            width: 200px;
        }

        .file-name input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .file-actions {
            display: flex;
            gap: 0.5rem;
        }

        .code-editor {
            width: 100%;
            min-height: 300px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-family: 'Fira Code', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
            color: var(--text-color);
            background: var(--code-bg);
            resize: vertical;
        }

        .code-editor:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Status Box */
        .status-box {
            background: var(--surface-color);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            display: none;
        }

        .status-box.success {
            border-left: 4px solid var(--success-color);
            display: block;
        }

        .status-box.error {
            border-left: 4px solid var(--error-color);
            display: block;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
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

        .action-button.primary {
            background: var(--primary-color);
            color: white;
        }

        .action-button.secondary {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        /* Toggle Switch */
        .toggle-switch {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .toggle-switch input[type="checkbox"] {
            width: 2.5rem;
            height: 1.25rem;
            appearance: none;
            background: var(--border-color);
            border-radius: 1rem;
            position: relative;
            cursor: pointer;
            transition: var(--transition);
        }

        .toggle-switch input[type="checkbox"]:checked {
            background: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-controls">
            <div class="control-group">
                <button class="action-button primary" id="implementButton">
                    <span>Implement Code</span>
                </button>
                <button class="action-button secondary" id="previewButton">
                    <span>Preview Changes</span>
                </button>
            </div>
            <div class="control-group">
                <div class="toggle-switch">
                    <input type="checkbox" id="darkModeToggle">
                    <label for="darkModeToggle">Dark Mode</label>
                </div>
            </div>
        </div>

        <div class="file-tabs">
            <div class="file-tab active" data-file-type="blade">Blade</div>
            <div class="file-tab" data-file-type="php">PHP</div>
            <div class="file-tab" data-file-type="js">JavaScript</div>
            <div class="file-tab" data-file-type="css">CSS</div>
        </div>

        <div class="file-content">
            <div class="file-header">
                <div class="file-name">
                    <input type="text" id="fileName" placeholder="Enter file name">
                </div>
                <div class="file-actions">
                    <button class="action-button secondary" id="saveButton">
                        <span>Save</span>
                    </button>
                    <button class="action-button secondary" id="resetButton">
                        <span>Reset</span>
                    </button>
                </div>
            </div>
            <textarea class="code-editor" id="codeEditor" spellcheck="false"></textarea>
        </div>

        <div class="status-box" id="statusBox">
            <p id="statusMessage"></p>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const codeEditor = document.getElementById('codeEditor');
            const fileName = document.getElementById('fileName');
            const statusBox = document.getElementById('statusBox');
            const statusMessage = document.getElementById('statusMessage');
            const fileTabs = document.querySelectorAll('.file-tab');
            const implementButton = document.getElementById('implementButton');
            const previewButton = document.getElementById('previewButton');
            const saveButton = document.getElementById('saveButton');
            const resetButton = document.getElementById('resetButton');

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

            // File type tabs
            fileTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    fileTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    updateEditorMode(this.dataset.fileType);
                });
            });

            function updateEditorMode(fileType) {
                // Update editor mode based on file type
                // This would typically integrate with a code editor library
                console.log('Switching to', fileType, 'mode');
            }

            // Implement code
            implementButton.addEventListener('click', function() {
                const code = codeEditor.value;
                const fileType = document.querySelector('.file-tab.active').dataset.fileType;
                const name = fileName.value;

                if (!name) {
                    showStatus('Please enter a file name', 'error');
                    return;
                }

                // Here you would typically make an API call to implement the code
                console.log('Implementing code:', { name, fileType, code });
                showStatus('Code implementation started...', 'success');
            });

            // Preview changes
            previewButton.addEventListener('click', function() {
                const code = codeEditor.value;
                const fileType = document.querySelector('.file-tab.active').dataset.fileType;
                
                // Here you would typically make an API call to preview the changes
                console.log('Previewing changes:', { fileType, code });
                showStatus('Generating preview...', 'success');
            });

            // Save changes
            saveButton.addEventListener('click', function() {
                const code = codeEditor.value;
                const fileType = document.querySelector('.file-tab.active').dataset.fileType;
                const name = fileName.value;

                if (!name) {
                    showStatus('Please enter a file name', 'error');
                    return;
                }

                // Here you would typically make an API call to save the changes
                console.log('Saving changes:', { name, fileType, code });
                showStatus('Changes saved successfully', 'success');
            });

            // Reset editor
            resetButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to reset the editor? All unsaved changes will be lost.')) {
                    codeEditor.value = '';
                    fileName.value = '';
                    showStatus('Editor reset', 'success');
                }
            });

            function showStatus(message, type) {
                statusMessage.textContent = message;
                statusBox.className = 'status-box ' + type;
                setTimeout(() => {
                    statusBox.style.display = 'none';
                }, 3000);
            }
        });
    </script>
    @endpush
</body>
</html> 