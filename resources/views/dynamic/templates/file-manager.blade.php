@extends('layouts.app')

@section('content')
<h2>{{ $category->name }}</h2>
<p>{{ $category->description }}</p>

@if(isset($form['form_name']))
    <div class="alert alert-info">This is linked with: {{ $form['form_name'] }}</div>
@endif

{{-- Here you can dynamically include components/forms based on category --}}
@endsection
as