<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import HTML Template</title>
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

        .info-box {
            background: var(--card-background);
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Import Form */
        .import-form {
            background: var(--card-background);
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .form-input, .form-select {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background: var(--background-color);
        }

        /* File Upload Area */
        .file-upload {
            border: 2px dashed var(--border-color);
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            background: var(--background-color);
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-upload:hover {
            border-color: var(--primary-color);
            background: var(--hover-color);
        }

        .upload-icon {
            font-size: 2rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .upload-text {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .file-input {
            display: none;
        }

        /* Preview Box */
        .preview-box {
            background: var(--card-background);
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
            display: none;
        }

        .preview-box.active {
            display: block;
        }

        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .preview-title {
            font-size: 1.125rem;
            font-weight: 500;
        }

        .code-block {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.375rem;
            font-family: monospace;
            font-size: 0.875rem;
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-uploaded {
            background: #dcfce7;
            color: var(--success-color);
        }

        .status-parsing {
            background: #fef3c7;
            color: #d97706;
        }

        .status-error {
            background: #fee2e2;
            color: var(--danger-color);
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
                align-items: stretch;
            }

            .form-grid {
                grid-template-columns: 1fr;
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
                <a href="import-html-template.html" class="nav-link active">Import</a>
                <a href="ai-html-generator.html" class="nav-link">AI Generator</a>
                <a href="export-html-output.html" class="nav-link">Export</a>
                <a href="#" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Toolbar -->
        <div class="toolbar">
            <button class="button button-secondary" onclick="location.href='template-library.html'">Back to Library</button>
            <div class="info-box">
                Supported file types: .html | Maximum file size: 2MB
            </div>
        </div>

        <!-- Import Form -->
        <div class="import-form">
            <h2 class="form-title">Import HTML Template</h2>
            <form class="form-grid">
                <!-- File Upload Section -->
                <div class="form-group full-width">
                    <label class="form-label">HTML File</label>
                    <div class="file-upload" id="dropArea">
                        <div class="upload-icon">📁</div>
                        <div class="upload-text">Drag and drop your HTML file here or click to browse</div>
                        <input type="file" class="file-input" accept=".html" id="fileInput">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Template Name</label>
                    <input type="text" class="form-input" placeholder="Enter template name">
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-select">
                        <option value="">Select a category</option>
                        <option value="hero">Hero Sections</option>
                        <option value="form">Contact Forms</option>
                        <option value="pricing">Pricing Tables</option>
                        <option value="email">Email Layouts</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="active">Active</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <button type="submit" class="button button-primary">Import Template</button>
                </div>
            </form>
        </div>

        <!-- Preview Box -->
        <div class="preview-box" id="previewBox">
            <div class="preview-header">
                <h3 class="preview-title">Template Preview</h3>
                <div class="status-badge status-uploaded">Uploaded</div>
            </div>
            <pre class="code-block"><code>&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;title&gt;Sample Template&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Hello World&lt;/h1&gt;
    &lt;p&gt;This is a sample template.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
            <div style="margin-top: 1rem; text-align: right;">
                <button class="button button-primary" onclick="location.href='edit-html-template.html'">Edit in Builder</button>
            </div>
        </div>
    </div>

    <script>
        // File upload handling
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        const previewBox = document.getElementById('previewBox');

        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });

        // Handle drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropArea.classList.add('highlight');
        }

        function unhighlight(e) {
            dropArea.classList.remove('highlight');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type === 'text/html' || file.name.endsWith('.html')) {
                    // Show preview box
                    previewBox.classList.add('active');
                    
                    // Read file content
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const codeBlock = previewBox.querySelector('code');
                        codeBlock.textContent = e.target.result;
                    };
                    reader.readAsText(file);
                } else {
                    alert('Please upload an HTML file.');
                }
            }
        }

        // Click to upload
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });
    </script>
</body>
</html> 