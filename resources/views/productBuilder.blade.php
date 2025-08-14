@extends('layouts.master')

@section('title') Form Builder @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Builder @endslot
@slot('title') Form Builder Dashboard @endslot
@endcomponent

<style>
.vertical-menu {
    display: none;
}

.main-content {
    margin-left: 0;
}

@media (min-width: 1200px) {

    .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        max-width: 100%;
    }
}
</style>

<style>
.form-sidebar {
    max-height: 80vh;
    overflow-y: auto;
    border-right: 1px solid #dee2e6;
    background: #f8f9fa;
}

.left-accordion .form-element {
    width: 32.5%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

}

.form-element {
    background: #fff;
    padding: 14px 4px;
    margin-bottom: 2px;
    /*border: 1px solid #ced4da;*/
    /*border-radius: 6px;*/
    cursor: grab;

    font-size: 11px;

}



.form-canvas {
    min-height: 80vh;
    padding: 20px;
    border-radius: 6px;
}

.form-element.dragging {
    opacity: 0.5;
}

.form-element i {
    font-size: 20px;
    height: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.drop-zone {
    min-height: 50px;
}

.drop-zone-hover {
    background: #fff;
    border-color: #fff !important;
}

.tab-content>.active {
    display: block !important;
}

.accordion-body.left-accordion {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    /*justify-content: space-between;*/
    background: #f1f1f1;
    padding: 10px;
}

.add-more-drop-zone.drop-zone-hover {


    min-height: 60px;
    border-radius: 6px;
    transition: all 0.2s ease;
}


.add-more-drop-zone {

    min-height: 60px;
    padding: 10px;
    border-radius: 6px;
}
</style>

<div class="row">
    <!-- Left Sidebar -->
    <div class="col-md-4 form-sidebar pe-0">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs bg-white px-2 pt-2" id="elementTabs" role="tablist">
            @foreach ($groupedSubCategories as $key => $items)
            <li class="nav-item ">
                <a class="nav-link {{ $loop->first ? 'active' : '' }} " id="{{ strtolower($key) }}-tab"
                    data-bs-toggle="tab" href="#tab-{{ strtolower($key) }}" role="tab">
                    {{ ucfirst($key) }}
                </a>
            </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content p-3" id="elementTabsContent">

            @foreach ($groupedSubCategories as $key => $parentCategories)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ strtolower($key) }}"
                role="tabpanel">

                @if($parentCategories->isEmpty())
                <p class="text-muted">No {{ $key }} elements available.</p>
                @else
                <div class="accordion" id="accordion-{{ strtolower($key) }}">
                    @foreach ($parentCategories as $parent)
                    @php
                    $accordionId = \Illuminate\Support\Str::slug($parent->name . '-' . $key, '_');
                    $children = $parent->children()->where('status', 'active')->get();

                    @endphp

                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header" id="heading-{{ $accordionId }}">
                            <button style="background:#f1f1f1" class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse-{{ $accordionId }}"
                                aria-expanded="false" aria-controls="collapse-{{ $accordionId }}">
                                {{ $parent->name }}
                            </button>
                        </h2>
                        <div id="collapse-{{ $accordionId }}" class="accordion-collapse collapse"
                            aria-labelledby="heading-{{ $accordionId }}"
                            data-bs-parent="#accordion-{{ strtolower($key) }}">
                            <div class="accordion-body left-accordion">
                                @forelse ($children as $child)

                                @php
                                $groupviewType = ($child->group_view['enabled'] ?? false) ?
                                strtolower($child->group_view['view_type'] ?? '') : '';
                                $optionAllowed = ($child->advanced['allow_user_options'] ?? false) ?
                                strtolower($child->advanced['allow_user_options'] ?? '') : '';
                                $isForm = (strtolower($child->label_json['label'] ?? '') === 'form');

                                @endphp
                                <div class="form-element" draggable="true" data-label="{{ $child->name }}"
                                    data-groupview="{{ $groupviewType }}"
                                    data-functionality="{{ strtolower($child->functionality ?? 'text') }}"
                                    data-optionAllowed="{{ $optionAllowed }}" data-isform="{{ $isForm ? '1' : '0' }}">

                                    <i class="{{ $child->icon ?? 'fas fa-tag' }} pb-2"></i>
                                    <p class=" mb-0">{{ $child->name }}</p>
                                    <div>
                                        @if($isForm)
                                        <span class="badge bg-primary ms-2">Form</span>
                                        @endif

                                        @if($groupviewType)
                                        <span class="badge bg-primary ms-2">Group</span>
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

    <!-- Right Preview Panel -->
    <div class="col-md-8">
        <!-- Layout Selector + Add Group -->


        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">

            {{-- 🔤 File Name + Module --}}
            <div class="d-flex align-items-center gap-2">
                <input type="text" class="form-control" placeholder="Enter File Name" style="width: 200px;">
                <select class="form-select" style="width: 150px;">
                    <option value="">Select Module</option>
                    <option value="form">Form</option>
                    <option value="lead">Lead</option>
                    <option value="post">Post</option>
                    <option value="survey">Survey</option>
                </select>
            </div>

            {{-- 📐 Desktop Columns Dropdown --}}
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" title="Desktop Columns">
                    <i class="fas fa-desktop"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    <select id="layoutSelect" class="form-select">
                        @for ($i = 1; $i <= 8; $i++) <option value="col-md-{{ $i }}">{{ $i }} Column{{ $i > 1 ? 's' : ''
                            }}</option>
                            @endfor
                    </select>
                </ul>
            </div>

            {{-- 📱 Mobile Columns Dropdown --}}
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" title="Mobile Columns">
                    <i class="fas fa-mobile-alt"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    <select id="mobileLayoutSelect" class="form-select">
                        @for ($i = 1; $i <= 12; $i++) <option value="col-sm-{{ $i }}" {{ $i==12 ? 'selected' : '' }}>
                            {{ $i }} Column{{ $i > 1 ? 's' : '' }}
                            </option>
                            @endfor
                    </select>
                </ul>
            </div>

            {{-- 👁️ Preview Type Dropdown --}}
            <div class="btn-group">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false" title="Preview Type">
                    <i class="fas fa-eye"></i>
                </button>
                <ul class="dropdown-menu p-2">
                    <select id="previewType" class="form-select">
                        <option value="default" selected>Default</option>
                        <option value="vertical-tabs">Vertical Tabs</option>
                        <option value="horizontal-tabs">Horizontal Tabs</option>
                        <option value="multi-step">Multi Step</option>
                    </select>
                </ul>
            </div>

            {{-- ➕ Add Group & Spacer --}}
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-primary" onclick="addNewGroup()" title="Add Group">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="btn btn-sm btn-secondary" onclick="addSpacer()" title="Add Spacer">
                    <i class="fas fa-arrows-alt-v"></i>
                </button>
            </div>

        </div>

        <div class="text-end mt-3">
            <button class="btn btn-outline-primary" onclick="showFormPreview()">
                <i class="fas fa-eye me-1"></i> Preview Form
            </button>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn-soft-secondary btn-sm open-share-modal" data-bs-toggle="modal"
                data-bs-target="#shareFormModal" data-form-name="" data-form-url="">
                <i class="mdi mdi-share"></i>
            </button>
        </div>

        <div class="form-canvas" id="formCanvasWrapper">

            <div id="formCanvas"></div>

            <!--product view-->
            <div id="specialLayout" style="display:none;">

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
                            <a href="{{url('/prodview')}}"
                                class="btn btn btn-outline-info  text-end px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700 mt-4 ms-2">Black</a>
                        </div>
                    </div>

                    <form action="{{ route('vehicle.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            {{-- Level 1 --}}
                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Product <span id="label1Text"
                                        class="fw-bold text-dark"></span>

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
                            <ul class="nav flex-column nav-pills" id="formTabs" role="tablist"
                                aria-orientation="vertical"></ul>
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

            </div>

            <div class="text-center mt-3">
                <button class="btn btn-outline-primary" onclick="addNewGroup()">
                    <i class="fas fa-layer-group me-1"></i> Insert Group
                </button>
            </div>
        </div>




    </div>
</div>



<div class="modal fade" id="formPreviewModal" tabindex="-1" aria-labelledby="formPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formPreviewLabel">Form Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="formPreviewContent">
                <!-- Preview will be injected here -->
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareFormModal" tabindex="-1" aria-labelledby="shareFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p id="formNameToShare" class="fw-bold"></p>
                <div class="d-flex justify-content-center gap-2">
                    <a id="whatsappShare" href="#" class="btn btn-success" target="_blank" title="Share on WhatsApp">
                        <i class="mdi mdi-whatsapp"></i>
                    </a>
                    <a id="facebookShare" href="#" class="btn btn-primary" target="_blank" title="Share on Facebook">
                        <i class="mdi mdi-facebook"></i>
                    </a>
                    <a id="twitterShare" href="#" class="btn btn-info" target="_blank" title="Share on Twitter">
                        <i class="mdi mdi-twitter"></i>
                    </a>
                    <button class="btn btn-secondary copy-link" id="copyFormLink" data-url="">
                        <i class="mdi mdi-content-copy"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="fieldSettingsModal" tabindex="-1" aria-labelledby="fieldSettingsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="fieldSettingsModalLabel">Field Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fieldSettingsForm">
                    <div class="mb-3">
                        <label for="fieldNameInput" class="form-label">Field Name</label>
                        <input type="text" class="form-control" id="fieldNameInput">
                    </div>
                    <div class="mb-3">
                        <label for="fieldTypeInput" class="form-label">Current Field Type</label>
                        <input type="text" class="form-control" id="fieldTypeInput" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="fieldTypeSelect" class="form-label">Functionality</label>
                        <select name="functionality" id="fieldTypeSelect" class="form-control">
                            <!-- Standard Types -->
                            <optgroup label="Standard Types">
                                <option value="Optional" data-cond="optional">Optional</option>
                                <option value="Checkbox" data-cond="checkbox">Checkbox</option>
                                <option value="MultiSelect" data-cond="multiselect">MultiSelect
                                </option>
                                <option value="Radio" data-cond="radio">Radio</option>
                                <option value="Text" data-cond="text">Text</option>
                                <option value="Email" data-cond="email">Email</option>
                                <option value="Contact-Number" data-cond="contact-number">Contact
                                    Number</option>
                                <option value="Description" data-cond="description">Description
                                </option>
                                <option value="Unit" data-cond="unit">Unit</option>
                                <option value="Price" data-cond="price">Price</option>
                                <option value="Rating" data-cond="rating">Rating</option>
                                <option value="Range" data-cond="range">Range</option>
                                <option value="Review" data-cond="review">Review</option>
                                <option value="Table" data-cond="table">Table</option>
                                <option value="Table-Checkbox" data-cond="table-checkbox">Table
                                    Checkbox</option>
                                <option value="Column-Table" data-cond="column-table">Column Table
                                </option>
                            </optgroup>

                            <!-- Dynamic Element Types -->
                            <optgroup label="Dynamic Element Types">
                                <option value="Chip View" data-cond="chip-view">Chip View</option>
                                <option value="Expandable-Dropdown" data-cond="expandable-dropdown">
                                    Expandable Dropdown</option>
                                <option value="Checkbox-Dropdown" data-cond="checkbox-dropdown">
                                    Checkbox Dropdown</option>
                                <option value="Button-Dropdown" data-cond="button-dropdown">Button
                                    Dropdown</option>
                                <option value="Icon-Dropdown" data-cond="icon-dropdown">Icon
                                    Dropdown</option>
                                <option value="Checkbox-Row-Table" data-cond="checkbox-row-table">
                                    Checkbox Row Table</option>
                                <option value="Checkbox-Column-Table" data-cond="checkbox-column-table">Checkbox Column
                                    Table</option>
                                <option value="Multiple-Text-Fields" data-cond="multiple-text-fields">Multiple Text
                                    Fields</option>
                                <option value="Checklist" data-cond="checklist">Checklist</option>
                                <option value="Dynamic-Textbox" data-cond="dynamic-textbox">Dynamic
                                    Textbox</option>
                                <option value="Data Grid" data-cond="data-grid">Data Grid</option>
                                <option value="Scrollable-Description" data-cond="scrollable-description">Scrollable
                                    Description
                                </option>
                                <option value="MultiSelect-Grid" data-cond="multiselect-grid">
                                    MultiSelect Grid</option>
                                <option value="Progress-Bar" data-cond="progress-bar">Progress Bar
                                </option>
                                <option value="Orderable-List" data-cond="orderable-list">Orderable
                                    List</option>
                                <option value="Sliders-with-Result" data-cond="sliders-with-result">
                                    Sliders with Result</option>
                                <option value="Range-Slider" data-cond="range-slider">Range Slider
                                </option>
                                <option value="Code-Editor" data-cond="code-editor">Code Editor
                                </option>
                                <option value="Color-Picker" data-cond="color-picker">Color Picker
                                </option>
                                <option value="Cloth-Size" data-cond="cloth-size">Cloth Size
                                </option>
                                <option value="Shoe-Size" data-cond="shoe-size">Shoe Size</option>
                                <option value="Text-Editor" data-cond="text-editor">Text Editor
                                </option>
                            </optgroup>

                            <!-- Date & Time Types -->
                            <optgroup label="Date & Time Types">
                                <option value="Date" data-cond="date">Date</option>
                                <option value="Date-Time" data-cond="date-time">Date & Time
                                </option>
                                <option value="Last-Date" data-cond="last-date">Last Date</option>
                                <option value="Previous-Date" data-cond="previous-date">Previous
                                    Date</option>
                                <option value="Date-Range" data-cond="date-range">Date Range
                                </option>
                                <option value="Time" data-cond="time">Time</option>
                                <option value="Timer" data-cond="timer">Timer</option>
                                <option value="Date-Reservation" data-cond="date-reservation">Date
                                    Reservation</option>
                            </optgroup>

                            <!-- Media -->
                            <optgroup label="Media">
                                <option value="Logo" data-cond="logo">Logo</option>
                                <option value="Image" data-cond="image">Image</option>
                                <option value="Banner" data-cond="banner">Banner</option>
                                <option value="Album" data-cond="album">Album</option>
                                <option value="Video" data-cond="video">Video</option>
                                <option value="Files" data-cond="files">Files</option>
                                <option value="Presentation" data-cond="presentation">Presentation
                                </option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-bold">Live Preview:</label>
                        <div id="fieldPreview" class="border rounded p-2 bg-light"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveFieldSettingsBtn" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).on('click', '.open-share-modal', function() {
    const formName = $(this).data('form-name');
    const formUrl = $(this).data('form-url');

    $('#formNameToShare').text(`"${formName}"`);
    $('#whatsappShare').attr('href', `https://wa.me/?text=${encodeURIComponent(formUrl)}`);
    $('#facebookShare').attr('href',
        `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(formUrl)}`);
    $('#twitterShare').attr('href', `https://twitter.com/intent/tweet?url=${encodeURIComponent(formUrl)}`);
    $('#copyFormLink').attr('data-url', formUrl);
});

$(document).on('click', '#copyFormLink', function() {
    const url = $(this).data('url');
    navigator.clipboard.writeText(url).then(function() {
        alert('Link copied to clipboard!');
    }, function() {
        alert('Failed to copy link.');
    });
});
</script>

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

function updateLabelText(levelId, labelId) {
    const select = document.getElementById(levelId);
    const label = document.getElementById(labelId);
    const selectOption = select.options[select.selectedIndex];
    label.textContent = selectOption.value ? selectOption.text : '';
}

function buildForm(steps) {
    let tabs = '';
    let content = '';

    // Common wrapper with buttons for all fields
    const wrapField = (label, html, stepIndex, fieldIndex) => `
        <div class="mb-3 position-relative border rounded p-2"
             data-step-index="${stepIndex}" 
             data-field-index="${fieldIndex}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="mb-0 fw-bold">${label}</label>
                <div>
                    <span class="ms-2 text-danger fw-bold fs-5 remove-field-btn" 
                          title="Remove Field" style="cursor:pointer;">×</span>
                    <span class="ms-2 text-primary fw-bold fs-5 field-setting-btn" 
                          title="Field Setting" style="cursor:pointer;">⋮</span>
                </div>
            </div>
            ${html}
        </div>
    `;

    steps.forEach((s, i) => {
        const active = i === 0 ? 'active' : '';
        const show = i === 0 ? 'show active' : '';

        // Tabs
        tabs += `
            <button class="nav-link ${active}" id="tab-${s.id}-tab" data-bs-toggle="pill"
                data-bs-target="#tab-${s.id}" type="button" role="tab"
                aria-controls="tab-${s.id}" aria-selected="${i === 0}">
                ${s.name}
            </button>
        `;

        let tabContent = '';
        s.child.forEach((f, idx) => {
            const name = f.name || `field_${idx}`;
            const safeName = name.replace(/\s+/g, '_').toLowerCase();
            const func = (f.functionality || 'text').toLowerCase();
            const children = Array.isArray(f.child) ? f.child : [];

            if (func === 'text') {
                tabContent += wrapField(name,
                    `<input type="text" name="${safeName}" class="form-control">`, i, idx);
            } else if (func === 'optional') {
                tabContent += wrapField(name,
                    `<select name="${safeName}_id" class="form-select">
                        <option value="">--select--</option>
                        ${children.map(o => `<option value="${o.id}">${o.name}</option>`).join('')}
                    </select>`, i, idx
                );
            } else if (func === 'checkbox') {
                const checkboxes = children.map((o, index) => {
                    const checkboxId = `${safeName}_${index}`;
                    return `
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="${safeName}[]" 
                                   value="${o.name}" id="${checkboxId}">
                            <label class="form-check-label" for="${checkboxId}">${o.name}</label>
                        </div>
                    `;
                }).join('');
                tabContent += wrapField(name, checkboxes, i, idx);
            } else if (func === 'radio') {
                const radios = (children.length ? children.map(o => o.name) : ['Yes', 'No'])
                    .map((v, index) => {
                        const radioId = `${safeName}_${index}`;
                        return `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="${safeName}" value="${v}" id="${radioId}">
                                <label class="form-check-label" for="${radioId}">${v}</label>
                            </div>
                        `;
                    }).join('');
                tabContent += wrapField(name, radios, i, idx);
            } else if (func === 'files' || func === 'presentation') {
                tabContent += wrapField(name,
                    `<input class="form-control" type="file" name="${safeName}">`, i, idx);
            }
            else if(func === 'multiselect')
                {
                    tabContent += wrapField(name, `<select name="${safeName}[]" class="form-select" multiple>
                ${children.map(o=> `<option value="${o.id}">${o.name} </option>`).join('')}
                </select>`, i, idx
                    );
                } 
                else if(func === 'email')
                {
                    tabContent += wrapField(name, `<input type="email" name="${safeName}" class="form-control">`, i, idx);
                }
                else if(func === 'contact-number')
                {
                    tabContent += wrapField(name, `<input type="tel" name="${safeName}" class="form-control" pattern="[0-9]{10}">`, i, idx);
                }
                else if(func === 'description')
                {
                    tabContent += wrapField(name, `<textarea name="${safeName}" class="form-control" rows="3"></textarea>`, i, idx);
                }
                else if(func === 'unit')
                {
                    tabContent += wrapField(name, `<input name="${safeName}" type="text" class="form-control" placeholder="Unit">`, i, idx);
                }
                else if(func === 'price')
                {
                    tabContent += wrapField(name, `<input type="number" name="${safeName}" class="form-control" placeholder="Price">`, i, idx);
                }
               else if(func === 'rating')
               {
                 tabContent += wrapField(name, `<input type="number" name="${safeName}" class="form-control" min="0" max="5" step="0.1">`,i, idx);
               }
               else if(func === 'range')
               {
                tabContent += wrapField(name, `<input type="range" name="${safeName}" class="form-range" min="0" max="100">`, i, idx );
               }
               else if(func === 'review')
               {
                tabContent += wrapField(name, `<textarea name="${safeName}" class="form-control" rows="4" placeholder="write your review"></textarea>`, i, idx);
               }
               else if(func === 'table')
               {
                tabContent += wrapField(name,`<table class="table table-bordered"><tr><th>column1</th><th>column 2</th></tr><table>`,i, idx);
               }
               else if(func === 'table-checkbox')
               {
                tabContent += wrapField(name, `<table class="table table-bordered">
                                            <tr><th>Select</th><th> Item</th><tr>
                                            ${children.map(o=> `
                                            <tr>
                                            <td><input name="${safeName}[]" type="checkbox" value="${o.name}"></td>
                                            <td>${o.name}</td>
                                            </tr>

                `).join('')}
                </table>`, i, idx);
               }
              else if(func === 'column-table')
              {
                tabContent += wrapField(name,`<table class="table table-striped"><tr><th>Column A</th><th> Column B</th></tr><table>`, i, idx);
              }
              else if(func === 'logo' || func === 'image' || func === 'banner' || func === 'album')
              {
                tabContent += wrapField(name, `<input class="form-control" type="file" name="${safeName}" accept="image/*">`,i, idx);
              }
               else if(func === 'video')
               {
                tabContent += wrapField(name, `<input class="form-control" type="file" accept="video/*"name="${safeName}">`,i , idx);
               }
               else if(func === 'date')
               {
                 tabContent += wrapField(name, `<input type="date" class="form-control" name="${safaName}">`,i, idx);
               }
               else if(func ===  'date-time')
               {
                  tabContent += wrapField(name, `<input type="datetime-local" name="${safeName}" class="form-control">`, i, idx);
               }
               else if(func === 'time')
               {
                 tabContent += wrapField(name, `<input type="time" name="${safeName}" class="form-control">`, i, idx);
               }
            else {
                tabContent += wrapField(name,
                    `<input class="form-control" type="text" name="${safeName}">`, i, idx);
            }
        });

        content +=
            `<div class="tab-pane fade ${show}" id="tab-${s.id}" role="tabpanel" aria-labelledby="tab-${s.id}-tab">${tabContent}</div>`;
    });

    document.getElementById('formTabs').innerHTML = tabs;
    document.getElementById('formTabsContent').innerHTML = content;
    document.getElementById('dynamicForm').style.display = 'block';

    // bind remove events
    bindDynamicFormRemoveButtons(steps);
    bindFieldSettingButtons(steps);
}

function bindDynamicFormRemoveButtons(steps) {
    document.querySelectorAll('.remove-field-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const field = e.target.closest('[data-step-index][data-field-index]');
            const stepIndex = parseInt(field.dataset.stepIndex);
            const fieldIndex = parseInt(field.dataset.fieldIndex);

            if (!isNaN(stepIndex) && !isNaN(fieldIndex)) {
                // Remove from data
                steps[stepIndex].child.splice(fieldIndex, 1);
                // Rebuild form with updated steps
                buildForm(steps);
            }
        });
    });
}



function bindFieldSettingButtons(steps) {
    const modalEl = document.getElementById('fieldSettingsModal');
    const bootstrapModal = new bootstrap.Modal(modalEl);
    const fieldPreview = document.getElementById('fieldPreview');

    document.querySelectorAll('.field-setting-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const fieldDiv = e.target.closest('[data-step-index][data-field-index]');
            if (!fieldDiv) return;

            const stepIndex = parseInt(fieldDiv.dataset.stepIndex);
            const fieldIndex = parseInt(fieldDiv.dataset.fieldIndex);
            if (isNaN(stepIndex) || isNaN(fieldIndex)) return;

            const fieldData = steps[stepIndex].child[fieldIndex];

            document.getElementById('fieldNameInput').value = fieldData.name || '';
            document.getElementById('fieldTypeInput').value = fieldData.functionality || 'text';
            document.getElementById('fieldTypeSelect').value = fieldData.functionality || 'text';

            modalEl.dataset.stepIndex = stepIndex;
            modalEl.dataset.fieldIndex = fieldIndex;

            // Show live preview
            updateFieldPreview(fieldData.functionality || 'text', fieldData.name);

            bootstrapModal.show();
        });
    });

    // Live preview when dropdown changes
    document.getElementById('fieldTypeSelect').addEventListener('change', function() {
        const stepIndex = parseInt(modalEl.dataset.stepIndex);
        const fieldIndex = parseInt(modalEl.dataset.fieldIndex);
        if (isNaN(stepIndex) || isNaN(fieldIndex)) return;

        const newType = this.value;
        const name = document.getElementById('fieldNameInput').value || 'Field';
        updateFieldPreview(newType, name);
    });

    // Save button
    document.getElementById('saveFieldSettingsBtn').onclick = function() {
        const stepIndex = parseInt(modalEl.dataset.stepIndex);
        const fieldIndex = parseInt(modalEl.dataset.fieldIndex);
        if (isNaN(stepIndex) || isNaN(fieldIndex)) return;

        const newName = document.getElementById('fieldNameInput').value.trim();
        const newType = document.getElementById('fieldTypeSelect').value;

        if (newName) steps[stepIndex].child[fieldIndex].name = newName;
        if (newType) steps[stepIndex].child[fieldIndex].functionality = newType;

        buildForm(steps);
        bootstrapModal.hide();
    };

    // Helper for preview rendering
    function updateFieldPreview(type, label) {
        label = label || 'Field';
        type = type.toLowerCase();
        let html = '';

        if (type === 'text') {
            html = `<input type="text" class="form-control" placeholder="${label}">`;
        } else if (type === 'optional') {
            html = `<select class="form-select"><option>-- Select --</option></select>`;
        } else if (type === 'checkbox') {
            html =
                `<div class="form-check"><input class="form-check-input" type="checkbox"><label class="form-check-label">${label}</label></div>`;
        } else if (type === 'radio') {
            html =
                `<div class="form-check"><input class="form-check-input" type="radio" name="preview"><label class="form-check-label">${label}</label></div>`;
        } else if (type === 'files') {
            html = `<input type="file" class="form-control">`;
        } else {
            html = `<input type="text" class="form-control" placeholder="${label}">`;
        }

        fieldPreview.innerHTML = html;
    }
}


// Event listeners for cascading dropdowns
['level1', 'level2', 'level3'].forEach((id, idx) => {
    document.getElementById(id).addEventListener('change', function() {
        const level = idx + 2;
        resetFrom(level);
        updateLabelText(id, 'label' + (idx + 1) + 'Text');

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
                document.getElementById('embedContainer').style.display = 'block';

                setTimeout(() => {
                    const embedHTML = document.getElementById('dynamicForm').innerHTML;
                    const encodedHTML = embedHTML
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');
                    document.getElementById('embedHtmlCode').innerHTML = encodedHTML;
                    document.getElementById('embedHtmlContainer').style.display = 'block';
                }, 300);
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

<script>
let pendingChipViews = [];

let previewType = 'default';
let layoutClass = 'col-md-12';
let draggedElement = null;

let formStructure = []; // [{ label: 'Group 1', elements: [{ label: 'Name' }] }]



document.getElementById('previewType').addEventListener('change', function() {
    previewType = this.value;
    console.log(previewType);
    renderPreviewLayout();


});

document.getElementById('layoutSelect').addEventListener('change', function() {
    layoutClass = this.value;
    applyLayout();
});

function applyLayout() {
    document.querySelectorAll('.form-element').forEach(el => {
        el.className = `form-element ${layoutClass}`;

    });
}


window.addEventListener('DOMContentLoaded', () => {
    bindSidebarDragEvents();
    addNewGroup(); // Default group
    renderPreviewLayout();
    bindSidebarClickEvent();
});

function addNewGroup() {
    const groupLabel = `Group ${formStructure.length + 1}`;
    formStructure.push({
        label: groupLabel,
        elements: [],
        columns: 1, // default: 1-column layout
        addMoreBlocks: []
    });


    renderPreviewLayout();
}

function renderPreviewLayout() {
    const container = document.getElementById('formCanvas');

    container.innerHTML = '';

    //regular preview rendering

    let html = '';
    if (previewType === 'horizontal-tabs') {
        html = `<ul class="nav nav-tabs mb-3" id="tabHeaders"></ul><div class="tab-content" id="tabContents"></div>`;
    } else if (previewType === 'vertical-tabs') {
        html = `
    <div class="row">
      <div class="col-md-3"><ul class="nav flex-column nav-pills" id="tabHeaders"></ul></div>
      <div class="col-md-9"><div class="tab-content" id="tabContents"></div></div>
    </div>`;
    } else if (previewType === 'multi-step') {
        html = `<div id="stepNav" class="d-flex gap-2 mb-3"></div><div class="tab-content" id="tabContents"></div>`;
    } else {
        html = `<div class="accordion" id="formAccordion"></div>`;
    }

    container.innerHTML = html;

    formStructure.forEach((group, index) => {

        renderGroup(group, index);
    });

    bindSidebarDragEvents(); // ✅ For dragging
    bindFieldRemoveButtons();
    bindSidebarClickEvent();

    if (typeof pendingChipViews !== 'undefined') {
        pendingChipViews.forEach(({
            label,
            options
        }) => {
            setTimeout(() => initChipView(label, options), 0);
        });
        pendingChipViews = []; // Clear after running
    }

}




function renderGroup(group, index) {
    const groupId = `group-${index + 1}`;
    const label = group.label || `Group ${index + 1}`;

    const viewType = group.viewType || previewType; // ✅ use group-level type if available


    if (viewType === 'horizontal-tabs' || viewType === 'vertical-tabs') {
        const tabHeaders = document.getElementById('tabHeaders');
        const tabContents = document.getElementById('tabContents');
        const tabId = `tab-${groupId}`;

        const tab = document.createElement('li');
        tab.className = 'nav-item';
        tab.innerHTML =
            `<a class="nav-link ${index === 0 ? 'active' : ''}" data-bs-toggle="tab" href="#${tabId}">${label}</a>`;
        tabHeaders.appendChild(tab);

        const pane = document.createElement('div');
        pane.className = `tab-pane fade ${index === 0 ? 'show active' : ''}`;
        pane.id = tabId;

        if (group.groups && Array.isArray(group.groups)) {
            group.groups.forEach((subGroup, subIndex) => {
                pane.innerHTML += getGroupContent(subGroup, `${index}-${subIndex}`);
            });
        } else {
            pane.innerHTML = getGroupContent(group, index);
        }

        tabContents.appendChild(pane);

    } else if (viewType === 'multi-step') {
        const nav = document.getElementById('stepNav');
        nav.innerHTML += `<button class="btn btn-outline-primary">${label}</button>`;

        const content = document.getElementById('tabContents');
        let innerHTML = '';

        if (group.groups && Array.isArray(group.groups)) {
            group.groups.forEach((subGroup, subIndex) => {
                innerHTML += getGroupContent(subGroup, `${index}-${subIndex}`);
            });
        } else {
            innerHTML = getGroupContent(group, index);
        }

        content.innerHTML += `<div class="tab-pane fade show active">${innerHTML}</div>`;

    } else if (viewType === 'tile-view') {
        const wrapper = document.getElementById('formAccordion');
        const tile = document.createElement('div');
        tile.className = 'card shadow-sm mb-3';

        let content = '';

        if (group.groups && Array.isArray(group.groups)) {
            group.groups.forEach((subGroup, subIndex) => {
                content += getGroupContent(subGroup, `${index}-${subIndex}`);
            });
        } else {
            content = getGroupContent(group, index);
        }

        tile.innerHTML = `
            <div class="card-header fw-bold">${label}</div>
            <div class="card-body">
                ${content}
            </div>
        `;

        wrapper.appendChild(tile);

    } else if (viewType === 'result-view') {
        const wrapper = document.getElementById('formAccordion');
        const resultBox = document.createElement('div');
        resultBox.className = 'border p-3 mb-3 bg-light';

        let content = '';

        if (group.groups && Array.isArray(group.groups)) {
            group.groups.forEach((subGroup, subIndex) => {
                content += getGroupContent(subGroup, `${index}-${subIndex}`);
            });
        } else {
            content = getGroupContent(group, index);
        }

        resultBox.innerHTML = `
            <h5 class="fw-semibold">${label}</h5>
            ${content}
        `;

        wrapper.appendChild(resultBox);

    } else {
        // Default: Accordion view (for all other types or fallback)
        const wrapper = document.getElementById('formAccordion');
        const item = document.createElement('div');
        item.className = 'accordion-item mb-3 border';

        let groupBodyContent = '';

        if (group.groups && Array.isArray(group.groups)) {
            group.groups.forEach((subGroup, subIndex) => {
                groupBodyContent += getGroupContent(subGroup, `${index}-${subIndex}`);
            });
        } else {
            groupBodyContent = getGroupContent(group, index);
        }

        item.innerHTML = `
            <h2 class="accordion-header" id="acc-${groupId}">
                <div class="d-flex justify-content-between px-3 py-2 bg-light box-shadow-none rounded-top">
                    <div contenteditable="true" class="editable-title">${label}</div>
                    <button class="btn btn-sm btn-danger" onclick="removeGroup(${index})">&times;</button>
                </div>
            </h2>
            <div class="accordion-collapse collapse show">
                ${groupBodyContent}
            </div>
        `;

        wrapper.appendChild(item);
    }
}



function addMoreToGroup(groupIndex) {
    const label = `Field ${formStructure[groupIndex].elements.length + 1}`;
    formStructure[groupIndex].elements.push({
        label: label,
        functionality: 'text' // default or let user pick later
    });

    renderPreviewLayout();
}




function renderInputByFunctionality(el) {
    const label = el.label || '';
    const functionality = (el.functionality || 'text').toLowerCase();
    const options = el.options || [];

    switch (functionality) {
        // === Standard Types ===

        case 'optional':
        case 'multiselect':
            return `
                <select class="form-control" ${functionality === 'multiselect' ? 'multiple' : ''}>
                    <option value="">Select ${label}</option>
                    ${options.map(opt => `<option>${opt}</option>`).join('')}
                </select>
            `;

        case 'radio':
            console.log('radio');
            return options.length ? `
                <div>
                    ${options.map((opt, i) => `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${label}" id="${label}-${i}">
                            <label class="form-check-label" for="${label}-${i}">${opt}</label>
                        </div>`).join('')}
                </div>` : `<input type="text" class="form-control" placeholder="${label}">`;

        case 'checkbox':
            return options.length ? `
                <div>
                    ${options.map((opt, i) => `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="${label}" id="${label}-${i}">
                            <label class="form-check-label" for="${label}-${i}">${opt}</label>
                        </div>`).join('')}
                </div>` : `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="${label}">
                    <label class="form-check-label" for="${label}">${label}</label>
                </div>
            `;

        case 'text':
        case 'unit':
        case 'price':
        case 'code editor':
        case 'text editor':
        case 'dynamic textbox':
        case 'multiple text fields':
            return `<input type="text" class="form-control" placeholder="${label}">`;

        case 'description':
        case 'scrollable description':
            return `<textarea class="form-control" placeholder="${label}"></textarea>`;

        case 'range':
        case 'range slider':
        case 'sliders with result':
            return `
                <label for="rangeInput-${label}">Select Range (1 to 100):</label>
                <input type="range" id="rangeInput-${label}" name="range" min="1" max="100" value="50"
                       oninput="document.getElementById('rangeValue-${label}').textContent = this.value">
                <span id="rangeValue-${label}">50</span>
            `;

        case 'review':
            return `
                <label for="reviewInput-${label}">Write your Review:</label><br>
                <textarea id="reviewInput-${label}" name="review" rows="4" cols="50" placeholder="Write your experience here..."></textarea>
            `;

        case 'rating':
            return `
                <style>
                    .rating-stars input { display: none; }
                    .rating-stars label {
                        font-size: 24px;
                        color: lightgray;
                        cursor: pointer;
                    }
                    .rating-stars input:checked ~ label,
                    .rating-stars label:hover,
                    .rating-stars label:hover ~ label {
                        color: gold;
                    }
                </style>
                <label>Rate Us:</label>
                <div class="rating-stars">
                    <input type="radio" id="star5-${label}" name="rating-${label}" value="5"><label for="star5-${label}">★</label>
                    <input type="radio" id="star4-${label}" name="rating-${label}" value="4"><label for="star4-${label}">★</label>
                    <input type="radio" id="star3-${label}" name="rating-${label}" value="3"><label for="star3-${label}">★</label>
                    <input type="radio" id="star2-${label}" name="rating-${label}" value="2"><label for="star2-${label}">★</label>
                    <input type="radio" id="star1-${label}" name="rating-${label}" value="1"><label for="star1-${label}">★</label>
                </div>
            `;


        case 'date':
        case 'last date':
        case 'previous date':
            return `<input type="date" class="form-control" placeholder="${label}">`;

        case 'date & time':
            return `<input type="datetime-local" class="form-control" placeholder="${label}">`;

        case 'date range':
            return `
                <div class="d-flex gap-2">
                    <input type="date" class="form-control" placeholder="Start ${label}">
                    <input type="date" class="form-control" placeholder="End ${label}">
                </div>`;

        case 'time':
            return `<input type="time" class="form-control" placeholder="${label}">`;

        case 'timer':
            return `<input type="number" class="form-control" placeholder="Set timer in seconds">`;

        case 'date reservation':
            return `<input type="date" class="form-control" placeholder="Reserve ${label}">`;

            // === Media ===
        case 'logo':
        case 'image':
        case 'banner':
        case 'album':
            return `<input type="file" class="form-control" accept="image/*">`;

        case 'video':
            return `<input type="file" class="form-control" accept="video/*">`;

        case 'files':
        case 'presentation':
            return `<input type="file" class="form-control" multiple>`;

            // === Advanced UI Elements ===
        case 'chip view':
            pendingChipViews.push({
                label,
                options: el.options || []
            });

            return `
        <div class="chip-view-wrapper position-relative">
            <input type="hidden" name="chip_view_data_${label}" id="chipData-${label}">
            <label class="label" for="chipInput-${label}">${label}</label>
            <input class="form-control" type="text" id="chipInput-${label}" placeholder="Type and press Enter or comma..." autocomplete="off">
            <div id="chipSuggestions-${label}" class="chip-suggestions dropdown-menu show" style="display: none; position: absolute; z-index: 999; width: 100%;"></div>
            <div class="chip-container mt-2 d-flex flex-wrap gap-2" id="chipContainer-${label}"></div>
        </div>
    `;





        case 'expandable dropdown':

        case 'checkbox dropdown':
            return `
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="chkDropdown-${label}" data-bs-toggle="dropdown" aria-expanded="false">
                ${label} <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu p-2" aria-labelledby="chkDropdown-${label}" style="min-width: 200px;">
                ${options.length ? options.map((opt, i) => `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="chk-${label}-${i}">
                        <label class="form-check-label" for="chk-${label}-${i}">${opt}</label>
                    </div>
                `).join('') : '<span class="dropdown-item text-muted">No options</span>'}
            </div>
        </div>
    `;

        case 'button dropdown':
            return `
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="btnDropdown-${label}" data-bs-toggle="dropdown" aria-expanded="false">
                ${label} <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnDropdown-${label}">
                ${options.length ? options.map(opt => `<a class="dropdown-item" href="#">${opt}</a>`).join('') : '<span class="dropdown-item text-muted">No items</span>'}
            </div>
        </div>
    `;

        case 'icon dropdown':
            return `
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="iconDropdown-${label}" data-bs-toggle="dropdown" aria-expanded="false">
                ${label} <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="iconDropdown-${label}">
                ${options.length ? options.map(opt => `
                    <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                        <i class="mdi mdi-star-outline"></i> ${opt}
                    </a>
                `).join('') : '<span class="dropdown-item text-muted">No icons</span>'}
            </div>
        </div>
    `;

        case 'cloth size':
        case 'shoe size':
        case 'multiselect grid':
        case 'checklist':
        case 'orderable list':
        case 'progress bar':
            return `<div class="border p-2 rounded bg-light">[${functionality}] Placeholder Component</div>`;

        case 'color picker':
            return `<input type="color" class="form-control form-control-color">`;

            // === Table & Grid ===
        case 'table':
        case 'table checkbox':
        case 'column table':
        case 'checkbox row table':
            return `
        <div class="checkbox-table-wrapper mb-3" id="tableWrapper-${label}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <input type="text" class="form-control form-control-sm editable-table-name" id="tableTitle-${label}" value="${label}" style="font-weight: bold; max-width: 300px;" />
                <button class="btn btn-sm btn-warning" onclick="duplicateCheckboxTable('${label}')">Duplicate Table</button>
            </div>

            <!-- Global settings panel -->
            <div class="mb-3 p-2 bg-light border rounded" id="settingsPanel-${label}" style="display: none;">
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <div>
                        <strong>Selected:</strong>
                        <span id="selectedType-${label}">None</span> →
                        <span id="selectedTarget-${label}">—</span>
                    </div>

                    <button class="btn btn-sm btn-outline-secondary" onclick="toggleSelectedType()">Toggle Type</button>

                    <div class="input-group input-group-sm" style="max-width: 300px;">
                        <input type="text" class="form-control" id="globalOptionInput-${label}" placeholder="Add Dropdown Option">
                        <button class="btn btn-success" onclick="addOptionToSelected()">+</button>
                    </div>

                    <button class="btn btn-sm btn-danger" onclick="removeSelectedTarget()">Remove Selected</button>
                </div>
            </div>

            <!-- Row & Column controls -->
            <div class="mb-2 d-flex flex-wrap gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Add Row Label" id="addRowInput-${label}" />
                <button type="button" class="btn btn-sm btn-primary" onclick="addRowToCheckboxTable('${label}')">Add Row</button>
                <input type="text" class="form-control form-control-sm" placeholder="Add Column Label" id="addColInput-${label}" />
                <button type="button" class="btn btn-sm btn-secondary" onclick="addColToCheckboxTable('${label}')">Add Column</button>
            </div>

            <table class="table table-bordered table-sm" id="checkboxTable-${label}">
                <thead><tr><th></th></tr></thead>
                <tbody></tbody>
            </table>
        </div>
    `;





        case 'checkbox column table':
        case 'data grid':
            return `<div class="border p-3 bg-white rounded">[${functionality}] Table Placeholder</div>`;

            // === Fallback ===
        default:
            return `<input type="text" class="form-control" placeholder="${label}">`;
    }
}

const checkboxTableConfig = {};

let selectedRowKey = null;
let selectedTableLabel = null;


function addRowToCheckboxTable(label) {
    const table = document.getElementById(`checkboxTable-${label}`);
    const rowLabelInput = document.getElementById(`addRowInput-${label}`);
    const rowLabel = rowLabelInput.value.trim();
    if (!rowLabel) return;

    if (!checkboxTableConfig[label]) {
        checkboxTableConfig[label] = {
            rows: {},
            rowsOptions: {}
        };
    }

    const tbody = table.querySelector('tbody');
    const theadRow = table.querySelector('thead tr');
    const colCount = theadRow.children.length - 1;

    const row = document.createElement('tr');
    row.dataset.rowKey = rowLabel;
    row.onclick = () => selectRow(label, rowLabel);

    const toggleButton = `
        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleRowType('${label}', '${rowLabel}')">⚙️</button>
    `;

    const optionInput = `
        <div class="mt-2 d-flex">
            <input type="text" class="form-control form-control-sm" placeholder="Add Option" id="optionInput-${label}-${rowLabel}">
            <button class="btn btn-sm btn-success ms-1" onclick="addOptionToRow('${label}', '${rowLabel}')">+</button>
        </div>
    `;

    row.innerHTML = `<th contenteditable="true">${rowLabel} ${toggleButton}</th>`;

    for (let i = 0; i < colCount; i++) {
        row.innerHTML += `<td><input type="checkbox" /></td>`;
    }

    row.innerHTML += `<td><button class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">×</button></td>`;
    tbody.appendChild(row);

    // Append the option input area below the row
    const optionRow = document.createElement('tr');
    optionRow.innerHTML = `<td colspan="${colCount + 2}">${optionInput}</td>`;
    tbody.appendChild(optionRow);

    rowLabelInput.value = '';
}


function selectRow(label, rowKey) {
    selectedRowKey = rowKey;
    selectedTableLabel = label;

    document.querySelectorAll(`#checkboxTable-${label} tbody tr`).forEach(r => r.classList.remove('table-primary'));
    const selectedRow = Array.from(document.querySelectorAll(`#checkboxTable-${label} tbody tr`)).find(r => r.dataset
        .rowKey === rowKey);
    if (selectedRow) selectedRow.classList.add('table-primary');

    document.getElementById(`settingsPanel-${label}`).style.display = 'block';
    document.getElementById(`selectedRowLabel-${label}`).textContent = rowKey;
}

function toggleSelectedRowType() {
    if (!selectedTableLabel || !selectedRowKey) return;
    const config = checkboxTableConfig[selectedTableLabel];
    const type = config.rows[selectedRowKey] === 'dropdown' ? 'checkbox' : 'dropdown';
    config.rows[selectedRowKey] = type;

    normalizeTableRows(selectedTableLabel);
}

function addOptionToSelectedRow() {
    if (!selectedTableLabel || !selectedRowKey) return;
    const input = document.getElementById(`globalOptionInput-${selectedTableLabel}`);
    const val = input.value.trim();
    if (!val) return;

    if (!checkboxTableConfig[selectedTableLabel].rowsOptions[selectedRowKey]) {
        checkboxTableConfig[selectedTableLabel].rowsOptions[selectedRowKey] = [];
    }

    checkboxTableConfig[selectedTableLabel].rowsOptions[selectedRowKey].push(val);
    input.value = '';
    normalizeTableRows(selectedTableLabel);
}

function addColToCheckboxTable(label) {
    const table = document.getElementById(`checkboxTable-${label}`);
    const colLabelInput = document.getElementById(`addColInput-${label}`);
    const colLabel = colLabelInput.value.trim();
    if (!colLabel) return;

    const theadRow = table.querySelector('thead tr');

    // Add editable column header
    const th = document.createElement('th');
    th.setAttribute('contenteditable', 'true');
    th.textContent = colLabel;
    theadRow.appendChild(th);

    // Add checkbox to each row
    const rows = table.querySelectorAll(`#checkboxTable-${label} tbody tr`);
    rows.forEach(row => {
        row.innerHTML += `<td><input type="checkbox" /></td>`;
    });

    colLabelInput.value = '';
    normalizeTableRows(label);
}

function normalizeTableRows(label) {
    const table = document.getElementById(`checkboxTable-${label}`);
    const config = checkboxTableConfig[label] || {
        rows: {},
        rowsOptions: {}
    };
    const theadRow = table.querySelector('thead tr');
    const desiredTdCount = theadRow.children.length - 1;
    const tbody = table.querySelector('tbody');

    const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => r.dataset.rowKey);

    rows.forEach(row => {
        const rowKey = row.dataset.rowKey;
        const inputType = config.rows?. [rowKey] || 'checkbox';
        const options = config.rowsOptions?. [rowKey] || [];

        const toggleBtn = `
            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleRowType('${label}', '${rowKey}')">⚙️</button>
        `;

        row.innerHTML = `<th contenteditable="true">${rowKey} ${toggleBtn}</th>`;
        for (let i = 0; i < desiredTdCount; i++) {
            row.innerHTML += `<td>${
                inputType === 'dropdown'
                    ? `<select class="form-select form-select-sm">${options.map(o => `<option>${o}</option>`).join('')}</select>`
                    : `<input type="checkbox" />`
            }</td>`;
        }
        row.innerHTML +=
            `<td><button class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">×</button></td>`;
    });
}


function toggleRowType(label, rowKey) {
    const config = checkboxTableConfig[label] || {
        rows: {},
        rowsOptions: {}
    };
    config.rows[rowKey] = config.rows[rowKey] === 'dropdown' ? 'checkbox' : 'dropdown';
    if (!config.rowsOptions[rowKey]) {
        config.rowsOptions[rowKey] = ['Option 1'];
    }
    checkboxTableConfig[label] = config;
    normalizeTableRows(label); // Re-render
}

function addOptionToRow(label, rowKey) {
    const input = document.getElementById(`optionInput-${label}-${rowKey}`);
    const value = input?.value.trim();
    if (!value) return;

    if (!checkboxTableConfig[label].rowsOptions) checkboxTableConfig[label].rowsOptions = {};
    if (!checkboxTableConfig[label].rowsOptions[rowKey]) checkboxTableConfig[label].rowsOptions[rowKey] = [];

    checkboxTableConfig[label].rowsOptions[rowKey].push(value);
    input.value = '';
    normalizeTableRows(label); // Re-render table with new option
}




function duplicateCheckboxTable(label) {
    const wrapper = document.getElementById(`tableWrapper-${label}`);
    const newLabel = `${label}-${Date.now()}`;

    const cloneHtml = wrapper.innerHTML
        .replaceAll(label, newLabel);

    const cloneWrapper = document.createElement('div');
    cloneWrapper.className = 'checkbox-table-wrapper mb-3';
    cloneWrapper.id = `tableWrapper-${newLabel}`;
    cloneWrapper.innerHTML = cloneHtml;

    wrapper.parentNode.insertBefore(cloneWrapper, wrapper.nextSibling);
}


function removeCheckboxTable(label) {
    const wrapper = document.getElementById(`tableWrapper-${label}`);
    if (wrapper) wrapper.remove();
}

function bindFieldRemoveButtons() {
    document.querySelectorAll('.remove-field-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const field = e.target.closest('.form-element');
            const groupIndex = parseInt(field.dataset.groupIndex);
            const elementIndex = parseInt(field.dataset.elementIndex);

            if (!isNaN(groupIndex) && !isNaN(elementIndex)) {
                formStructure[groupIndex].elements.splice(elementIndex, 1);
                renderPreviewLayout();
                bindSidebarDragEvents();
                bindFieldRemoveButtons();
                bindSidebarClickEvent(); // re-attach
            }
        });
    });
}

function getGroupContent(group, groupIndex) {
    let html = `<div class="accordion-body">`;

    if (group.label && !group.hideLabelHeading) {
        html += `<h5 class="mb-2 fw-semibold">${group.label}</h5>`;
    }

    if (!group.hideLayoutSelector) {
        html += `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <select onchange="updateGroupColumns(${groupIndex}, this.value)" class="form-select form-select-sm" style="width: auto;">
                ${[1, 2, 3, 4].map(n => `
                    <option value="${n}" ${group.columns === n ? 'selected' : ''}>${n} Column${n > 1 ? 's' : ''}</option>
                `).join('')}
            </select>
        </div>`;
    }

    html += `
        <div class="p-3 mb-3 rounded drop-zone" data-group-index="${groupIndex}">
        
            <div class="row">
                ${group.elements.map((el, elementIndex) => `
                    <div class="form-element col-md-${12 / (group.columns || 1)}" draggable="true"
                        data-label="${el.label}" 
                        data-functionality="${el.functionality || 'text'}"
                        data-group-index="${groupIndex}" 
                        data-element-index="${elementIndex}">
                        <span class="float-end ms-2 text-danger fw-bold fs-5 remove-field-btn" title="Remove Field" style="cursor:pointer;">×</span>
                        <span class="float-end ms-2 text-danger fw-bold fs-5 " title=" Field Setting" style="cursor:pointer;">⋮</span>

                        <label class="form-label">${el.label}</label>
                        ${renderInputByFunctionality({
                            ...el,
                            options: el.options || []
                        })}
                        ${['select', 'optional', 'radio', 'checkbox', 'multiselect', 'checkbox dropdown', 'button dropdown', 'icon dropdown']
                          .includes((el.functionality || '').toLowerCase()) && !!el.allow_user_options

                            ? getOptionAdderHTML(groupIndex, elementIndex)
                            : ''
                        }


                    </div>
                `).join('')}
            </div>
        </div>
    `;

    if (group.addMoreBlocks && group.addMoreBlocks.length > 0) {
        group.addMoreBlocks.forEach(block => {
            html += `
            <div class="bg-light p-3 mt-3 rounded">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Add More Block</h6>
                    <select onchange="updateBlockColumns(${groupIndex}, '${block.id}', this.value)" class="form-select form-select-sm" style="width: auto;">
                        ${[1, 2, 3, 4].map(n => `
                            <option value="${n}" ${block.columns === n ? 'selected' : ''}>${n} Column${n > 1 ? 's' : ''}</option>
                        `).join('')}
                    </select>
                </div>
                <div class="row drop-zone add-more-drop-zone"
                     data-group-index="${groupIndex}"
                     data-block-id="${block.id}">
                    ${block.fields.map((field, i) => `
                        <div class="form-element col-md-${12 / (block.columns || 1)}" draggable="true"
                             data-label="${field.label}" 
                             data-functionality="${field.functionality}">
                             <span class="float-end ms-2 text-danger fw-bold fs-5 remove-field-btn" title="Remove Field" style="cursor:pointer;">×</span>
                              <span class="float-end ms-2 text-danger fw-bold fs-5 " title="Field Setting" style="cursor:pointer;">⋮</span>
                             <label class="form-label">${field.label}</label>
                             ${renderInputByFunctionality({
                                ...field,
                                options: field.options || []
                             })}
                        </div>
                    `).join('')}
                </div>
            </div>`;
        });
    }

    html += `</div>`; // closing .accordion-body 
    return html;
}


document.addEventListener('dragover', function(e) {
    const zone = e.target.closest('.drop-zone, .add-more-drop-zone');
    if (zone) {
        e.preventDefault();
        zone.classList.add('drop-zone-hover');
    }
});

document.addEventListener('dragleave', function(e) {
    const zone = e.target.closest('.drop-zone, .add-more-drop-zone');
    if (zone) {
        zone.classList.remove('drop-zone-hover');

    }
});


document.addEventListener('drop', function(e) {
    e.preventDefault();

    document.querySelectorAll('.drop-zone-hover').forEach(zone => {
        zone.classList.remove('drop-zone-hover');
    });

    const dropZone = e.target.closest('.drop-zone, .add-more-drop-zone');
    if (!dropZone) return;

    const label = e.dataTransfer.getData('label');
    const functionality = e.dataTransfer.getData('functionality') || 'text';
    const groupview = e.dataTransfer.getData('groupview') || 'text';
    const isForm = e.dataTransfer.getData('isform') || '0';
    const optionsFromDB = draggedElement?.dataset?.options ?
        JSON.parse(draggedElement.dataset.options) : [];


    if (isForm === '1') {
        fetch(`/admin/form-builder/get-child-by-name/${label}`)
            .then(res => res.json())
            .then(children => {
                if (!Array.isArray(children) || children.length === 0) return;

                const formAccordionLabel = label;
                const formGroups = [];
                const simpleElements = [];

                const fetchAllChildren = children.map((groupItem) => {
                    return fetch(`/admin/form-builder/get-child-by-name/${groupItem.name}`)
                        .then(res => res.json())
                        .then(grandChildren => {
                            const optionsArray = grandChildren.map(c => c.name);

                            simpleElements.push({
                                label: groupItem.name,
                                functionality: functionality,
                                options: ['select', 'optional', 'radio', 'checkbox',
                                        'multiselect', 'checkbox dropdown',
                                        'button dropdown', 'icon dropdown'
                                    ].includes(functionality) ?
                                    optionsArray : undefined,
                                //  allow_user_options: allowOptions 
                            });

                        });
                });

                Promise.all(fetchAllChildren).then(() => {
                    if (simpleElements.length > 0) {
                        formGroups.push({
                            label: null,
                            elements: simpleElements,
                            columns: 2,
                            addMoreBlocks: [],
                            hideLabelHeading: true,
                            hideLayoutSelector: true
                        });
                    }

                    formStructure.push({
                        label: formAccordionLabel,
                        elements: [],
                        columns: 1,
                        addMoreBlocks: [],
                        groups: formGroups,
                    });

                    renderPreviewLayout();
                });
            })
            .catch(err => {
                console.error(`❌ Error fetching children for form "${label}":`, err);
            });

        return;
    }


    // 🧩 Custom Handler: LISTVIEW Group Rendering
    const validViewTypes = ['list', 'accordion', 'vertical-tab', 'horizontal-tab', 'tile-view', 'result-view'];
    if (validViewTypes.includes(groupview)) {
        console.log(groupview);
        fetch(`/admin/form-builder/get-child-by-name/${label}`)
            .then(res => res.json())
            .then(children => {
                const subElements = (children || []).map(c => ({
                    label: c.name,
                    functionality: c.functionality || 'text',
                    //  allow_user_options: allowOptions 
                }));

                const group = {
                    label: label,
                    elements: subElements,
                    columns: 2,
                    addMoreBlocks: [],
                    viewType: groupview, // ✅ Store which view type to apply later
                    hideLabelHeading: false,
                    hideLayoutSelector: true // Optional: layout dropdown can be hidden for views like tile or result
                };

                formStructure.push(group);
                renderPreviewLayout();
            })
            .catch(err => {
                console.error(`❌ Error fetching children for ${groupview} "${label}":`, err);
            });

        return; // ✅ Prevent fallback drop
    }



    //
    const type = e.dataTransfer.getData('type') || 'new';

    const groupIndex = parseInt(dropZone.dataset.groupIndex);
    if (isNaN(groupIndex) || !formStructure[groupIndex]) return;

    // 🟩 Dropped "Add More" → create new Add More block
    if (label.toLowerCase() === 'add more') {
        const blockId = 'add-more-' + Date.now();

        if (!formStructure[groupIndex].addMoreBlocks) {
            formStructure[groupIndex].addMoreBlocks = [];
        }

        formStructure[groupIndex].addMoreBlocks.push({
            id: blockId,
            columns: 1,
            fields: []
        });

        renderPreviewLayout();
        return;
    }

    // 🟦 Dropped into existing Add More block
    if (dropZone.classList.contains('add-more-drop-zone')) {
        const blockId = dropZone.dataset.blockId;
        const block = formStructure[groupIndex].addMoreBlocks?.find(b => b.id === blockId);
        if (block) {
            block.fields.push({
                label,
                functionality
            });
            renderPreviewLayout();
            return;
        }
    }

    if (!formStructure[groupIndex].elements) {
        formStructure[groupIndex].elements = [];
    }

    formStructure[groupIndex].elements.push({
        label,
        functionality,
        // allow_user_options: allowOptions,
        options: optionsFromDB
    });





    renderPreviewLayout();
    bindSidebarDragEvents();
    bindSidebarClickEvent();
});




function removeGroup(index) {
    formStructure.splice(index, 1);
    renderPreviewLayout();
}

function bindSidebarDragEvents() {
    // 🧩 Sidebar drag elements (left panel)
    document.querySelectorAll('#elementTabsContent .form-element').forEach(el => {
        const label = el.dataset.label || el.textContent.trim();
        const functionality = el.dataset.functionality || 'text';
        const groupview = el.dataset.groupview || '';
        const isForm = el.dataset.isform || '0'; // ✅ FIXED: lowercase 'data-isform'

        el.setAttribute('draggable', 'true');
        el.setAttribute('data-type', 'new');
        el.setAttribute('data-label', label);
        el.setAttribute('data-functionality', functionality);
        el.setAttribute('data-groupview', groupview);
        el.setAttribute('data-isform', isForm); // ✅ ensure consistency

        el.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('type', 'new');
            e.dataTransfer.setData('label', label);
            e.dataTransfer.setData('functionality', functionality);
            e.dataTransfer.setData('groupview', groupview);
            e.dataTransfer.setData('isform', isForm);
            e.dataTransfer.setData('optionAllowed', el.dataset.optionAllowed || 'off');

        });

        el.addEventListener('dragend', function() {
            draggedElement = null;
        });




    });

    // 🧩 Existing field drag config (form canvas)
    document.querySelectorAll('#formCanvas .form-element').forEach(el => {

        const label = el.dataset.label;
        const functionality = el.dataset.functionality || 'text';
        const groupview = el.dataset.groupview || '';
        const isForm = el.dataset.isform || '0';
        //console.log(functionality);
        el.setAttribute('draggable', 'true');
        el.setAttribute('data-type', 'existing');
        el.setAttribute('data-label', label);
        el.setAttribute('data-functionality', functionality);
        el.setAttribute('data-groupview', groupview);
        el.setAttribute('data-isform', isForm); // ✅ for consistency

        el.addEventListener('dragstart', function(e) {
            draggedElement = this;
            e.dataTransfer.setData('type', 'existing');
            e.dataTransfer.setData('label', label);
            e.dataTransfer.setData('functionality', functionality);
            e.dataTransfer.setData('groupview', groupview);
            e.dataTransfer.setData('isform', isForm);
            e.dataTransfer.setData('optionAllowed', el.dataset.optionAllowed || 'off');

        });

        el.addEventListener('dragend', function() {
            draggedElement = null;
        });
    });


}


function bindSidebarClickEvent() {
    document.querySelectorAll('#elementTabsContent .form-element').forEach(el => {
        const label = el.dataset.label || el.textContent.trim();

        // ✅ Only for Household or Industrial
        if (label === 'Household Products' || label === 'Industrial Products') {

            el.addEventListener('click', function() {
                const functionality = el.dataset.functionality || 'text';
                const groupview = el.dataset.groupview || '';
                const isForm = el.dataset.isform || '0';
                const optionAllowed = el.dataset.optionAllowed || 'off';

                // 🔄 Hide formCanvas
                document.querySelector('#formCanvas').style.display = 'none';

                // 📌 Show specialLayout
                const specialLayout = document.querySelector('#specialLayout');
                specialLayout.style.display = 'block';

                // (Optional) Change heading based on clicked label
                specialLayout.querySelector('.alert').innerText =
                    `Special Layout for ${label}`;

                // (Optional) Prefill product name input
                const productNameInput = specialLayout.querySelector('input[type="text"]');
                if (productNameInput) {
                    productNameInput.value = label;
                }
            });
        }
    });
}

function getOptionAdderHTML(groupIndex, elementIndex) {
    return `
        <div class="mt-2 d-flex align-items-center gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Add option..." 
                   onkeydown="if(event.key==='Enter'){ addOption('${groupIndex}', ${elementIndex}, this); return false; }">
            <button type="button" class="btn btn-sm btn-success" onclick="addOption('${groupIndex}', ${elementIndex}, this.previousElementSibling)">
                +
            </button>
        </div>`;
}


function addOption(groupIndex, elementIndex, inputEl) {
    const val = inputEl.value.trim();
    if (!val) return;

    const group = resolveNestedGroup(groupIndex);
    const el = group?.elements?. [elementIndex];
    //console.log(group);

    if (!el) return;

    if (!Array.isArray(el.options)) {
        el.options = [];
    }

    if (!el.options.includes(val)) {
        el.options.push(val);
    }

    inputEl.value = '';
    renderPreviewLayout();
}


function resolveNestedGroup(indexPath) {
    const path = indexPath.toString().split('-').map(Number);
    let current = formStructure[path[0]];
    for (let i = 1; i < path.length; i++) {
        if (!current || !current.groups) return null;
        current = current.groups[path[i]];
    }
    return current;
}


```
function showFormPreview() {
    let html = '';

    // Check which section is visible/active
    const productTypeVisible = document.getElementById('specialLayout')?.offsetParent !== null;
    const groupFormVisible = document.getElementById('groupFormContainer')?.offsetParent !== null;

    if (productTypeVisible) {
        // Show product type layout only
        const specialLayoutElement = document.getElementById('specialLayout');
        if (specialLayoutElement) {
              const clone = specialLayoutElement.cloneNode(true);
            clone.style.display = 'block'; // Make it visible in preview

            // If you want ALL tabs to be visible in preview
            clone.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.add('show', 'active');
            html += `<div>${specialLayoutElement.innerHTML}</div>`;
        }
    } 
    else if (groupFormVisible) {
        // Show only group form preview
        formStructure.forEach((group) => {
            html += `<h4 class="mt-3">${group.label}</h4>`;
            html += `<div class="border rounded p-3 mb-3 bg-light"><div class="row">`;

            group.elements.forEach(el => {
                html += `
                    <div class="col-md-6 mb-3">
                        <label class="form-label">${el.label}</label>
                        ${renderInputByFunctionality(el)}
                    </div>
                `;
            });

            html += `</div></div>`;
        });
    }

    // Inject HTML into modal and show
    document.getElementById('formPreviewContent').innerHTML = html;
    const modal = new bootstrap.Modal(document.getElementById('formPreviewModal'));
    modal.show();
}```

function updateGroupColumns(groupIndex, cols) {
    formStructure[groupIndex].columns = parseInt(cols);
    renderPreviewLayout();
}

function updateBlockColumns(groupIndex, blockId, cols) {
    const block = formStructure[groupIndex].addMoreBlocks.find(b => b.id === blockId);

    if (block) {
        block.columns = parseInt(cols);
        renderPreviewLayout();
    }
}

function initChipView(label, options) {
    const input = document.getElementById(`chipInput-${label}`);
    const chipBox = document.getElementById(`chipContainer-${label}`);
    const suggestionBox = document.getElementById(`chipSuggestions-${label}`);
    const hiddenInput = document.getElementById(`chipData-${label}`);

    let selectedChips = [];

    function renderSuggestions(matches) {
        suggestionBox.innerHTML = "";
        if (matches.length === 0) {
            suggestionBox.style.display = "none";
            return;
        }

        matches.forEach(opt => {
            const div = document.createElement("div");
            div.className = "dropdown-item";
            div.style.cursor = "pointer";
            div.textContent = opt;
            div.onclick = () => {
                addChip(opt);
                input.value = "";
                suggestionBox.style.display = "none";
            };
            suggestionBox.appendChild(div);
        });

        suggestionBox.style.display = "block";
    }

    function addChip(value) {
        if (!selectedChips.includes(value)) {
            selectedChips.push(value);
            updateChips();
        }
    }

    function removeChip(index) {
        selectedChips.splice(index, 1);
        updateChips();
    }

    function updateChips() {
        chipBox.innerHTML = "";

        selectedChips.forEach((chip, i) => {
            const chipEl = document.createElement("div");
            chipEl.className = "chip d-inline-flex align-items-center";
            chipEl.style =
                "padding: 6px 12px; background-color: #e8f5e9; border-radius: 20px; font-size: 14px; border: 1px solid #66bb6a;";

            const span = document.createElement("span");
            span.textContent = "×";
            span.style = "margin-left: 8px; cursor: pointer; color: red;";
            span.onclick = () => removeChip(i);

            chipEl.textContent = chip + " ";
            chipEl.appendChild(span);
            chipBox.appendChild(chipEl);
        });

        hiddenInput.value = JSON.stringify(selectedChips);
    }

    input.addEventListener("input", () => {
        const val = input.value.trim().toLowerCase();
        if (val.length === 0) {
            suggestionBox.style.display = "none";
            return;
        }
        const matches = options.filter(opt => opt.toLowerCase().includes(val) && !selectedChips.includes(opt));
        renderSuggestions(matches);
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "," || e.key === "Enter") {
            e.preventDefault();
            const value = input.value.trim().replace(/,$/, "");
            if (value) addChip(value);
            input.value = "";
            suggestionBox.style.display = "none";
        }
    });

    document.addEventListener("click", function(e) {
        if (!suggestionBox.contains(e.target) && e.target !== input) {
            suggestionBox.style.display = "none";
        }
    });
}
</script>


@endsection