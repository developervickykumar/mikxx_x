@extends('layouts.master')

@section('title', 'Export HTML - Code Generator')

@push('styles')
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
</style>
@endpush

@section('content')
<div class="container">
    @include('code-generator.partials.navigation')
    
    <main class="main-content">
        <!-- Top Controls -->
        <div class="top-controls">
            <div class="template-selector">
                <h2>Export HTML Output</h2>
                <div class="template-actions">
                    <button class="btn btn-primary" id="exportBtn">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button class="btn btn-secondary" id="previewBtn">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                </div>
            </div>
        </div>

        <!-- Code Viewer -->
        <div class="code-viewer">
            <div class="editor-container">
                <textarea id="htmlOutput" class="code-editor" readonly></textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-success" id="copyBtn">
                <i class="fas fa-copy"></i> Copy to Clipboard
            </button>
            <button class="btn btn-info" id="saveBtn">
                <i class="fas fa-save"></i> Save as Template
            </button>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Export functionality
        const exportBtn = document.getElementById('exportBtn');
        const previewBtn = document.getElementById('previewBtn');
        const copyBtn = document.getElementById('copyBtn');
        const saveBtn = document.getElementById('saveBtn');
        const htmlOutput = document.getElementById('htmlOutput');

        exportBtn.addEventListener('click', function() {
            // Export logic here
        });

        previewBtn.addEventListener('click', function() {
            // Preview logic here
        });

        copyBtn.addEventListener('click', function() {
            // Copy to clipboard logic here
        });

        saveBtn.addEventListener('click', function() {
            // Save as template logic here
        });
    });
</script>
@endpush 