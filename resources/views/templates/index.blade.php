@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Templates</h2>
    <a href="{{ route('table-builder.templates.create') }}" class="btn btn-primary mb-3">Create New Template</a>
    <ul>
        @foreach ($templates as $template)
            <li>
                <a href="{{ route('table-builder.templates.show', $template) }}">{{ $template->name }}</a>
                (Created by: {{ $template->creator->name ?? 'N/A' }})
            </li>
        @endforeach
    </ul>
</div>
@endsection
