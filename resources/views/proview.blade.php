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


<div class="container">
  <h2 class="text-center mb-4">Filter Vehicle Records</h2>

  {{-- Filter Dropdowns --}}
  <form method="GET" action="{{ route('prodview') }}" class="mb-4">
    <div class="row">
      {{-- Level 1 --}}
      <div class="col-md-4 mb-2">
        <label class="form-label">Product Type</label>
        <select id="level1" name="level1" class="form-select">
          <option value="">-- Select --</option>
          @foreach($productTypes as $pt)
            <option value="{{ $pt->id }}" {{ request('level1') == $pt->id ? 'selected' : '' }}>
              {{ $pt->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Level 2 --}}
      <div class="col-md-4 mb-2">
        <label class="form-label">Sub Category</label>
        <select id="level2" name="level2" class="form-select">
          <option value="">-- Select --</option>
        </select>
      </div>

      {{-- Level 3 --}}
      <div class="col-md-4 mb-2">
        <label class="form-label">Final Category</label>
        <select id="level3" name="level3" class="form-select">
          <option value="">-- Select --</option>
        </select>
      </div>
    </div>

    <div class="mt-3 text-end">
      <button class="btn btn-primary">Filter</button>
    </div>
  </form>

  {{-- Vehicle Table --}}
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>User</th>
        <th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        @foreach($headers as $header)
          <th>{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @forelse($vehicles as $vehicle)
        @php $data = json_decode($vehicle->data, true); @endphp
        <tr>
          <td>{{ $vehicle->user->name ?? 'N/A' }}</td>
          <td>{{ $categories[$vehicle->level1]->name ?? 'N/A' }}</td>
          <td>{{ $categories[$vehicle->level2]->name ?? 'N/A' }}</td>
          <td>{{ $categories[$vehicle->level3]->name ?? 'N/A' }}</td>

          @foreach($headers as $key)
            <td>
              @php $value = $data[$key] ?? null; @endphp
              @if(str_ends_with($key, '_id') && isset($categories[$value]))
                {{ $categories[$value]->name }}
              @elseif(is_array($value))
                {{ implode(', ', $value) }}
              @else
                {{ $value ?? '-' }}
              @endif
            </td>
          @endforeach
        </tr>
      @empty
        <tr><td colspan="{{ 4 + count($headers) }}" class="text-center">No records found</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<script>
  window.onload = function () {
    let level1 = document.getElementById('level1').value;
    let level2 = "{{ request('level2') }}";
    let level3 = "{{ request('level3') }}";

    if (level1) {
      fetch('/vehicle/fetch-childrenn/' + level1)
        .then(res => res.json())
        .then(data => {
          let opt = '<option value="">-- Select --</option>';
          data.forEach(d => {
            opt += `<option value="${d.id}" ${d.id == level2 ? 'selected' : ''}>${d.name}</option>`;
          });
          document.getElementById('level2').innerHTML = opt;

          if (level2) {
            fetch('/vehicle/fetch-childrenn/' + level2)
              .then(res => res.json())
              .then(subData => {
                let opt3 = '<option value="">-- Select --</option>';
                subData.forEach(d => {
                  opt3 += `<option value="${d.id}" ${d.id == level3 ? 'selected' : ''}>${d.name}</option>`;
                });
                document.getElementById('level3').innerHTML = opt3;
              });
          }
        });
    }
  };

  document.getElementById('level1').addEventListener('change', function () {
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

  document.getElementById('level2').addEventListener('change', function () {
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