@extends('layouts.master')

@section('content')
<h2 class="d-flex justify-content-between align-items-center">
    <span>Template: <span id="templateTitleLabel">{{ $template->title }}</span></span>
    <button id="toggleModeBtn" class="btn btn-outline-primary btn-sm">Switch to Edit</button>
</h2>

<!-- Success message -->
@if(session('success'))
<div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<!-- View Mode -->
<div id="viewMode" class="mt-3 border p-3">
    {!! $template->html_code !!}
</div>

<!-- Edit Mode -->
<form method="POST" action="{{ route('templates.update', $template->id) }}" id="editMode" class="d-none mt-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Title:</label>
        <input type="text" name="title" class="form-control" id="templateTitleInput" value="{{ $template->title }}" required>
    </div>

    <div class="mb-3">
        <label>HTML Code:</label>
        <textarea name="html_code" rows="10" class="form-control" id="html_code" required>{{ $template->html_code }}</textarea>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">Save Template</button>
        <button type="button" class="btn btn-secondary" onclick="previewCode()">Preview</button>
    </div>
</form>

<!-- Preview -->
<h5 class="mt-4 d-none" id="previewLabel">Live Preview</h5>
<iframe id="previewFrame" class="d-none" style="width:100%; height:300px; border:1px solid #ccc;"></iframe>

 
<script>
    const toggleBtn = document.getElementById('toggleModeBtn');
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    const previewFrame = document.getElementById('previewFrame');
    const previewLabel = document.getElementById('previewLabel');

    let isEditMode = false;

    toggleBtn.addEventListener('click', () => {
        isEditMode = !isEditMode;

        if (isEditMode) {
            viewMode.classList.add('d-none');
            editMode.classList.remove('d-none');
            previewFrame.classList.remove('d-none');
            previewLabel.classList.remove('d-none');
            toggleBtn.textContent = 'Switch to View';
        } else {
            viewMode.classList.remove('d-none');
            editMode.classList.add('d-none');
            previewFrame.classList.add('d-none');
            previewLabel.classList.add('d-none');
            toggleBtn.textContent = 'Switch to Edit';
        }
    });

    function previewCode() {
        const html = document.getElementById('html_code').value;
        const doc = previewFrame.contentDocument || previewFrame.contentWindow.document;
        doc.open();
        doc.write(html);
        doc.close();
    }
</script> 

@endsection
