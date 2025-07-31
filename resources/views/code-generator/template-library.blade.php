<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Template Library - Code Generator</title>
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

        /* Search and Toolbar */
        .search-toolbar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: var(--text-color);
            background: var(--surface-color);
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        /* Template Grid */
        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .template-card {
            background: var(--surface-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .template-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .template-preview {
            height: 160px;
            background: var(--hover-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .template-content {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .template-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .template-title {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-color);
            margin: 0;
        }

        .template-category {
            font-size: 0.75rem;
            color: var(--text-muted);
            background: var(--hover-color);
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
        }

        .template-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Action Buttons */
        .template-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
            flex-wrap: wrap;
        }

        .action-button {
            flex: 1;
            min-width: 60px;
            padding: 0.5rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            text-decoration: none;
        }

        .action-button.primary {
            background: var(--primary-color);
            color: white;
        }

        .action-button.secondary {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .action-button.danger {
            background: var(--error-color);
            color: white;
        }

        .action-button:hover {
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
            .template-card {
                border: 2px solid CanvasText;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .search-toolbar {
                flex-direction: column;
            }

            .search-box {
                width: 100%;
            }

            .template-grid {
                grid-template-columns: 1fr;
            }

            .template-actions {
                flex-direction: column;
            }

            .action-button {
                width: 100%;
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
                <a href="new-html-builder.html" class="action-button primary" aria-label="Create new template">
                    <span>➕</span>
                    <span>New Template</span>
                </a>
                <a href="import-html-template.html" class="action-button secondary" aria-label="Import template">
                    <span>📥</span>
                    <span>Import Template</span>
                </a>
            </div>
        </div>

        <!-- Search and Toolbar -->
        <div class="search-toolbar">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Search templates..."
                    aria-label="Search templates"
                >
            </div>
        </div>

        <!-- Template Grid -->
        <main id="main-content" class="template-grid" role="main">
            <!-- Template cards will be dynamically inserted here -->
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

        // Mock Data
        const mockTemplates = [
            {
                id: 1,
                name: 'Contact Form',
                category: 'Form',
                lastModified: '2024-03-15',
                preview: '📝'
            },
            {
                id: 2,
                name: 'Hero Section',
                category: 'Hero',
                lastModified: '2024-03-14',
                preview: '🎯'
            },
            {
                id: 3,
                name: 'Product Card',
                category: 'Card',
                lastModified: '2024-03-13',
                preview: '🛍️'
            },
            {
                id: 4,
                name: 'Navigation Bar',
                category: 'Navigation',
                lastModified: '2024-03-12',
                preview: '🧭'
            }
        ];

        // Template Management
        function createTemplateCard(template) {
            const card = document.createElement('div');
            card.className = 'template-card';
            card.innerHTML = `
                <div class="template-preview">
                    ${template.preview}
                </div>
                <div class="template-content">
                    <div class="template-header">
                        <h3 class="template-title">${template.name}</h3>
                        <span class="template-category">${template.category}</span>
                    </div>
                    <div class="template-meta">
                        Last modified: ${new Date(template.lastModified).toLocaleDateString()}
                    </div>
                    <div class="template-actions">
                        <a href="builder-preview.html?id=${template.id}" class="action-button primary" aria-label="View template">
                            <span>👁️</span>
                            <span>View</span>
                        </a>
                        <a href="edit-html-template.html?id=${template.id}" class="action-button secondary" aria-label="Edit template">
                            <span>✏️</span>
                            <span>Edit</span>
                        </a>
                        <button class="action-button secondary" onclick="cloneTemplate(${template.id})" aria-label="Clone template">
                            <span>📋</span>
                            <span>Clone</span>
                        </button>
                        <button class="action-button danger" onclick="deleteTemplate(${template.id})" aria-label="Delete template">
                            <span>🗑️</span>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            `;
            return card;
        }

        function renderTemplates(templates) {
            const grid = document.querySelector('.template-grid');
            grid.innerHTML = '';
            templates.forEach(template => {
                grid.appendChild(createTemplateCard(template));
            });
        }

        function filterTemplates(query) {
            const filtered = mockTemplates.filter(template =>
                template.name.toLowerCase().includes(query.toLowerCase()) ||
                template.category.toLowerCase().includes(query.toLowerCase())
            );
            renderTemplates(filtered);
        }

        function cloneTemplate(id) {
            const template = mockTemplates.find(t => t.id === id);
            if (template) {
                const clone = {
                    ...template,
                    id: Date.now(),
                    name: `${template.name} (Copy)`,
                    lastModified: new Date().toISOString().split('T')[0]
                };
                mockTemplates.push(clone);
                renderTemplates(mockTemplates);
                showToast('Template cloned successfully');
            }
        }

        function deleteTemplate(id) {
            const index = mockTemplates.findIndex(t => t.id === id);
            if (index !== -1) {
                mockTemplates.splice(index, 1);
                renderTemplates(mockTemplates);
                showToast('Template deleted successfully');
            }
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');

            // Initial render
            renderTemplates(mockTemplates);

            // Search functionality
            searchInput.addEventListener('input', (e) => {
                filterTemplates(e.target.value);
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