@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $template->name }}</h2>
    <p>{{ $template->description }}</p>
    <pre>{{ json_encode($template->template_data, JSON_PRETTY_PRINT) }}</pre>

    <form method="POST" action="{{ route('table-builder.templates.destroy', $template) }}">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Delete Template</button>
    </form>
</div>
@endsection
