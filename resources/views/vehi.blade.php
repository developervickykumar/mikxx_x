@extends('layouts.master')

@section('title')
@lang('translation.Dashboard')
@endsection

@section('css')
<link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
    rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('content')

@if(session()->get('success'))
<span class="alert alert-success">
    {{session()->get('success')}}
</span>
    @endif


<div class="container my-5">
    <h2 class="mb-4 text-center">Upload Vehicle Details</h2>

    <form action="{{url('vehicleStore   ')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Dynamic Tabs -->
        <ul class="nav nav-tabs mb-3" id="formTabs" role="tablist">
            @foreach ($product as $index => $step)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $step->id }}-tab"
                    data-bs-toggle="tab" data-bs-target="#step-tab-{{$step->id}}" type="button" role="tab">
                    {{ $step->name }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="tab-content" id="formTabsContent">
     @foreach ($product as $index => $step)
    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="step-tab-{{$step->id}}" role="tabpanel">
        
        @foreach ($step->child as $item)
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">{{ $item->name }}</label>

                @php
                    $name = strtolower(trim($item->name));
                    $functionality = strtolower($item->functionality);
                    $options = $item->child ?? []; // 3rd-level options (dropdown or checkboxes)
                @endphp

                @if ($functionality == 'text')
                    <input type="text" class="form-control" name="{{ $item->name }}"
                           placeholder="Enter {{ $item->name }}">
                @elseif ($functionality == 'optional')
                    <select class="form-select" name="{{ $item->name }}_id">
                        <option value="">Select {{ $item->name }}</option>
                        @foreach ($options as $opt)
                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                @elseif ($functionality == 'checkbox')
                    @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="{{ $item->name }}[]" value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                    @endforeach
                @elseif ($functionality == 'radio')
                    @foreach (['Yes', 'No'] as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio"
                                   name="{{ $item->name }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                    @endforeach
                @elseif ($functionality == 'files')
                    <input type="file" class="form-control" name="{{ $item->name }}">
                @else
                    <input type="text" class="form-control" name="{{ $item->name }}"
                           placeholder="Enter {{ $item->name }}">
                @endif

            </div>
        </div>
        @endforeach
    </div>
@endforeach


        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">Submit Form</button>
        </div>
    </form>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Plugins js-->
<script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
</script>
<!-- dashboard init -->
<script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection