<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Publish to Phase - Code Generator</title>
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
            max-width: 800px;
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

        /* Form Card */
        .form-card {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title::before {
            font-size: 1.2rem;
        }

        /* Template Selector */
        .template-selector .section-title::before {
            content: '📝';
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

        #templateDropdown {
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

        #templateDropdown:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .status-badge.draft {
            background: var(--warning-color);
            color: white;
        }

        .status-badge.reviewed {
            background: var(--success-color);
            color: white;
        }

        /* Phase Options */
        .phase-options .section-title::before {
            content: '🔄';
        }

        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .radio-option input[type="radio"] {
            width: 1rem;
            height: 1rem;
            cursor: pointer;
        }

        .radio-option label {
            font-size: 0.875rem;
            color: var(--text-color);
            cursor: pointer;
        }

        .remarks-section .section-title::before {
            content: '💭';
        }

        #remarks {
            width: 100%;
            min-height: 100px;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: var(--text-color);
            background: var(--surface-color);
            resize: vertical;
            transition: var(--transition);
        }

        #remarks:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
                <button class="action-button primary" id="publishButton">
                    <span>Publish to Phase</span>
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

        <form id="publishForm" class="form-card">
            @csrf
            <div class="form-section template-selector">
                <h2 class="section-title">Select Template</h2>
                <div class="select-wrapper">
                    <select id="templateDropdown" name="template">
                        <option value="">Choose a template...</option>
                        <option value="basic">Basic Template</option>
                        <option value="advanced">Advanced Template</option>
                        <option value="custom">Custom Template</option>
                    </select>
                </div>
                <div class="status-badge draft">Draft</div>
            </div>

            <div class="form-section phase-options">
                <h2 class="section-title">Select Phase</h2>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="phase1" name="phase" value="phase1">
                        <label for="phase1">Phase 1 - Development</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="phase2" name="phase" value="phase2">
                        <label for="phase2">Phase 2 - Testing</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="phase3" name="phase" value="phase3">
                        <label for="phase3">Phase 3 - Production</label>
                    </div>
                </div>
            </div>

            <div class="form-section remarks-section">
                <h2 class="section-title">Remarks</h2>
                <textarea id="remarks" name="remarks" placeholder="Add any remarks or notes here..."></textarea>
            </div>

            <div class="action-buttons">
                <button type="submit" class="action-button primary">Publish</button>
                <button type="button" class="action-button secondary" id="cancelButton">Cancel</button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const publishForm = document.getElementById('publishForm');
            const templateDropdown = document.getElementById('templateDropdown');
            const publishButton = document.getElementById('publishButton');
            const previewButton = document.getElementById('previewButton');
            const cancelButton = document.getElementById('cancelButton');

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

            // Form submission
            publishForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                // Here you would typically make an API call to publish the template
                console.log('Publishing template:', Object.fromEntries(formData));
            });

            // Preview changes
            previewButton.addEventListener('click', function() {
                const template = templateDropdown.value;
                if (!template) {
                    alert('Please select a template');
                    return;
                }

                // Here you would typically make an API call to preview the changes
                console.log('Previewing changes for template:', template);
            });

            // Cancel button
            cancelButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel? All changes will be lost.')) {
                    window.location.href = '{{ route("code-generator.dashboard") }}';
                }
            });
        });
    </script>
    @endpush
</body>
</html> 