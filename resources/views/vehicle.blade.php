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




<div class="container my-5">
    <h2 class="mb-4 text-center">Upload Vehicle Details</h2>

    <form action="" method="POST">
        @csrf

        <!-- Dynamic Tabs -->
        <ul class="nav nav-tabs mb-3" id="formTabs" role="tablist">
            @foreach ($products as $index => $step)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="{{ $step->id }}-tab"
                    data-bs-toggle="tab" data-bs-target="#step-tab-{{$step->id}}" type="button" role="tab">
                    {{ $step->name }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="tab-content" id="formTabsContent">
            @foreach ($products as $index => $step)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="step-tab-{{$step->id}}"
                role="tabpanel">
                @if ($step->id == '134227')
                @foreach ($basic as $item)
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{$item->name}}</label>

                        @php
                        $name = strtolower(trim($item->name));
                        $functionality = strtolower($item->functionality);
                        @endphp
                        @if ($functionality == 'text' && $functionality == 'text')
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">

                        @elseif ($functionality == 'optional')
                        {{-- dropdown --}}
                        @php
                        $options = [];

                        if ($name == 'brand') $options = $brand;
                        elseif ($name == 'fuel type') $options = $fuel;
                        elseif ($name == 'vehicle type') $options = $vehicleTypes;
                        elseif ($name == 'vehicle category') $options = $categories;
                        elseif ($name == 'model name') $options = $modal;
                        elseif ($name == 'variant name') $options = $variant;
                        elseif ($name == 'launch year') $options = $launch;
                        // add more mappings as needed
                        @endphp
                        <select class="form-select" name="{{ $item->name }}_id">
                            <option value="">Select {{ $item->name }}</option>

                            @foreach ($options as $opt)

                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>

                            @endforeach
                        </select>
                        @elseif ($functionality == 'radio')
                        @php
                        $options = ['Yes', 'No']; // or dynamic
                        @endphp
                        @foreach ($options as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $fieldName }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                        @endforeach

                        @elseif ($functionality == 'checkbox')
                        @php
                        $options = []; // or dynamic
                        if ($name == 'brand') $options = $brand;
                        elseif ($name == 'fuel type') $options = $fuel;
                        elseif ($name == 'vehicle type') $options = $vehicleTypes;
                        elseif ($name == 'vehicle category') $options = $categories;
                        elseif ($name == 'model name') $options = $modal;
                        elseif ($name == 'variant name') $options = $variant;
                        elseif ($name == 'launch year') $options = $launch;
                        @endphp
                        @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $item->name }}[]"
                                value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                        @endforeach

                        @else
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">
                        @endif
                    </div>
                </div>
                @endforeach
                @elseif ($step->id == '134228')
                @foreach ($specifi as $item)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{$item->name}}</label>

                        @php
                        $name = strtolower(trim($item->name));
                        $functionality = strtolower($item->functionality);
                        @endphp
                        @if ($functionality == 'text' && $functionality == 'text')
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">

                        @elseif ($functionality == 'optional')
                        {{-- dropdown --}}
                        @php
                        $options = [];

                        if ($name == 'engine') $options = $engine;
                        elseif ($name == 'performance') $options = $perfor;
                        elseif($name == 'dimensions') $options = $dimen;
                        elseif ($name == 'ceating capacity') $options = $seating;
                        elseif ($name == 'front suspension') $options = $front;
                        elseif ($name == 'brakes') $options = $brakes;
                        elseif($name == 'steering') $options = $steering;
                        elseif ($name == 'tyre size') $options = $tyre;
                        elseif ($name == 'rear suspension') $options = $rear;
                        elseif ($name == 'fuel tank capacity') $options = $fuel;
                        // add more mappings as needed
                        @endphp
                        <select class="form-select" name="{{ $item->name }}_id">
                            <option value="">Select {{ $item->name }}</option>

                            @foreach ($options as $opt)

                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>

                            @endforeach
                        </select>
                        @elseif ($functionality == 'radio')
                        @php
                        $options = ['Yes', 'No']; // or dynamic
                        @endphp
                        @foreach ($options as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item->name }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                        @endforeach

                        @elseif ($functionality == 'checkbox')
                        @php
                        $options = []; // or dynamic
                        if ($name == 'engine') $options = $engine;
                        elseif ($name == 'performance') $options = $perfor;
                        elseif($name == 'dimensions') $options = $dimen;
                        elseif ($name == 'ceating capacity') $options = $seating;
                        elseif ($name == 'front suspension') $options = $front;
                        elseif ($name == 'brakes') $options = $brakes;
                        elseif($name == 'steering') $options = $steering;
                        elseif ($name == 'tyre size') $options = $tyre;
                        elseif ($name == 'rear suspension') $options = $rear;
                        elseif ($name == 'fuel tank capacity') $options = $fuel;
                        @endphp
                        @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $item->name }}[]"
                                value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                        @endforeach

                        @else
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">
                        @endif
                    </div>

                </div>
                @endforeach
                @elseif ($step->id == '134229')
                @foreach ($feature as $item)
               <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{$item->name}}</label>

                        @php
                        $name = strtolower(trim($item->name));
                        $functionality = strtolower($item->functionality);
                        @endphp
                        @if ($functionality == 'text' && $functionality == 'text')
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">

                        @elseif ($functionality == 'optional')
                        {{-- dropdown --}}
                        @php
                        $options = [];

                        if ($name == 'safety features') $options = $safety;
                        elseif ($name == 'convenience features') $options =  $convenience;
                        elseif($name == 'infotainment') $options = $infotainment;
                        elseif ($name == 'comfort') $options = $comfort;
                       
                        // add more mappings as needed
                        @endphp
                        <select class="form-select" name="{{ $item->name }}_id">
                            <option value="">Select {{ $item->name }}</option>

                            @foreach ($options as $opt)

                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>

                            @endforeach
                        </select>
                        @elseif ($functionality == 'radio')
                        @php
                        $options = ['Yes', 'No']; // or dynamic
                        @endphp
                        @foreach ($options as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item->name }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                        @endforeach

                        @elseif ($functionality == 'checkbox')
                        @php
                        $options = []; // or dynamic
                          if ($name == 'safety features') $options = $safety;
                        elseif ($name == 'convenience features') $options = $convenience;
                        elseif($name == 'infotainment') $options = $infotainment;
                        elseif ($name == 'Comfort') $options = $comfort;
                        @endphp
                        @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $item->name }}[]"
                                value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                        @endforeach

                        @else
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">
                        @endif
                    </div>

                </div>
                @endforeach
                @elseif ($step->id == '134230')
                @foreach ($tran as $item)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{$item->name}}</label>
                     @php
                        $name = strtolower(trim($item->name));
                        $functionality = strtolower($item->functionality);
                        @endphp
                        @if ($functionality == 'text' && $functionality == 'text')
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">

                        @elseif ($functionality == 'optional')
                        {{-- dropdown --}}
                        @php
                        $options = [];

                        if ($name == 'transmission type') $options = $transmission;
                        elseif ($name == 'gear count') $options =  $gear;
                        elseif($name == 'drive type') $options = $drive ;
                     
                       
                        // add more mappings as needed
                        @endphp
                        <select class="form-select" name="{{ $item->name }}_id">
                            <option value="">Select {{ $item->name }}</option>

                            @foreach ($options as $opt)

                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>

                            @endforeach
                        </select>
                        @elseif ($functionality == 'radio')
                        @php
                        $options = ['Yes', 'No']; // or dynamic
                        @endphp
                        @foreach ($options as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item->name }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                        @endforeach

                        @elseif ($functionality == 'checkbox')
                        @php
                        $options = []; // or dynamic
                          if ($name == 'transmission type') $options = $transmission;
                        elseif ($name == 'gear count') $options =  $gear;
                        elseif($name == 'drive type') $options = $drive ;
                     
                        @endphp
                        @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $item->name }}[]"
                                value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                        @endforeach

                        @else
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">
                        @endif
                    </div>

                </div>
                @endforeach
                 @elseif ($step->id == '134231')
                @foreach ($inte as $item)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{$item->name}}</label>
                        @php
                        $name = strtolower(trim($item->name));
                        $functionality = strtolower($item->functionality);
                        @endphp
                        @if ($functionality == 'text' && $functionality == 'text')
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">

                        @elseif ($functionality == 'optional')
                        {{-- dropdown --}}
                        @php
                        $options = [];

                        if ($name == 'seat material') $options =  $seat;
                        elseif ($name == 'dashboard design') $options =  $dashboard;
                        elseif($name == 'infotainment screen size ') $options = $infotainment;
                        elseif($name == 'instrument cluster') $options = $instrument;
                        elseif($name == 'ambient lighting') $options = $ambient;
                        elseif($name == 'sunroof') $options = $sunroof;
                       
                        // add more mappings as needed
                        @endphp
                        <select class="form-select" name="{{ $item->name }}_id">
                            <option value="">Select {{ $item->name }}</option>

                            @foreach ($options as $opt)

                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>

                            @endforeach
                        </select>
                        @elseif ($functionality == 'radio')
                        @php
                        $options = ['Yes', 'No']; // or dynamic
                        @endphp
                        @foreach ($options as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item->name }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                        @endforeach

                        @elseif ($functionality == 'checkbox')
                        @php
                        $options = []; // or dynamic
                             if ($name == 'seat material') $options =  $seat;
                        elseif ($name == 'dashboard design') $options =  $dashboard;
                        elseif($name == 'infotainment screen size ') $options = $infotainment;
                        elseif($name == 'instrument cluster') $options = $instrument;
                        elseif($name == 'ambient lighting') $options = $ambient;
                        elseif($name == 'sunroof') $options = $sunroof;
                     
                        @endphp
                        @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $item->name }}[]"
                                value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                        @endforeach

                        @else
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">
                        @endif
                    </div>

                </div>
                @endforeach
                

                @elseif ($step->id == '134232')
                @foreach ($exte as $item)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{$item->name}}</label>
                        @php
                        $name = strtolower(trim($item->name));
                        $functionality = strtolower($item->functionality);
                        @endphp
                        @if ($functionality == 'text' && $functionality == 'text')
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">

                        @elseif ($functionality == 'optional')
                        {{-- dropdown --}}
                        @php
                        $options = [];

                        if ($name == 'headlamps type') $options = $headlamps;
                        elseif ($name == 'drls') $options = $drls;
                        elseif($name == 'alloy wheels') $options = $alloy;
                         elseif($name == 'fog lamps') $options = $fog;
                          elseif($name == 'roof rails') $options = $roof;
                           elseif($name == 'spoiler') $options = $spoiler;
                            elseif($name == 'ground clearance') $options = $ground;
                     
                       
                        // add more mappings as needed
                        @endphp
                        <select class="form-select" name="{{ $item->name }}_id">
                            <option value="">Select {{ $item->name }}</option>

                            @foreach ($options as $opt)

                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>

                            @endforeach
                        </select>
                        @elseif ($functionality == 'radio')
                        @php
                        $options = ['Yes', 'No']; // or dynamic
                        @endphp
                        @foreach ($options as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item->name }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                        @endforeach

                        @elseif ($functionality == 'checkbox')
                        @php
                        $options = []; // or dynamic
                          
                        if ($name == 'headlamps type') $options = $headlamps;
                        elseif ($name == 'drls') $options = $drls;
                        elseif($name == 'alloy wheels') $options = $alloy;
                         elseif($name == 'fog lamps') $options = $fog;
                          elseif($name == 'roof rails') $options = $roof;
                           elseif($name == 'spoiler') $options = $spoiler;
                            elseif($name == 'ground clearance') $options = $ground;
                     
                        @endphp
                        @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $item->name }}[]"
                                value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                        @endforeach

                        @else
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">
                        @endif
                    </div>

                </div>
                @endforeach

                @elseif ($step->id == '134233')
                @foreach ($option as $item)
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">{{$item->name}}</label>
                           @php
                        $name = strtolower(trim($item->name));
                        $functionality = strtolower($item->functionality);
                        @endphp
                        @if ($functionality == 'text' && $functionality == 'text')
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">

                         @elseif ($functionality == 'files')
                        <input type="file" class="form-control" name="{{ $item->name }}"
                            >

                        @elseif ($functionality == 'optional')
                        {{-- dropdown --}}
                        @php
                        $options = [];

                        if ($name == 'warranty (years/km)') $options =  $warranty;
                        elseif ($name == 'roadside assistance') $options = $roadside;
                        elseif($name == 'service interval') $options = $service;
                         elseif($name == 'on-road price') $options = $onRoadPrice;
                          elseif($name == 'ex-showroom price') $options = $ExShowroomPrice;
                           elseif($name == 'brochure upload') $options =  $brochure;
                            elseif($name == 'vehicle images') $options = $vehicle;
                     
                       
                        // add more mappings as needed
                        @endphp
                        <select class="form-select" name="{{ $item->name }}_id">
                            <option value="">Select {{ $item->name }}</option>

                            @foreach ($options as $opt)

                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>

                            @endforeach
                        </select>
                        @elseif ($functionality == 'radio')
                        @php
                        $options = ['Yes', 'No']; // or dynamic
                        @endphp
                        @foreach ($options as $val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item->name }}" value="{{ $val }}">
                            <label class="form-check-label">{{ $val }}</label>
                        </div>
                        @endforeach

                        @elseif ($functionality == 'checkbox')
                        @php
                        $options = []; // or dynamic
                          
                        if ($name == 'headlamps type') $options = $headlamps;
                        if ($name == 'warranty (years/km)') $options =  $warranty;
                        elseif ($name == 'roadside assistance') $options = $roadside;
                        elseif($name == 'service interval') $options = $service;
                         elseif($name == 'on-road price') $options = $onRoadPrice;
                          elseif($name == 'ex-showroom price') $options = $ExShowroomPrice;
                           elseif($name == 'brochure upload') $options =  $brochure;
                            elseif($name == 'vehicle images') $options = $vehicle;
                     
                        @endphp
                        @foreach ($options as $opt)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="{{ $item->name }}[]"
                                value="{{ $opt->name }}">
                            <label class="form-check-label">{{ $opt->name }}</label>
                        </div>
                        @endforeach

                        @else
                        <input type="text" class="form-control" name="{{ $item->name }}"
                            placeholder="Enter {{ $item->name }}">
                        @endif
                    </div>

                </div>
                @endforeach
                @else
                <p>Additional content for {{ $step->name }}</p>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">Submit Form</button>
        </div>
    </form>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabButtons = document.querySelectorAll('#formTabs button');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove all tab-pane active/show
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Remove active from all nav-links
            tabButtons.forEach(btn => btn.classList.remove('active'));

            // Add active to this tab and its content
            this.classList.add('active');
            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            target.classList.add('show', 'active');
        });
    });
});
</script>




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