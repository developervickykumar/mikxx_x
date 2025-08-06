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


    <style>
        .form-sidebar {
            max-height: 85vh;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }

        .form-element {
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 8px;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .form-element:hover {
            cursor: grab;
            background-color: #e9ecef;
        }

        .accordion-button {
            background-color: #f1f1f1;
        }

        .accordion-body {
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-4 form-sidebar p-0">
            <!-- Tabs -->
            <ul class="nav nav-tabs bg-white px-2 pt-2" id="elementTabs" role="tablist">
                @foreach ($groupedSubCategories as $key => $items)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                           id="{{ strtolower($key) }}-tab"
                           data-bs-toggle="tab"
                           href="#tab-{{ strtolower($key) }}"
                           role="tab">
                            {{ ucfirst($key) }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Tab Contents -->
            <div class="tab-content p-3" id="elementTabsContent">
                @foreach ($groupedSubCategories as $key => $parentCategories)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                         id="tab-{{ strtolower($key) }}"
                         role="tabpanel">

                        @if($parentCategories->isEmpty())
                            <p class="text-muted">No {{ $key }} elements available.</p>
                        @else
                            <div class="accordion" id="accordion-{{ strtolower($key) }}">
                                @foreach ($parentCategories as $parent)
                                    @php
                                        $accordionId = \Illuminate\Support\Str::slug($parent->name . '-' . $key . '-' . $parent->id, '_');
                                        $children = $parent->children()->where('status', 'active')->get();
                                    @endphp

                                    <div class="accordion-item mb-2">
                                        <h2 class="accordion-header" id="heading-{{ $accordionId }}">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $accordionId }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-{{ $accordionId }}">
                                                {{ $parent->name }}
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $accordionId }}"
                                             class="accordion-collapse collapse"
                                             aria-labelledby="heading-{{ $accordionId }}"
                                             data-bs-parent="#accordion-{{ strtolower($key) }}">
                                            <div class="accordion-body">
                                                @forelse ($children as $child)
                                                    @php
                                                        $groupviewType = ($child->group_view['enabled'] ?? false)
                                                            ? strtolower($child->group_view['view_type'] ?? '')
                                                            : '';
                                                        $optionAllowed = ($child->advanced['allow_user_options'] ?? false)
                                                            ? strtolower($child->advanced['allow_user_options'] ?? '')
                                                            : '';
                                                        $isForm = (strtolower($child->label_json['label'] ?? '') === 'form');
                                                    @endphp

                                                    <div class="form-element"
                                                         draggable="true"
                                                         data-label="{{ $child->name }}"
                                                         data-groupview="{{ $groupviewType }}"
                                                         data-functionality="{{ strtolower($child->functionality ?? 'text') }}"
                                                         data-optionAllowed="{{ $optionAllowed }}"
                                                         data-isform="{{ $isForm ? '1' : '0' }}">

                                                        <i class="{{ $child->icon ?? 'fas fa-tag' }}"></i>
                                                        <p class="mb-0">{{ $child->name }}</p>

                                                        <div>
                                                            @if($isForm)
                                                                <span class="badge bg-primary ms-2">Form</span>
                                                            @endif

                                                            @if($groupviewType)
                                                                <span class="badge bg-success ms-2">Group</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="text-muted mb-0">No elements inside {{ $parent->name }}</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Placeholder for form drop area (optional) -->
        <div class="col-md-8 p-4">
            <h4>Form Canvas (Drag elements here)</h4>
            <div id="formCanvas" class="border rounded p-4" style="min-height: 300px; background: #f8f9fa;"
                 ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                <p class="text-muted">Drag form elements here</p>
            </div>
        </div>
    </div>
</div>



<!-- Simple Drag-and-Drop Script -->
<script>
    document.querySelectorAll('.form-element').forEach(elem => {
        elem.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', JSON.stringify({
                label: e.target.dataset.label,
                functionality: e.target.dataset.functionality,
                groupview: e.target.dataset.groupview,
                optionAllowed: e.target.dataset.optionallowed,
                isForm: e.target.dataset.isform
            }));
        });
    });

    function handleDrop(e) {
        e.preventDefault();
        const data = JSON.parse(e.dataTransfer.getData('text/plain'));
        const dropped = document.createElement('div');
        dropped.className = 'p-2 border mb-2 bg-white';
        dropped.textContent = `Dropped: ${data.label} (${data.functionality})`;
        document.getElementById('formCanvas').appendChild(dropped);
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