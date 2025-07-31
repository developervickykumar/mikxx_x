@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Template</h2>
    <form action="{{ route('table-builder.templates.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name:</label>
            <input name="name" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Template JSON:</label>
            <textarea name="template_data" class="form-control" rows="6" placeholder='{"columns":[]}'>{"columns":[]}</textarea>
        </div>
        <button class="btn btn-success">Create</button>
    </form>
</div>
@endsection
