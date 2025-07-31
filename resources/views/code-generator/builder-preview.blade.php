<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Preview</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation Improvements */
        .top-nav {
            background: var(--background-color);
            padding: 1rem;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border-color);
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
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            background: var(--hover-color);
            color: var(--primary-color);
        }

        .nav-link.active {
            background: var(--hover-color);
            color: var(--primary-color);
            font-weight: 500;
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

        /* Preview Controls Improvements */
        .preview-controls {
            background: var(--card-background);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 64px;
            z-index: 99;
        }

        .controls-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .template-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .template-name {
            font-size: 1.125rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .template-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            background: var(--success-color);
            color: white;
        }

        .device-toggle {
            display: flex;
            gap: 0.5rem;
            background: var(--background-color);
            padding: 0.25rem;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .device-button {
            padding: 0.5rem;
            border: none;
            background: none;
            cursor: pointer;
            border-radius: 0.25rem;
            color: var(--text-secondary);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .device-button:hover {
            background: var(--hover-color);
            color: var(--primary-color);
        }

        .device-button.active {
            background: var(--primary-color);
            color: white;
        }

        .control-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Button Improvements */
        .button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
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
        }

        .button-secondary {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .button-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Preview Area Improvements */
        .preview-container {
            flex: 1;
            position: relative;
            background: var(--background-color);
            overflow: hidden;
            transition: var(--transition);
        }

        .preview-frame {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
            transition: var(--transition);
        }

        .preview-loading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
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

        /* Responsive Design Improvements */
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

            .controls-content {
                flex-direction: column;
                align-items: stretch;
            }

            .template-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .control-actions {
                flex-direction: column;
            }

            .button {
                width: 100%;
            }

            .preview-controls {
                top: 120px;
            }
        }

        /* Device Preview Sizes */
        .preview-container.desktop .preview-frame {
            max-width: 100%;
        }

        .preview-container.tablet .preview-frame {
            max-width: 768px;
            margin: 0 auto;
            box-shadow: var(--shadow-md);
        }

        .preview-container.mobile .preview-frame {
            max-width: 375px;
            margin: 0 auto;
            box-shadow: var(--shadow-md);
        }

        /* Additional Features */
        .preview-actions {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            display: flex;
            gap: 0.5rem;
            z-index: 90;
        }

        .preview-action-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .preview-action-button:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
        }

        .preview-action-button.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
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
                <a href="ai-html-generator.html" class="nav-link">AI Generator</a>
                <a href="builder-preview.html" class="nav-link active">Preview</a>
                <a href="export-html-output.html" class="nav-link">Export</a>
                <a href="#" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Top Panel: Controls -->
    <div class="preview-controls">
        <div class="controls-content">
            <div class="template-info">
                <h1 class="template-name">
                    Responsive Contact Form
                    <span class="template-status">Active</span>
                </h1>
                <div class="device-toggle">
                    <button class="device-button active" data-device="desktop" title="Desktop">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                        Desktop
                    </button>
                    <button class="device-button" data-device="tablet" title="Tablet">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                            <line x1="12" y1="18" x2="12" y2="18"/>
                        </svg>
                        Tablet
                    </button>
                    <button class="device-button" data-device="mobile" title="Mobile">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                            <line x1="12" y1="18" x2="12" y2="18"/>
                        </svg>
                        Mobile
                    </button>
                </div>
            </div>
            <div class="control-actions">
                <button class="button button-primary" onclick="location.href='edit-html-template.html'">
                    <span>✏️</span>
                    Edit Template
                </button>
                <button class="button button-secondary" onclick="downloadHTML()">
                    <span>⬇️</span>
                    Download HTML
                </button>
                <button class="button button-secondary" onclick="location.href='template-library.html'">
                    <span>←</span>
                    Back to Library
                </button>
            </div>
        </div>
    </div>

    <!-- Live Preview Area -->
    <div class="preview-container desktop">
        <div class="preview-loading" id="previewLoading">
            <div class="loading-spinner"></div>
        </div>
        <iframe id="preview-frame" class="preview-frame" sandbox="allow-scripts"></iframe>
    </div>

    <!-- Preview Action Buttons -->
    <div class="preview-actions">
        <button class="preview-action-button" onclick="toggleFullscreen()" title="Toggle Fullscreen">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
            </svg>
        </button>
        <button class="preview-action-button" onclick="refreshPreview()" title="Refresh Preview">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M23 4v6h-6M1 20v-6h6"/>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </svg>
        </button>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Sample HTML content for preview
        const sampleHTML = `
            <div style="max-width: 800px; margin: 2rem auto; padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h1 style="color: #2563eb; margin-bottom: 1.5rem;">Contact Us</h1>
                <form style="display: grid; gap: 1.5rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; color: #1f2937;">Name</label>
                        <input type="text" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; color: #1f2937;">Email</label>
                        <input type="email" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; color: #1f2937;">Message</label>
                        <textarea style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; min-height: 150px;"></textarea>
                    </div>
                    <button style="background: #2563eb; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer;">Send Message</button>
                </form>
            </div>
        `;

        // Initialize preview
        async function initPreview() {
            const preview = document.getElementById('preview-frame');
            const previewDoc = preview.contentDocument || preview.contentWindow.document;
            
            showLoading(true);
            
            try {
                previewDoc.open();
                previewDoc.write(sampleHTML);
                previewDoc.close();
                
                // Wait for iframe to load
                await new Promise(resolve => {
                    preview.onload = resolve;
                });
                
                showToast('Preview loaded successfully');
            } catch (error) {
                showToast('Failed to load preview', 'error');
            } finally {
                showLoading(false);
            }
        }

        // Device preview toggle
        document.querySelectorAll('.device-button').forEach(button => {
            button.addEventListener('click', function() {
                // Update active state
                document.querySelectorAll('.device-button').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Update preview container class
                const device = this.dataset.device;
                const container = document.querySelector('.preview-container');
                container.className = `preview-container ${device}`;
                
                showToast(`Switched to ${device} view`);
            });
        });

        // Download HTML
        function downloadHTML() {
            try {
                const blob = new Blob([sampleHTML], { type: 'text/html' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'template.html';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                
                showToast('HTML file downloaded successfully');
            } catch (error) {
                showToast('Failed to download HTML file', 'error');
            }
        }

        // Toggle fullscreen
        function toggleFullscreen() {
            const container = document.querySelector('.preview-container');
            if (!document.fullscreenElement) {
                container.requestFullscreen();
                showToast('Entered fullscreen mode');
            } else {
                document.exitFullscreen();
                showToast('Exited fullscreen mode');
            }
        }

        // Refresh preview
        function refreshPreview() {
            initPreview();
            showToast('Preview refreshed');
        }

        // Show/hide loading state
        function showLoading(show) {
            const loading = document.getElementById('previewLoading');
            loading.style.display = show ? 'flex' : 'none';
        }

        // Toast notifications
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

        // Initialize preview on load
        document.addEventListener('DOMContentLoaded', initPreview);

        // Handle fullscreen change
        document.addEventListener('fullscreenchange', () => {
            const button = document.querySelector('.preview-action-button');
            button.classList.toggle('active', !!document.fullscreenElement);
        });
    </script>
</body>
</html> 