@extends('layouts.master')

@section('title')
@lang('translation.Profile')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1')
Contacts
@endslot
@slot('title')

{{ ucfirst(Auth::user()->user_type) }}

Profile
@endslot
@endcomponent
<div class="row">
    <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm order-2 order-sm-1">
                        <div class="d-flex align-items-start mt-3 mt-sm-0">
                            <div class="flex-shrink-0">
                                <div class="avatar-xl me-3">
                                    <img class="w-100 h-100  rounded-circle"
                                        src="{{ $user->profile_pic ?  Storage::url('build/images/candidates/' . $user->profile_pic) : asset('build/images/users/avatar-1.jpg') }}"
                                        alt="Profile Picture">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-16 mb-1 text-capitalize">{{ Auth::user()->username }}</h5>
                                    <p class="text-muted font-size-13"></p>

                                    <div
                                        class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                        @if (Auth::check() && Auth::user()->candidate)
                                        @php
                                        $roleName = Auth::user()->candidate->role ? Auth::user()->candidate->role->name
                                        : 'No Role Assigned';
                                        @endphp
                                        <div>
                                            <i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>
                                            {{ $roleName }}
                                        </div>
                                        @endif

                                        <div><i
                                                class="mdi mdi-circle-medium me-1 text-success align-middle"></i>{{ Auth::user()->email  }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto order-1 order-sm-2">
                        <div class="d-flex align-items-start justify-content-end gap-2">
                            <div>


                                <a href="{{ route('editProfile', Auth::user()->id) }}" class="btn btn-soft-light">Edit
                                    Profile</a>

                                <!-- <button type="button" class="btn btn-soft-light"><i class="me-1"></i>
                                        Message</button> -->
                            </div>
                            <!-- <div>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                    @foreach($profileTabs as $index => $tab)
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                            href="#tab-{{ Str::slug($tab->name) }}" role="tab">
                            @if ($tab->icon)
                            <i class="{{ $tab->icon }} me-1"></i>
                            @endif
                            {{ ucfirst($tab->name) }}
                        </a>
                    </li>
                    @endforeach
                </ul>


            </div>
        </div>
        <!-- end card -->

        @php

        function flattenCategoryNames($categories)
        {
        $result = [];

        foreach ($categories as $category) {
        $result[] = $category->name;

        if (isset($category->children) && $category->children->count()) {
        $result = array_merge($result, flattenCategoryNames($category->children));
        }
        }

        return $result;
        }


        @endphp

        <div class="tab-content">
            @foreach($profileTabs as $index => $tab)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ Str::slug($tab->name) }}"
                role="tabpanel">

                <div class="row">
                    <div class="col-md-3">
                        <!-- Vertical Nav Pills -->
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            @foreach($tab->subTabs as $subIndex => $subTab)
                            <a class="nav-link {{ $subIndex === 0 ? 'active' : '' }}"
                                id="vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}-tab"
                                data-bs-toggle="pill"
                                href="#vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}" role="tab">
                                {{ $subTab->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-9">
                        <!-- Vertical Tab Content -->
                        <div class="tab-content">
                            @foreach($tab->subTabs as $subIndex => $subTab)
                            <div class="tab-pane fade {{ $subIndex === 0 ? 'show active' : '' }}"
                                id="vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}" role="tabpanel">

                                <h4>{{$subTab->name}}</h4>

                                <form method="POST" action="" enctype="multipart/form-data" class="p-3 row">
                                    @csrf

                                    @foreach($subTab->fields as $field)


                                    @php


                                    $fieldName = Str::slug($field->name, '_');
                                    $fieldType = $field->functionality ?? 'text';
                                    $fieldValue = old($fieldName, $user->$fieldName ?? '');


                                    $fieldValueArray = is_array($fieldValue) ? $fieldValue :
                                    (array)json_decode($fieldValue, true) ?? [];

                                    $allowUserOptions = $field->advanced['allow_user_options'] ?? false;

                                    $allOptions = $field->children ?? [];

                                    $selectedValues = is_array($fieldValue) ? $fieldValue :
                                    (array)json_decode($fieldValue, true) ?? [];

                                    $suggestions = flattenCategoryNames($field->children ?? collect());

                                    @endphp

                                    <div class="mb-3 col-md-6">
                                        <label for="{{ $fieldName }}" class="form-label">{{ $field->name }}</label>

                                        @php
                                        $fieldValue = old($fieldName, $user->$fieldName ?? '');
                                        $options = $field->children ?? [];
                                        @endphp

                                        @if($fieldType === 'Optional')
                                        <select class="form-select" name="{{ $fieldName }}" id="{{ $fieldName }}">
                                            <option value="">Select {{ $field->name }}</option>
                                            @foreach($options as $option)
                                            <option value="{{ $option->name }}"
                                                {{ $fieldValue == $option->name ? 'selected' : '' }}>{{ $option->name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        @elseif($fieldType === 'Checkbox')
                                        @foreach($options as $option)
                                        <div class="form-check">
                                            <input type="checkbox" name="{{ $fieldName }}[]" value="{{ $option->name }}"
                                                class="form-check-input" id="{{ $fieldName }}_{{ $loop->index }}"
                                                {{ is_array($fieldValue) && in_array($option->name, $fieldValue) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $fieldName }}_{{ $loop->index }}">{{ $option->name }}</label>
                                        </div>
                                        @endforeach

                                        @elseif($fieldType === 'MultiSelect')
                                        <select class="form-select" name="{{ $fieldName }}[]" multiple
                                            id="{{ $fieldName }}">
                                            @foreach($options as $option)
                                            <option value="{{ $option->name }}"
                                                {{ collect($fieldValue)->contains($option->name) ? 'selected' : '' }}>
                                                {{ $option->name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        @elseif($fieldType === 'Radio')
                                        @foreach($options as $option)
                                        <div class="form-check">
                                            <input type="radio" name="{{ $fieldName }}" value="{{ $option->name }}"
                                                class="form-check-input" id="{{ $fieldName }}_{{ $loop->index }}"
                                                {{ $fieldValue == $option->name ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $fieldName }}_{{ $loop->index }}">{{ $option->name }}</label>
                                        </div>
                                        @endforeach

                                        @elseif($fieldType === 'Text')
                                        <input type="text" class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}" value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Email')
                                        <input type="email" class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}" value="{{ $fieldValue }}">
                                        @elseif($fieldType === 'Contact Number')
                                        <input type="tel" class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}" value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Description')
                                        <textarea class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}">{{ $fieldValue }}</textarea>

                                        @elseif($fieldType === 'Unit')
                                        <input type="number" step="any" class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}" value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Price')
                                        <input type="number" step="0.01" class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}" value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Rating')
                                        <input type="number" min="1" max="5" class="form-control"
                                            name="{{ $fieldName }}" id="{{ $fieldName }}" value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Range')
                                        <input type="range" class="form-range" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}" value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Review')
                                        <textarea class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}">{{ $fieldValue }}</textarea>

                                        @elseif($fieldType === 'Table')
                                        {{-- You can integrate a dynamic table builder view here --}}
                                        <textarea class="form-control" readonly
                                            placeholder="Table will be rendered here..." rows="3"></textarea>

                                        @elseif($fieldType === 'Table Checkbox')
                                        {{-- Placeholder for custom checkbox-in-table logic --}}
                                        <textarea class="form-control" readonly
                                            placeholder="Table Checkbox UI will appear..." rows="3"></textarea>

                                        @elseif($fieldType === 'Column Table')
                                        {{-- Placeholder for column-wise data table --}}
                                        <textarea class="form-control" readonly
                                            placeholder="Column Table UI will appear..." rows="3"></textarea>

                                        @elseif($fieldType === 'Chip View')

                                        <div id="chip-wrapper-{{ $fieldName }}"
                                            class="chip-input-wrapper border rounded p-2 d-flex flex-wrap gap-2">
                                            @foreach($selectedValues as $val)
                                            <span class="badge bg-primary chip" data-value="{{ $val }}">
                                                {{ $val }}
                                                <button type="button"
                                                    class="btn-close btn-close-white btn-sm ms-1 remove-chip"></button>
                                            </span>
                                            @endforeach

                                            <input type="text" style="outline:none"
                                                class="chip-input border-0 flex-grow-1" id="chip-input-{{ $fieldName }}"
                                                placeholder="Type and press Enter" autocomplete="off"
                                                style="min-width: 150px;">
                                        </div>

                                        <!-- Suggestion List -->
                                        <div id="suggestions-{{ $fieldName }}"
                                            class="dropdown-menu show w-100 mt-1 shadow-sm d-none"
                                            style="max-height: 200px; overflow-y: auto;"></div>

                                        <!-- Hidden input -->
                                        <input type="hidden" name="{{ $fieldName }}" id="chip-hidden-{{ $fieldName }}"
                                            value="{{ implode(',', $selectedValues) }}">
                                        <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const input = document.querySelector(
                                            '#chip-input-{{ $fieldName }}');
                                            const chipWrapper = document.querySelector(
                                                '#chip-wrapper-{{ $fieldName }}');
                                            const chipHidden = document.querySelector(
                                                '#chip-hidden-{{ $fieldName }}');
                                            const suggestionsBox = document.querySelector(
                                                '#suggestions-{{ $fieldName }}');

                                            const suggestions = @json($suggestions);
                                            const allowCustom = @json($allowUserOptions);

                                            function updateHidden() {
                                                const chips = [...chipWrapper.querySelectorAll('.chip')].map(
                                                    c => c.dataset.value);
                                                chipHidden.value = chips.join(',');
                                            }

                                            function addChip(value) {
                                                if (!value || chipWrapper.querySelector(
                                                        `.chip[data-value="${value}"]`)) return;

                                                const chip = document.createElement('span');
                                                chip.className =
                                                    'badge bg-primary chip d-flex align-items-center';
                                                chip.dataset.value = value;
                                                chip.innerHTML = `${value}
            <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-chip"></button>`;

                                                chipWrapper.insertBefore(chip, input);
                                                updateHidden();
                                            }

                                            function filterSuggestions(term) {
                                                const filtered = suggestions.filter(s => s.toLowerCase()
                                                    .includes(term.toLowerCase()));
                                                suggestionsBox.innerHTML = '';
                                                if (filtered.length) {
                                                    filtered.forEach(s => {
                                                        const div = document.createElement('div');
                                                        div.className = 'dropdown-item';
                                                        div.textContent = s;
                                                        div.dataset.value = s;
                                                        suggestionsBox.appendChild(div);
                                                    });
                                                    suggestionsBox.classList.remove('d-none');
                                                } else {
                                                    suggestionsBox.classList.add('d-none');
                                                }
                                            }

                                            input.addEventListener('input', function() {
                                                const term = this.value.trim();
                                                if (term.length > 0) {
                                                    filterSuggestions(term);
                                                } else {
                                                    suggestionsBox.classList.add('d-none');
                                                }
                                            });

                                            input.addEventListener('keydown', function(e) {
                                                if (e.key === 'Enter') {
                                                    e.preventDefault();
                                                    const val = this.value.trim();
                                                    if (!val) return;

                                                    if (suggestions.includes(val) || allowCustom) {
                                                        addChip(val);
                                                        this.value = '';
                                                        suggestionsBox.classList.add('d-none');
                                                    } else {
                                                        alert('Only suggestions are allowed.');
                                                    }
                                                }
                                            });

                                            suggestionsBox.addEventListener('click', function(e) {
                                                if (e.target.classList.contains('dropdown-item')) {
                                                    addChip(e.target.dataset.value);
                                                    input.value = '';
                                                    suggestionsBox.classList.add('d-none');
                                                }
                                            });

                                            chipWrapper.addEventListener('click', function(e) {
                                                if (e.target.classList.contains('remove-chip')) {
                                                    e.target.closest('.chip').remove();
                                                    updateHidden();
                                                }
                                            });
                                        });
                                        </script>



                                        @elseif($fieldType === 'Expandable Dropdown')
                                        <div class="mb-3 col-md-12">

                                            <div class="accordion" id="accordion-{{ $fieldName }}">
                                                @foreach($options as $option)
                                                @php
                                                $subItems = $option->children ?? [];
                                                $accordionId = Str::slug($fieldName . '-' . $option->name);
                                                @endphp

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading-{{ $accordionId }}">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-{{ $accordionId }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapse-{{ $accordionId }}">
                                                            {{ $option->name }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse-{{ $accordionId }}"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="heading-{{ $accordionId }}"
                                                        data-bs-parent="#accordion-{{ $fieldName }}">
                                                        <div class="accordion-body row">
                                                            @if(count($subItems))
                                                            @foreach($subItems as $subItem)
                                                            <div class="form-check col-md-4">
                                                                <input type="checkbox"
                                                                    name="{{ $fieldName }}[{{ $option->name }}][]"
                                                                    value="{{ $subItem->name }}"
                                                                    class="form-check-input"
                                                                    id="{{ Str::slug($fieldName . '-' . $option->name . '-' . $subItem->name) }}">
                                                                <label class="form-check-label"
                                                                    for="{{ Str::slug($fieldName . '-' . $option->name . '-' . $subItem->name) }}">
                                                                    {{ $subItem->name }}
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                            @else
                                                            <p class="text-muted">No items available.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>


                                        @elseif($fieldType === 'Checkbox Dropdown')
                                        <select multiple class="form-select" name="{{ $fieldName }}[]"
                                            id="{{ $fieldName }}">
                                            @foreach($options as $option)
                                            <option value="{{ $option->name }}"
                                                {{ collect($fieldValue)->contains($option->name) ? 'selected' : '' }}>
                                                {{ $option->name }}
                                            </option>
                                            @endforeach
                                        </select>

                                        @elseif($fieldType === 'Button Dropdown')
                                        {{-- Use dropdown with buttons --}}
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                {{ $field->name }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach($options as $option)
                                                <li><a class="dropdown-item" href="#">{{ $option->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        @elseif($fieldType === 'Icon Dropdown')
                                        {{-- Same as above but with icons (dummy) --}}
                                        <select class="form-select" name="{{ $fieldName }}" id="{{ $fieldName }}">
                                            @foreach($options as $option)
                                            <option>{{ $option->name }} 🔽</option>
                                            @endforeach
                                        </select>

                                        @elseif($fieldType === 'Checkbox Row Table')
                                        <textarea class="form-control" readonly
                                            placeholder="Checkbox Row Table UI here..." rows="3"></textarea>

                                        @elseif($fieldType === 'Checkbox Column Table')
                                        <textarea class="form-control" readonly
                                            placeholder="Checkbox Column Table UI here..." rows="3"></textarea>

                                        @elseif($fieldType === 'Multiple Text Fields')
                                        <div class="d-flex flex-column gap-1">
                                            @for($i = 0; $i < 3; $i++) <input type="text" class="form-control"
                                                name="{{ $fieldName }}[]" placeholder="Text Field {{ $i+1 }}">
                                                @endfor
                                        </div>

                                        @elseif($fieldType === 'Checklist')
                                        @foreach($options as $option)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="{{ $fieldName }}[]"
                                                value="{{ $option->name }}">
                                            <label class="form-check-label">{{ $option->name }}</label>
                                        </div>
                                        @endforeach

                                        @elseif($fieldType === 'Data Grid')
                                        <textarea class="form-control" readonly placeholder="Data Grid UI goes here..."
                                            rows="3"></textarea>

                                        @elseif($fieldType === 'Orderable List')
                                        <textarea class="form-control" readonly placeholder="Orderable list items..."
                                            rows="3"></textarea>

                                        @elseif($fieldType === 'Progress Bar')
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $fieldValue ?? 50 }}%"
                                                aria-valuenow="{{ $fieldValue ?? 50 }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                {{ $fieldValue ?? 50 }}%
                                            </div>
                                        </div>

                                        @elseif($fieldType === 'Date')
                                        <input type="date" class="form-control" name="{{ $fieldName }}"
                                            value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Date & Time')
                                        <input type="datetime-local" class="form-control" name="{{ $fieldName }}"
                                            value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Last Date' || $fieldType === 'Previous Date')
                                        <input type="date" class="form-control" name="{{ $fieldName }}"
                                            value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Date Range')
                                        <div class="d-flex gap-2">
                                            <input type="date" class="form-control" name="{{ $fieldName }}_from"
                                                placeholder="From">
                                            <input type="date" class="form-control" name="{{ $fieldName }}_to"
                                                placeholder="To">
                                        </div>

                                        @elseif($fieldType === 'Time' || $fieldType === 'Timer')
                                        <input type="time" class="form-control" name="{{ $fieldName }}"
                                            value="{{ $fieldValue }}">

                                        @elseif($fieldType === 'Date Reservation')
                                        <input type="date" class="form-control" name="{{ $fieldName }}"
                                            value="{{ $fieldValue }}">

                                        @elseif(in_array($fieldType, ['Logo', 'Image', 'Banner', 'Album', 'Video',
                                        'Files', 'Presentation']))
                                        <input type="file" class="form-control" name="{{ $fieldName }}"
                                            id="{{ $fieldName }}">
                                        @if($fieldValue)
                                        <div class="mt-2">
                                            @if(Str::contains($fieldType, 'Video'))
                                            <video width="100%" controls>
                                                <source src="{{ Storage::url($fieldValue) }}">
                                            </video>
                                            @elseif(Str::contains($fieldType, ['Image', 'Logo', 'Banner']))
                                            <img src="{{ Storage::url($fieldValue) }}" height="80">
                                            @else
                                            <a href="{{ Storage::url($fieldValue) }}" target="_blank">View File</a>
                                            @endif
                                        </div>
                                        @endif

                                        @else
                                        <input type="text" class="form-control" name="{{ $fieldName }}"
                                            value="{{ $fieldValue }}">
                                        @endif
                                    </div>

                                    @endforeach

                                    <button type="submit" class="btn btn-primary">Update {{ $subTab->name }}</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>
    <!-- end col -->

    <div class="col-xl-3 col-lg-4">
        <!-- <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Skills</h5>

                <div class="d-flex flex-wrap gap-2 font-size-16">
                    <a href="#" class="badge bg-primary-subtle text-primary">Photoshop</a>
                    <a href="#" class="badge bg-primary-subtle text-primary">illustrator</a>
                    <a href="#" class="badge bg-primary-subtle text-primary">HTML</a>
                    <a href="#" class="badge bg-primary-subtle text-primary">CSS</a>
                    <a href="#" class="badge bg-primary-subtle text-primary">Javascript</a>
                    <a href="#" class="badge bg-primary-subtle text-primary">Php</a>
                    <a href="#" class="badge bg-primary-subtle text-primary">Python</a>
                </div>
            </div>
        </div> -->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Portfolio</h5>

                <div>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="{{ $user->portfolio_url}}" target="_blank" class="py-2 d-block text-muted"><i
                                    class="mdi mdi-web text-primary me-1"></i>
                                Portfolio url</a>
                        </li>
                        <!-- <li>
                            <a href="#" class="py-2 d-block text-muted"><i
                                    class="mdi mdi-note-text-outline text-primary me-1"></i> Blog</a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
        @if (Auth::check() && Auth::user()->candidate)

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Similar Profiles</h5>

                <div class="list-group list-group-flush">


                    @foreach($similarProfiles as $profile)
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <img src="{{ $profile->profile_pic ? Storage::url($profile->profile_pic) : 'default-avatar.jpg' }}"
                                    alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-14 mb-1">{{ $profile->user->first_name }}
                                        {{ $profile->user->last_name }}</h5>
                                    <p class="font-size-13 text-muted mb-0">
                                        {{ $profile->role->name ?? 'Role not specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <!-- end card body -->
        </div>
        @endif


        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('media.upload') }}"
                    enctype="multipart/form-data" id="add-gallery">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">

                    <div class="mb-3">
                        <label for="avatar">Upload Image</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">Upload</label>
                        </div>
                        @error('avatar')
                        <div class="text-danger" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Edit Bio and Achievements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-candidate-profile">
                    @csrf

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio"
                            placeholder="Enter bio">{{ old('bio', $userProfile->bio ?? '') }}</textarea>
                        @error('bio')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="achievements" class="form-label">Achievements</label>
                        <textarea class="form-control @error('achievements') is-invalid @enderror" id="achievements"
                            name="achievements"
                            placeholder="Enter achievements">{{ old('achievements', $userProfile->achievements ?? '') }}</textarea>
                        @error('achievements')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script>
$('#update-profile').on('submit', function(event) {
    event.preventDefault();
    var Id = $('#data_id').val();
    let formData = new FormData(this);
    $('#emailError').text('');
    $('#nameError').text('');
    $('#avatarError').text('');
    $.ajax({
        url: "{{ url('update-profile') }}" + "/" + Id,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#emailError').text('');
            $('#nameError').text('');
            $('#avatarError').text('');
            if (response.isSuccess == false) {
                alert(response.Message);
            } else if (response.isSuccess == true) {
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(response) {
            $('#emailError').text(response.responseJSON.errors.email);
            $('#nameError').text(response.responseJSON.errors.name);
            $('#avatarError').text(response.responseJSON.errors.avatar);
        }
    });
});

$(document).ready(function() {
    $('#update-candidate-profile').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '{{ route("update.profile.bio.achievements") }}',
            data: formData,
            success: function(response) {
                if (response.isSuccess) {
                    alert(response.message);
                    $('#updateProfileModal').modal('hide');
                    setTimeout(function() {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                // Handle errors
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    $('#' + field).addClass('is-invalid');
                    $('#' + field).next('.text-danger').text(errors[field][0]);
                }
            }
        });
    });
});
</script>
@endsection