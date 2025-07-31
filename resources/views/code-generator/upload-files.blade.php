<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files for Review - Code Generator</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .upload-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            background: var(--hover-color);
            transition: all 0.2s;
        }

        .upload-area:hover {
            border-color: var(--primary-color);
            background: var(--active-color);
        }

        .file-input {
            display: none;
        }

        .upload-button {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }

        .upload-button:hover {
            background: #1d4ed8;
        }

        .prompt-area {
            margin-bottom: 2rem;
        }

        .prompt-textarea {
            width: 100%;
            min-height: 150px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 1rem;
            resize: vertical;
        }

        .file-list {
            margin-top: 2rem;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            background: white;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .file-meta {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .file-remove {
            color: #ef4444;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            font-size: 1.25rem;
        }

        .submit-button {
            background: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 1.125rem;
            width: 100%;
            margin-top: 2rem;
            transition: background 0.2s;
        }

        .submit-button:hover {
            background: #1d4ed8;
        }

        .submit-button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <div class="phase-buttons">
                <button class="phase-button active" data-phase="review">Review</button>
                <button class="phase-button" data-phase="build">Build</button>
                <button class="phase-button" data-phase="publish">Publish</button>
            </div>
        </nav>

        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <!-- Dashboard -->
            <div class="category">
                <h3 class="category-title">Dashboard</h3>
                <ul class="nav-links">
                    <li><a href="{{ route('code-generator.dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li><a href="{{ route('code-generator.module-summary') }}" class="nav-link">Module Summary</a></li>
                </ul>
            </div>

            <!-- Phase 1: Review -->
            <div class="category">
                <h3 class="category-title">Phase 1: Review</h3>
                <ul class="nav-links">
                    <li><a href="{{ route('code-generator.upload-files') }}" class="nav-link active">Upload Files</a></li>
                    <li><a href="{{ route('code-generator.prompt-review') }}" class="nav-link">Prompt Review</a></li>
                    <li><a href="{{ route('code-generator.html-analysis') }}" class="nav-link">HTML Analysis</a></li>
                    <li><a href="{{ route('code-generator.prompt-suggestion') }}" class="nav-link">Prompt Suggestion</a></li>
                    <li><a href="{{ route('code-generator.report-view') }}" class="nav-link">Report View</a></li>
                    <li><a href="{{ route('code-generator.html-vs-prompt-score') }}" class="nav-link">HTML vs Prompt Score</a></li>
                </ul>
            </div>

            <!-- Phase 2: Build -->
            <div class="category">
                <h3 class="category-title">Phase 2: Build</h3>
                <ul class="nav-links">
                    <li><a href="{{ route('code-generator.component-mapping') }}" class="nav-link">Component Mapping</a></li>
                    <li><a href="{{ route('code-generator.blade-preview') }}" class="nav-link">Blade Preview</a></li>
                    <li><a href="{{ route('code-generator.bug-fixer') }}" class="nav-link">Bug Fixer</a></li>
                    <li><a href="{{ route('code-generator.role-mapper') }}" class="nav-link">Role Mapper</a></li>
                    <li><a href="{{ route('code-generator.notification-mapper') }}" class="nav-link">Notification Mapper</a></li>
                </ul>
            </div>

            <!-- Phase 3: Publish -->
            <div class="category">
                <h3 class="category-title">Phase 3: Publish</h3>
                <ul class="nav-links">
                    <li><a href="{{ route('code-generator.final-checklist') }}" class="nav-link">Final Checklist</a></li>
                    <li><a href="{{ route('code-generator.publish-confirmation') }}" class="nav-link">Publish Confirmation</a></li>
                    <li><a href="{{ route('code-generator.publish-status') }}" class="nav-link">Publish Status</a></li>
                    <li><a href="{{ route('code-generator.publish-report') }}" class="nav-link">Publish Report</a></li>
                </ul>
            </div>

            <!-- Shared -->
            <div class="category">
                <h3 class="category-title">Shared</h3>
                <ul class="nav-links">
                    <li><a href="{{ route('code-generator.file-viewer') }}" class="nav-link">File Viewer</a></li>
                    <li><a href="{{ route('code-generator.code-diff') }}" class="nav-link">Code Diff</a></li>
                    <li><a href="{{ route('code-generator.progress-tracker') }}" class="nav-link">Progress Tracker</a></li>
                    <li><a href="{{ route('code-generator.ai-suggestion-popup') }}" class="nav-link">AI Suggestion Popup</a></li>
                    <li><a href="{{ route('code-generator.audit-logs') }}" class="nav-link">Audit Logs</a></li>
                </ul>
            </div>

            <!-- Optional -->
            <div class="category">
                <h3 class="category-title">Optional</h3>
                <ul class="nav-links">
                    <li><a href="{{ route('code-generator.user-activity-log') }}" class="nav-link">User Activity Log</a></li>
                    <li><a href="{{ route('code-generator.multi-user-collaboration') }}" class="nav-link">Multi-user Collaboration</a></li>
                    <li><a href="{{ route('code-generator.notification-center') }}" class="nav-link">Notification Center</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1 class="page-title">Upload Files for Review</h1>
            
            <div class="upload-container">
                <div class="content-section">
                    <form action="{{ route('code-generator.upload-files.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="upload-area" id="dropZone">
                            <input type="file" id="fileInput" name="files[]" class="file-input" multiple accept=".html,.css,.js">
                            <button type="button" class="upload-button" onclick="document.getElementById('fileInput').click()">
                                Select Files
                            </button>
                            <p style="margin-top: 1rem; color: #6b7280;">
                                Drag and drop files here or click to select<br>
                                Supported formats: HTML, CSS, JS
                            </p>
                        </div>

                        <div class="prompt-area">
                            <h2>Original Prompt</h2>
                            <textarea class="prompt-textarea" id="promptInput" name="prompt" placeholder="Paste or type the original prompt used to generate these files..."></textarea>
                        </div>

                        <div class="file-list" id="fileList">
                            <!-- File items will be added here dynamically -->
                        </div>

                        <button type="submit" class="submit-button" id="submitButton" disabled>
                            Submit for Review
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        const submitButton = document.getElementById('submitButton');
        const dropZone = document.getElementById('dropZone');
        const promptInput = document.getElementById('promptInput');
        let selectedFiles = new Map();

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function updateFileList() {
            fileList.innerHTML = '';
            selectedFiles.forEach((file, id) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-meta">${formatFileSize(file.size)}</div>
                    </div>
                    <button type="button" class="file-remove" onclick="removeFile('${id}')">&times;</button>
                `;
                fileList.appendChild(fileItem);
            });
            submitButton.disabled = selectedFiles.size === 0;
        }

        function removeFile(id) {
            selectedFiles.delete(id);
            updateFileList();
        }

        function handleFiles(files) {
            Array.from(files).forEach(file => {
                if (file.type.match(/^(text\/html|text\/css|application\/javascript)$/)) {
                    selectedFiles.set(crypto.randomUUID(), file);
                }
            });
            updateFileList();
        }

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--primary-color)';
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.style.borderColor = 'var(--border-color)';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--border-color)';
            handleFiles(e.dataTransfer.files);
        });

        // Set active phase button based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentRoute = '{{ Route::currentRouteName() }}';
            const phaseMap = {
                'code-generator.upload-files': 'review',
                'code-generator.prompt-review': 'review',
                'code-generator.html-analysis': 'review',
                'code-generator.prompt-suggestion': 'review',
                'code-generator.report-view': 'review',
                'code-generator.html-vs-prompt-score': 'review',
                'code-generator.component-mapping': 'build',
                'code-generator.blade-preview': 'build',
                'code-generator.bug-fixer': 'build',
                'code-generator.role-mapper': 'build',
                'code-generator.notification-mapper': 'build',
                'code-generator.final-checklist': 'publish',
                'code-generator.publish-confirmation': 'publish',
                'code-generator.publish-status': 'publish',
                'code-generator.publish-report': 'publish'
            };

            const currentPhase = phaseMap[currentRoute];
            if (currentPhase) {
                const phaseButton = document.querySelector(`[data-phase="${currentPhase}"]`);
                if (phaseButton) {
                    phaseButton.classList.add('active');
                }
            }

            // Set active nav link
            const currentNavLink = document.querySelector(`.nav-link[href*="${currentRoute}"]`);
            if (currentNavLink) {
                currentNavLink.classList.add('active');
            }
        });
    </script>
    @endpush
</body>
</html> 