@extends('layouts.master')

@section('content')
<h2>Create Template</h2>

<form method="POST" action="{{ route('form-templates.store') }}">
    @csrf
    <div class="mb-3">
        <label>Title:</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>HTML Code:</label>
        <textarea name="html_code" rows="10" class="form-control" id="html_code" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Save Template</button>
    <button type="button" class="btn btn-secondary" onclick="previewCode()">Preview</button>
</form>

<h4 class="mt-4">Live Preview</h4>
<iframe id="previewFrame" style="width:100%; height:300px; border:1px solid #ccc;"></iframe>

<script>
function previewCode() {
    const html = document.getElementById('html_code').value;
    const iframe = document.getElementById('previewFrame');
    const doc = iframe.contentDocument || iframe.contentWindow.document;
    doc.open();
    doc.write(html);
    doc.close();
}
</script>
@endsection
