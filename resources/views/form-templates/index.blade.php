@extends('layouts.master')

@section('content')
<h2>Saved Templates</h2>
<a href="{{ route('form-templates.create') }}" class="btn btn-primary mb-3">Add New Template</a>
<ul>
    @foreach($templates as $template)
        <li>
            <a href="{{ route('form-templates.show', $template->id) }}">{{ $template->title }}</a>
        </li>
    @endforeach
</ul>
@endsection
