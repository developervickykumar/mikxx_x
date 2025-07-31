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

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container my-5">
  <h2 class="text-center">Upload Vehicle Details</h2>
  <form action="{{ route('vehicle.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Level 1: Product Type -->
    <div class="mb-3">
      <label>Product Type</label>
      <select id="level1" class="form-select">
        <option value="">-- Select --</option>
        @foreach($productTypes as $pt)
          <option value="{{ $pt->id }}">{{ $pt->name }}</option>
        @endforeach
      </select>
    </div>

    <!-- Level 2: Sub Category -->
    <div class="mb-3">
      <label>Sub Category</label>
      <select id="level2" class="form-select"></select>
    </div>

    <!-- Level 3: Final Category -->
    <div class="mb-3">
      <label>Final Category</label>
      <select id="level3" class="form-select"></select>
    </div>

    <!-- Level 4 Buttons -->
    <div class="mb-3" id="level4Buttons"></div>

    <!-- Level 5: Dynamic Tabs and Form -->
    <div id="dynamicForm" class="mt-4" style="display:none;">
      <ul class="nav nav-tabs" id="formTabs"></ul>
      <div class="tab-content" id="formTabsContent"></div>
    </div>

    <div class="mt-4 text-end">
      <button type="submit" class="btn btn-primary">Submit Vehicle</button>
    </div>
  </form>
</div>

<script>
function resetFrom(level){
  ['level2','level3','level4Buttons'].forEach((id, i) => {
    if(i+2 >= level) document.getElementById(id).innerHTML = '';
  });
  document.getElementById('dynamicForm').style.display = 'block';
}

function populate(level, data){
  const sel = document.getElementById('level'+level);
  sel.innerHTML = '<option value="">-- Select --</option>';
  data.forEach(x => sel.innerHTML += `<option value="${x.id}">${x.name}</option>`);
}

function loadForm(id){
  fetch(`/vehicle/fetch-children/${id}`)
    .then(r => r.json())
    .then(steps => {
      if(steps.length > 0){
        buildForm(steps);
        document.getElementById('dynamicForm').style.display = 'block';
      } else {
        document.getElementById('dynamicForm').style.display = 'none';
      }
    });
}

function buildLevel4Buttons(categories) {
  const btnDiv = document.getElementById('level4Buttons');
  btnDiv.innerHTML = categories.map(cat => 
    `<button type="button" class="btn btn-outline-primary m-1" onclick="loadForm(${cat.id})">${cat.name}</button>`
  ).join('');
}

function buildForm(steps){

  let tabs = '', content = '';
  steps.forEach((s, i) => {
    const active = i === 0 ? ' active' : '';
    tabs += `<li class="nav-item">
      <button class="nav-link${active}" data-bs-toggle="tab" data-bs-target="#tab-${s.id}" type="button">${s.name}</button>
    </li>`;
    content += `<div class="tab-pane fade${active ? ' show active' : ''}" id="tab-${s.id}">
      ${s.child.map(f => {
        switch(f.functionality.toLowerCase()){
          case 'text':
            return `<div class="mb-3"><label>${f.name}</label><input type="text" name="${f.name}" class="form-control"></div>`;
          case 'optional':
            return `<div class="mb-3"><label>${f.name}</label><select name="${f.name}_id" class="form-select">
              <option value="">--select--</option>${f.child.map(o => `<option value="${o.id}">${o.name}</option>`).join('')}
            </select></div>`;
          case 'checkbox':
            return `<div class="mb-3"><label>${f.name}</label>${f.child.map(o => `<div><input type="checkbox" name="${f.name}[]" value="${o.name}"> ${o.name}</div>`).join('')}</div>`;
          case 'radio':
            return `<div class="mb-3"><label>${f.name}</label>${['Yes','No'].map(v => `<div><input type="radio" name="${f.name}" value="${v}"> ${v}</div>`).join('')}</div>`;
          case 'files':
            return `<div class="mb-3"><label>${f.name}</label><input type="file" name="${f.name}" class="form-control"></div>`;
          default:
            return `<div class="mb-3"><label>${f.name}</label><input type="text" name="${f.name}" class="form-control"></div>`;
        }
      }).join('')}
    </div>`;
  });
  document.getElementById('formTabs').innerHTML = tabs;
  document.getElementById('formTabsContent').innerHTML = content;
}

// Dropdown Event Listeners

document.getElementById('level1').addEventListener('change', function(){
  resetFrom(2);
  if(this.value) fetch(`/vehicle/fetch-children/${this.value}`)
    .then(r => r.json()).then(d => populate(2, d));
});

document.getElementById('level2').addEventListener('change', function(){
  resetFrom(3);
  if(this.value) fetch(`/vehicle/fetch-children/${this.value}`)
    .then(r => r.json()).then(d => populate(3, d));
});

document.getElementById('level3').addEventListener('change', function(){
  resetFrom(4);
  if(this.value) fetch(`/vehicle/fetch-children/${this.value}`)
    .then(r => r.json()).then(d => buildLevel4Buttons(d));
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