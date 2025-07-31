@extends('layouts.master')


@section('content')
<div class="container">
    <h3>{{ $category->name }}</h3>
    <div class="border p-4 mt-3">
        {!! $category->code !!}
    </div>
</div>
@endsection
