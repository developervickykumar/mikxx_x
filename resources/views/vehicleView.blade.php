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


<div class="container my-4">
    <h2>All Vehicles</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>User ID</th>

                @php
                    $first = $vehicles->first();
                    $headers = $first ? array_keys(json_decode($first->data, true)) : [];
                @endphp

                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach

                
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
                @php
                    $data = json_decode($vehicle->data, true);
                @endphp

                <tr>
                    <td>{{ $vehicle->user->first_name ?? 'N/A' }}</td>

                    @foreach($headers as $key)
                        <td>
                            @php $value = $data[$key] ?? null; @endphp

                            @if($value)
                                {{-- Check for array --}}
                                @if(is_array(json_decode($value, true)))
                                    <ul>
                                        @foreach(json_decode($value, true) as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>

                                {{-- Image fields --}}
                                @elseif(in_array(strtolower($key), ['vehicle_images', 'brochure_upload']))
                                    <img src="{{ asset('uploads/vehicles/' . $value) }}"
                                         style="max-width: 100px; max-height: 100px;" alt="Image">

                                {{-- ID fields pointing to categories --}}
                                @elseif(str_ends_with($key, '_id') && isset($categories[$value]))
                                    <strong>{{ $categories[$value]->name }}</strong>
                                    @if($categories[$value]->child->isNotEmpty())
                                        <ul>
                                            @foreach($categories[$value]->child as $child)
                                                <li>{{ $child->name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                {{-- Default plain text --}}
                                @else
                                    {{ $value }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    @endforeach

                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="collapse"
                                data-bs-target="#details-{{ $vehicle->id }}">
                            View
                        </button>
                        <div id="details-{{ $vehicle->id }}" class="collapse mt-2">
                            <pre class="bg-light p-2">{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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