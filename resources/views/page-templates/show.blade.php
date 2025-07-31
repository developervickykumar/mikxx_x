@extends('layouts.master')

@section('content')
<h2 class="d-flex justify-content-between align-items-center">
    <span>Template: <span id="templateTitleLabel">{{ $pageTemplate->title }}</span></span>
    <button id="toggleModeBtn" class="btn btn-outline-primary btn-sm">Switch to Edit</button>
</h2>

@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif


<!-- View Mode -->
<div id="viewMode" class="mt-3">
    <iframe id="liveFrame" style="width:100%; height:80vh; border:1px solid #ccc;"></iframe>
</div>

<!-- Edit Mode -->
<form method="POST" action="{{ route('page-templates.update', $pageTemplate->id) }}" id="editMode" class="d-none mt-3">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" value="{{ $pageTemplate->id }}">

    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="form-control" id="templateNameInput" value="{{ $pageTemplate->name }}" required>
    </div>

    <div class="mb-3">
        <label>HTML Code:</label>
        <textarea name="html_code" rows="12" class="form-control" id="html_code" required>{!! $pageTemplate->html_code !!}</textarea>
        </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">Save Template</button>
        <button type="button" class="btn btn-secondary" onclick="previewCode()">Preview</button>
    </div>

    <h5 class="mt-4" id="previewLabel">Live Preview</h5>
    <iframe id="previewFrame" style="width:100%; height:80vh; border:1px solid #ccc;"></iframe>
</form>

<script>
    const toggleBtn = document.getElementById('toggleModeBtn');
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    const previewFrame = document.getElementById('previewFrame');
    const liveFrame = document.getElementById('liveFrame');
    const previewLabel = document.getElementById('previewLabel');
    const htmlTextarea = document.getElementById('html_code');

    let isEditMode = false;

    function renderIframeContent(escapedHTML, targetFrame) {
    const doc = targetFrame.contentDocument || targetFrame.contentWindow.document;

    // Decode from escaped to usable HTML
    const textarea = document.createElement('textarea');
    textarea.innerHTML = escapedHTML;
    const unescapedHTML = textarea.value;

    doc.open();
    doc.write(unescapedHTML);
    doc.close();
}


    // Load initial preview
    window.addEventListener('DOMContentLoaded', () => {
    const html = document.getElementById('html_code').value;
    renderIframeContent(html, document.getElementById('liveFrame'));
});


    toggleBtn.addEventListener('click', () => {
        isEditMode = !isEditMode;

        if (isEditMode) {
            viewMode.classList.add('d-none');
            editMode.classList.remove('d-none');
            toggleBtn.textContent = 'Switch to View';
        } else {
            const currentHTML = htmlTextarea.value;
            renderIframeContent(currentHTML, liveFrame);
            viewMode.classList.remove('d-none');
            editMode.classList.add('d-none');
            toggleBtn.textContent = 'Switch to Edit';
        }
    });

    function previewCode() {
        const html = htmlTextarea.value;
        renderIframeContent(html, previewFrame);
    }
</script>
@endsection
