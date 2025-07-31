@extends('layouts.master')

@section('title') Choose Builder @endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Admin @endslot
    @slot('title') Choose Builder @endslot
@endcomponent

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm rounded border-0">
                <div class="card-header bg-light">
                    <h4 class="mb-0">🛠️ Choose a Builder</h4>
                </div>
                <div class="card-body">
                    @if($builders->count())
                        <div class="row">
                            @foreach($builders as $builder)
                                <div class="col-md-4 mb-4">
                                    <a href=" " class="text-decoration-none text-dark">
                                        <div class="card h-100 text-center p-3 shadow-sm border-hover" style="transition: 0.3s;">
                                            <div class="mb-2">
                                                <i class="{{ $builder->icon ?? 'dripicons-cog' }} fs-1 text-primary"></i>
                                            </div>
                                            <h5 class="mb-1">{{ $builder->name }}</h5>
                                            <p class="text-muted small mb-0">
                                                {{ $builder->description ?? 'No description available.' }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">No builders found under this category.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
