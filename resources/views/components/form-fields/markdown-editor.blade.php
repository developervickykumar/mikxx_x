@props(['field', 'disabled' => false])

<div class="markdown-editor-container">
    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <ul class="nav nav-tabs card-header-tabs" id="markdown-tabs-{{ $field->id }}" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="editor-tab-{{ $field->id }}" data-bs-toggle="tab" href="#editor-content-{{ $field->id }}" role="tab" aria-controls="editor" aria-selected="true">Editor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="preview-tab-{{ $field->id }}" data-bs-toggle="tab" href="#preview-content-{{ $field->id }}" role="tab" aria-controls="preview" aria-selected="false">Preview</a>
                </li>
            </ul>
            
            @if(!$disabled)
            <div class="markdown-toolbar">
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'bold')" title="Bold">
                    <i class="fas fa-bold"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'italic')" title="Italic">
                    <i class="fas fa-italic"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'heading')" title="Heading">
                    <i class="fas fa-heading"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'link')" title="Link">
                    <i class="fas fa-link"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'image')" title="Image">
                    <i class="fas fa-image"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'code')" title="Code">
                    <i class="fas fa-code"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'list-ul')" title="Unordered List">
                    <i class="fas fa-list-ul"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'list-ol')" title="Ordered List">
                    <i class="fas fa-list-ol"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'quote')" title="Quote">
                    <i class="fas fa-quote-right"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" onclick="insertMarkdown('{{ $field->id }}', 'hr')" title="Horizontal Rule">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
            @endif
        </div>
        
        <div class="card-body">
            <div class="tab-content" id="markdown-tab-content-{{ $field->id }}">
                <div class="tab-pane fade show active" id="editor-content-{{ $field->id }}" role="tabpanel" aria-labelledby="editor-tab">
                    <textarea 
                        id="markdown-textarea-{{ $field->id }}"
                        class="form-control {{ $field->input_class }}"
                        style="min-height: {{ $field->config['min_height'] ?? '300' }}px; font-family: monospace;"
                        @if($disabled) disabled @endif
                        onkeyup="updatePreview('{{ $field->id }}')"
                        placeholder="{{ $field->placeholder ?? 'Write your markdown here...' }}"
                        @if($field->required) required @endif
                    >{{ old('field.' . $field->id, $field->default_value) }}</textarea>
                </div>
                <div class="tab-pane fade" id="preview-content-{{ $field->id }}" role="tabpanel" aria-labelledby="preview-tab">
                    <div id="markdown-preview-{{ $field->id }}" class="markdown-preview"></div>
                </div>
            </div>
        </div>
    </div>
    
    <input 
        type="hidden"
        id="field-{{ $field->id }}"
        name="field[{{ $field->id }}]"
        value="{{ old('field.' . $field->id, $field->default_value) }}"
        @if($field->required) required @endif
        data-field-name="{{ $field->name }}"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    
    @if($field->help_text)
        <small class="form-text text-muted mt-2">{{ $field->help_text }}</small>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initMarkdownEditor('{{ $field->id }}');
});

function initMarkdownEditor(fieldId) {
    const textarea = document.getElementById(`markdown-textarea-${fieldId}`);
    const hiddenInput = document.getElementById(`field-${fieldId}`);
    const previewTab = document.getElementById(`preview-tab-${fieldId}`);
    
    // Initial preview update
    updatePreview(fieldId);
    
    // Update preview when switching to preview tab
    if (previewTab) {
        previewTab.addEventListener('click', function() {
            updatePreview(fieldId);
        });
    }
    
    // Update hidden input when textarea changes
    if (textarea && hiddenInput) {
        textarea.addEventListener('input', function() {
            hiddenInput.value = textarea.value;
        });
    }
}

function updatePreview(fieldId) {
    const textarea = document.getElementById(`markdown-textarea-${fieldId}`);
    const preview = document.getElementById(`markdown-preview-${fieldId}`);
    
    if (textarea && preview) {
        // Configure marked options
        marked.setOptions({
            breaks: true,
            gfm: true,
            pedantic: false,
            sanitize: false,
            smartLists: true,
            smartypants: false
        });
        
        // Convert markdown to HTML
        preview.innerHTML = marked.parse(textarea.value);
        
        // Update hidden input
        const hiddenInput = document.getElementById(`field-${fieldId}`);
        if (hiddenInput) {
            hiddenInput.value = textarea.value;
        }
    }
}

function insertMarkdown(fieldId, type) {
    const textarea = document.getElementById(`markdown-textarea-${fieldId}`);
    if (!textarea) return;
    
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let insertText = '';
    
    switch (type) {
        case 'bold':
            insertText = `**${selectedText || 'bold text'}**`;
            break;
        case 'italic':
            insertText = `*${selectedText || 'italic text'}*`;
            break;
        case 'heading':
            insertText = `## ${selectedText || 'Heading'}`;
            break;
        case 'link':
            insertText = selectedText ? `[${selectedText}](url)` : '[link text](url)';
            break;
        case 'image':
            insertText = `![${selectedText || 'alt text'}](image-url)`;
            break;
        case 'code':
            insertText = selectedText ? `\`${selectedText}\`` : '`code`';
            break;
        case 'list-ul':
            insertText = selectedText || '- Item 1\n- Item 2\n- Item 3';
            break;
        case 'list-ol':
            insertText = selectedText || '1. Item 1\n2. Item 2\n3. Item 3';
            break;
        case 'quote':
            insertText = `> ${selectedText || 'Blockquote'}`;
            break;
        case 'hr':
            insertText = '\n---\n';
            break;
    }
    
    // Insert the markdown
    textarea.focus();
    document.execCommand('insertText', false, insertText);
    
    // Update preview and hidden input
    updatePreview(fieldId);
}
</script>

<style>
.markdown-editor-container {
    margin-bottom: 1rem;
}

.markdown-toolbar {
    display: flex;
    gap: 5px;
}

.markdown-preview {
    min-height: 300px;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background-color: #f8f9fa;
    overflow-y: auto;
}

.markdown-preview img {
    max-width: 100%;
}

.markdown-preview table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
}

.markdown-preview th,
.markdown-preview td {
    border: 1px solid #dee2e6;
    padding: 8px;
}

.markdown-preview blockquote {
    padding: 0.5rem 1rem;
    margin-left: 0;
    border-left: 3px solid #ced4da;
    color: #6c757d;
}

.markdown-preview code {
    background-color: #e9ecef;
    padding: 2px 4px;
    border-radius: 3px;
}

.markdown-preview pre {
    background-color: #e9ecef;
    padding: 1rem;
    border-radius: 4px;
    overflow-x: auto;
}
</style> 