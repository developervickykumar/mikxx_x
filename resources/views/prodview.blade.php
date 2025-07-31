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


<div class="container-fluit">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <h2 class="text-center  mb-4">Filter Records</h2>
     <div class="row">
        <div class="col-lg-12  text-end mr-3">
            <a href="{{url('/product')}}" class="btn btn btn-outline-primary  text-end px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700 mt-4 ms-2">Add details</a>
        </div>
     </div>
    {{-- Filter Dropdowns --}}
    <form method="GET" action="{{ route('prodview') }}" class="mb-4">
        <div class="row ">
            {{-- Level 1 --}}
            <div class="col-md-3  mb-2 ">
                <label class="form-label">Product Type</label>
                <select id="level1" name="level1" class="form-select px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700">
                    <option value="">-- Select --</option>
                    @foreach($productTypes as $pt)
                    <option value="{{ $pt->id }}" {{ request('level1') == $pt->id ? 'selected' : '' }}>
                        {{ $pt->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Level 2 --}}
            <div class="col-md-3  mb-2">
                <label class="form-label">Sub Category</label>
                <select id="level2" name="level2" class="form-select px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700">
                    <option value="">-- Select --</option>
                </select>
            </div>

            {{-- Level 3 --}}
            <div class="col-md-3  mb-2">
                <label class="form-label">Final Category</label>
                <select id="level3" name="level3" class="form-select  px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700">
                    <option value="">-- Select --</option>
                </select>
            </div>
        

        <div class="col-md-3  px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700" style="">
            <button class="btn btn-outline-primary px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700 mt-4 " >Filter</button>
            <button type="button" class="btn btn-outline-primary px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700 mt-4 ms-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Import
        </button>
        <a href="{{route('product.export','csv')}}" class="btn btn btn-outline-primary  px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700 mt-4 ms-3"> Export</a>

        </div>
        </div>
    </form>

    <div class="mt-3 text-end ">
        <!-- Button trigger modal -->
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('import.csv') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="csv_file"  required class="form-control mb-3">
                            <button type="submit" class="btn btn-primary">Upload CSV</button>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Vehicle Table --}}
    <table class="table table table-bordered table-straiped">
        <thead>
            <tr>
                <th>User</th>
                <th>Product Type</th>
                <th>Sub Category</th>
                <th>Final Category</th>
                @php
                $allHeaders = [];
                foreach ($vehicles as $v) {
                $data = json_decode($v->data, true);
                if (is_array($data)) {
                $allHeaders = array_merge($allHeaders, array_keys($data));
                }
                }
                $headers = array_unique($allHeaders);
                @endphp

                @foreach($headers as $header)
                <th>{{ $header }}</th>
                @endforeach
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicles as $vehicle)
            @php $data = json_decode($vehicle->data, true); @endphp
            <tr>
                <td>{{ $vehicle->user->first_name ?? 'N/A' }}</td>
                <td>{{ \App\Models\Category::find($vehicle->level1)->name ?? 'N/A' }}</td>
                <td>{{ \App\Models\Category::find($vehicle->level2)->name ?? 'N/A' }}</td>
                <td>{{ \App\Models\Category::find($vehicle->level3)->name ?? 'N/A' }}</td>


                @foreach($headers as $key)
                <td>
                    @php $value = $data[$key] ?? null; @endphp

                    @if($value)
                    {{-- Check if it's a JSON array --}}
                    @php $decoded = json_decode($value, true); @endphp

                    @if(is_array($decoded))
                    <ul>
                        @foreach($decoded as $item)
                        <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                    @elseif(in_array(strtolower($key), ['vehicle_images', 'brochure_upload','upload_product_images']) &&
                    !empty($value))
                    <img src="{{ asset('uploads/vehicles/' . $value) }}" style="max-width: 100px; max-height: 100px;"
                        alt="Image">
                    @elseif(str_ends_with($key, '_id') && isset($categories[$value]))
                    <strong>{{ $categories[$value]->name }}</strong>
                    @if($categories[$value]->child->isNotEmpty())
                    <ul>
                        @foreach($categories[$value]->child as $child)
                        <li>{{ $child->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                    @else
                    {{ $value }}
                    @endif
                    @else
                    -
                    @endif

                </td>
                @endforeach

            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
     <div class="d-flex justify-content-center">
        {!! $vehicles->appends(request()->query())->links() !!}
    </div>
</div>

<script>
// On page load, fetch children for selected filters
window.onload = function() {
    let level1 = document.getElementById('level1').value;
    let level2 = "{{ request('level2') }}";
    let level3 = "{{ request('level3') }}";
    console.log(level2);
    if (level1) {
        fetch('/vehicle/fetch-childrenn/' + level1)
            .then(res => res.json())
            .then(data => {
                let opt = '<option value="">-- Select --</option>';
                data.forEach(d => {
                    opt +=
                        `<option value="${d.id}" ${d.id == level2 ? 'selected' : ''}>${d.name}</option>`;
                });
                document.getElementById('level2').innerHTML = opt;

                if (level2) {
                    fetch('/vehicle/fetch-children/' + level2)
                        .then(res => res.json())
                        .then(subData => {
                            let opt3 = '<option value="">-- Select --</option>';
                            subData.forEach(d => {
                                opt3 +=
                                    `<option value="${d.id}" ${d.id == level3 ? 'selected' : ''}>${d.name}</option>`;
                            });
                            document.getElementById('level3').innerHTML = opt3;
                        });
                }
            });
    }
};

// Dynamic chaining
document.getElementById('level1').addEventListener('change', function() {
    fetch('/vehicle/fetch-childrenn/' + this.value)
        .then(res => res.json())
        .then(data => {
            let opt = '<option value="">-- Select --</option>';
            data.forEach(d => {
                opt += `<option value="${d.id}">${d.name}</option>`;
            });
            document.getElementById('level2').innerHTML = opt;
            document.getElementById('level3').innerHTML = '<option value="">-- Select --</option>';
        });
});

document.getElementById('level2').addEventListener('change', function() {
    fetch('/vehicle/fetch-childrenn/' + this.value)
        .then(res => res.json())
        .then(data => {
            let opt = '<option value="">-- Select --</option>';
            data.forEach(d => {
                opt += `<option value="${d.id}">${d.name}</option>`;
            });
            document.getElementById('level3').innerHTML = opt;
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