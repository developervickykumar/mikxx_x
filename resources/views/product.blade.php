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
    {{-- Show Validation Errors --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Show Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <h2 class="text-center mb-4">Upload Details</h2>

    <div class="row">
        <div class="col-lg-12  text-end mr-3">
            <a href="{{url('/prodview')}}" class="btn btn btn-outline-info  text-end px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700 mt-4 ms-2">Black</a>
        </div>
     </div>

    <form action="{{ route('vehicle.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
           
        {{-- Level 1 --}}
        <div class=" col-md-4 mb-3">
            <label class="form-label">Product <span  id="label1Text" class="fw-bold text-dark"></span>
        
            </label>
            <select id="level1" name="level1" class="form-select" required>
                <option value="">-- Select --</option>
                @foreach($productTypes as $pt)
                <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Level 2 --}}
        <div class=" col-md-4 mb-3">
            <label class="form-label">
                <span id="label2Text" class="fw-bold text-dark">
            </span> </label>
            <select id="level2" name="level2" class="form-select" required></select>
        </div>

        {{-- Level 3 --}}
        <div class=" col-md-4 mb-3">
            <label class="form-label"> 
                <span id="label3Text" class="fw-bold text-dark"></span>
            </label>
            <select id="level3" name="level3" class="form-select" required></select>
        </div>
        </div>

         </div>

        {{-- Dynamic Tabs for Fields --}}
        <div id="dynamicForm" class="mt-4" style="display:none">
            <div class="row">
  <div class="col-md-3">
    <ul class="nav flex-column nav-pills" id="formTabs" role="tablist" aria-orientation="vertical"></ul>
  </div>
  <div class="col-md-9">
    <div class="tab-content border p-3 rounded mt-2" id="formTabsContent"></div>
  </div>

        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Submit Vehicle</button>
        </div>
    </form>
  <div class="text-end mt-4">
    <button type="button" class="btn btn-outline-primary" onclick="showEmbed()"> Show Embed</button>
  </div>
  <div id="embedContainer" class="mt-4" style="display:none;">
    <h5> Embadded Content</h5>
     <div class="ratio ratio-16x9">
        <pre><code id="embedHtmlCode" class="language-html"></code></pre>
     </div>
  </div>
</div>

<script>
function resetFrom(level) {
    ['level2', 'level3'].forEach((id, i) => {
        if (i + 2 >= level) document.getElementById(id).innerHTML = '';
    });
    document.getElementById('dynamicForm').style.display = 'none';
}

function populate(level, data) {
    const sel = document.getElementById('level' + level);
    sel.innerHTML = '<option value="">-- Select --</option>';
    data.forEach(x => {
        sel.innerHTML += `<option value="${x.id}">${x.name}</option>`;
    });
}

function updateLabelText(levelId, labelId)
{
    const select = document.getElementById(levelId);
    const label = document.getElementById(labelId);
    const selectOption = select.options[select.selectedIndex];
    label.textContent = selectOption.value ? selectOption.text : '';
}

function buildForm(steps) {
    let tabs = '';
    let content = '';

    steps.forEach((s, i) => {
        const active = i === 0 ? 'active' : '';
        const show = i === 0 ? 'show active' : '';

        // Tab button
        tabs += `
            <button class="nav-link ${active}" id="tab-${s.id}-tab" data-bs-toggle="pill" data-bs-target="#tab-${s.id}" type="button" role="tab" aria-controls="tab-${s.id}" aria-selected="${i === 0}">
                ${s.name}
            </button>
        `;

        // Tab content
        content += `<div class="tab-pane fade ${show}" id="tab-${s.id}" role="tabpanel" aria-labelledby="tab-${s.id}-tab">`;

        s.child.forEach(f => {
            const name = f.name;
            const func = f.functionality?.toLowerCase() || 'text';
            const children = Array.isArray(f.child) ? f.child : [];

            if (func === 'text') {
                content += `<div class="mb-3">
                    <label>${name}</label>
                    <input type="text" name="${name}" class="form-control">
                </div>`;
            }

            else if (func === 'optional') {
                content += `<div class="mb-3">
                    <label>${name}</label>
                    <select name="${name}_id" class="form-select">
                        <option value="">--select--</option>
                        ${children.map(o => `<option value="${o.id}">${o.name}</option>`).join('')}
                    </select>
                </div>`;
            }

            else if (func === 'checkbox') {
                content += `<div class="mb-3"><label>${name}</label>`;
                children.forEach((o, index) => {
                    const checkboxId = `${name}_${index}`;
                    content += `<div class="form-check">
                        <input type="checkbox" class="form-check-input" name="${name}[]" value="${o.name}" id="${checkboxId}">
                        <label class="form-check-label" for="${checkboxId}">${o.name}</label>
                    </div>`;
                });
                content += '</div>';
            }

            else if (func === 'radio') {
                content += `<div class="mb-3"><label>${name}</label>`;
                ['Yes', 'No'].forEach(v => {
                    const radioId = `${name}_${v}`;
                    content += `<div class="form-check">
                        <input class="form-check-input" type="radio" name="${name}" value="${v}" id="${radioId}">
                        <label class="form-check-label" for="${radioId}">${v}</label>
                    </div>`;
                });
                content += '</div>';
            }

            else if (func === 'files') {
                content += `<div class="mb-3">
                    <label>${name}</label>
                    <input class="form-control" type="file" name="${name}">
                </div>`;
            }

            else {
                content += `<div class="mb-3">
                    <label>${name}</label>
                    <input class="form-control" type="text" name="${name}">
                </div>`;
            }
        });

        content += '</div>'; // end tab-pane
    });

    // Inject into DOM
    document.getElementById('formTabs').innerHTML = tabs;
    document.getElementById('formTabsContent').innerHTML = content;
    document.getElementById('dynamicForm').style.display = 'block';
}

// Event listeners
['level1', 'level2', 'level3'].forEach((id, idx) => {
    document.getElementById(id).addEventListener('change', function() {
        const level = idx + 2;
        resetFrom(level);
      //update labels dynamically
      updateLabelText(id,'label'+(idx+1)+ 'Text');
       
        if (this.value) {
            fetch(`/vehicle/fetch-child/${this.value}`)
                .then(r => r.json())
                .then(data => {
                    if (level < 4) {
                        populate(level, data);
                    } else if (Array.isArray(data)) {
                        buildForm(data);
                    }
                });
        }
    });
});


function showEmbed() {
    const level3 = document.getElementById('level3').value;

    if (!level3) {
        alert('Please select a valid final category to show embed');
        return;
    }

    fetch('/vehicle/fetch-child/' + level3)
        .then(response => response.json())
        .then(steps => {
            if (Array.isArray(steps)) {
                buildForm(steps);

                // Show the embed container
                document.getElementById('embedContainer').style.display = 'block';

                // Wait for DOM to update, then grab innerHTML
                setTimeout(() => {
                    const embedHTML = document.getElementById('dynamicForm').innerHTML;

                    // Encode HTML to show safely in <pre><code>
                    const encodedHTML = embedHTML
                      .replace(/</g, '&lt;')
                      .replace(/>/g, '&gt;');

                    document.getElementById('embedHtmlCode').innerHTML = encodedHTML;
                    document.getElementById('embedHtmlContainer').style.display = 'block';
                }, 300); // small delay to ensure DOM update
            } else {
                alert('No embed data found for selected category.');
            }
        })
        .catch(err => {
            console.error('Error fetching embed data:', err);
            alert('Failed to load embed content.');
        });
}



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