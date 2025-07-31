
@extends('layouts.master')

@section('content')
<h2>All Page Templates</h2>
<a href="{{ route('page-templates.create') }}" class="btn btn-primary mb-3">Add New Template</a>
<ul>
    @foreach($pageTemplates as $pageTemplate)
        <li>
            <a href="{{ route('page-templates.show', $pageTemplate->id) }}">{{ $pageTemplate->name }}</a>
        </li>
    @endforeach
</ul>
@endsection
