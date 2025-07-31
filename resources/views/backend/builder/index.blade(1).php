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

    .form-element {
        background: #fff;
        padding: 6px;
        margin-bottom: 2px;
        /*border: 1px solid #ced4da;*/
        /*border-radius: 6px;*/
        cursor: grab;
        width: 32.5%;
        text-align: center;
        font-size: 9px;
    }

    .form-canvas {
        min-height: 80vh;
        padding: 20px;
        border-radius: 6px;
    }

    .form-element.dragging {
        opacity: 0.5;
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
</style>

<div class="row">
    <!-- Left Sidebar -->
    <div class="col-md-4 form-sidebar pe-0">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs bg-white px-2 pt-2" id="elementTabs" role="tablist">
            @foreach ($groupedSubCategories as $key => $items)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ strtolower($key) }}-tab"
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
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $accordionId }}" aria-expanded="false"
                                aria-controls="collapse-{{ $accordionId }}">
                                {{ $parent->name }}
                            </button>
                        </h2>
                        <div id="collapse-{{ $accordionId }}" class="accordion-collapse collapse"
                            aria-labelledby="heading-{{ $accordionId }}"
                            data-bs-parent="#accordion-{{ strtolower($key) }}">
                            <div class="accordion-body left-accordion">
                                @forelse ($children as $child)
                                <div class="form-element" draggable="true" data-label="{{ $child->name }}"
                                    data-functionality="{{ strtolower($child->functionality ?? 'text') }}">

                                    <i class="{{ $child->icon ?? 'fas fa-tag' }} me-2"></i>
                                    <p class=" mb-0">{{ $child->name }}</p>


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


        <div class="form-canvas" id="formCanvasWrapper">
            <div id="formCanvas"></div>

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



<script>
    let previewType = 'default';
    let layoutClass = 'col-md-12';
    let draggedElement = null;

    let formStructure = []; // [{ label: 'Group 1', elements: [{ label: 'Name' }] }]

    document.getElementById('previewType').addEventListener('change', function () {
        previewType = this.value;
        renderPreviewLayout();
    });

    document.getElementById('layoutSelect').addEventListener('change', function () {
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
    });

    function addNewGroup() {
        const groupLabel = `Group ${formStructure.length + 1}`;
        formStructure.push({
            label: groupLabel,
            subgroups: [
                { elements: [] }
            ]
        });

        renderPreviewLayout();
    }

    function renderPreviewLayout() {
        const container = document.getElementById('formCanvas');
        container.innerHTML = '';

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

        bindSidebarDragEvents();     // ✅ For dragging
        bindFieldRemoveButtons();    // ✅ For removing
    }

    function renderGroup(group, index) {
        const groupId = `group-${index + 1}`;
        const label = group.label || `Group ${index + 1}`;

        if (previewType === 'horizontal-tabs' || previewType === 'vertical-tabs') {
            const tabHeaders = document.getElementById('tabHeaders');
            const tabContents = document.getElementById('tabContents');
            const tabId = `tab-${groupId}`;

            const tab = document.createElement('li');
            tab.className = 'nav-item';
            tab.innerHTML = `<a class="nav-link ${index === 0 ? 'active' : ''}" data-bs-toggle="tab" href="#${tabId}">${label}</a>`;
            tabHeaders.appendChild(tab);

            const pane = document.createElement('div');
            pane.className = `tab-pane fade ${index === 0 ? 'show active' : ''}`;
            pane.id = tabId;
            pane.innerHTML = getGroupContent(group, index);
            tabContents.appendChild(pane);

        } else if (previewType === 'multi-step') {
            const nav = document.getElementById('stepNav');
            nav.innerHTML += `<button class="btn btn-outline-primary">${label}</button>`;
            const content = document.getElementById('tabContents');
            content.innerHTML += `<div class="tab-pane fade show active">${getGroupContent(group, index)}</div>`;

        } else {
            const wrapper = document.getElementById('formAccordion');
            const item = document.createElement('div');
            item.className = 'accordion-item mb-3 border';
            item.innerHTML = `
    <h2 class="accordion-header" id="acc-${groupId}">
      <div class="d-flex justify-content-between px-3 py-2 bg-light border-bottom rounded-top">
        <div contenteditable="true" class="editable-title">${label}</div>
        <button class="btn btn-sm btn-danger" onclick="removeGroup(${index})">&times;</button>
      </div>
    </h2>
    <div class="accordion-collapse collapse show">
      ${getGroupContent(group, index)}
    </div>`;
            wrapper.appendChild(item);
        }
    }

    function getGroupContent(group, groupIndex) {
        return `
    <div class="accordion-body">
        <div class="border rounded p-3 mb-3 drop-zone" data-group-index="${groupIndex}">
            <div class="row">
              ${group.subgroups?.map((subgroup, subgroupIndex) => `
                  <div class="border p-3 mb-3 bg-light rounded drop-zone" 
                       data-group-index="${groupIndex}" 
                       data-subgroup-index="${subgroupIndex}">
                    <div class="row">
                      ${subgroup.elements.map((el, elementIndex) => `
                        <div class="form-element ${layoutClass}" draggable="true"
                            data-label="${el.label}" 
                            data-functionality="${el.functionality || 'text'}"
                            data-group-index="${groupIndex}" 
                            data-subgroup-index="${subgroupIndex}" 
                            data-element-index="${elementIndex}">
                            <span class="float-end ms-2 text-danger fw-bold fs-5 remove-field-btn" title="Remove Field" style="cursor:pointer;">×</span>
                            <label class="form-label">${el.label}</label>
                            ${renderInputByFunctionality(el)}
                        </div>
                      `).join('')}
                    </div>
                  </div>
                `).join('')}


            </div>
        </div>
       <div class="text-end">
          <button class="btn btn-sm btn-outline-success mt-2" onclick="addSubGroup(${groupIndex})">
              <i class="fas fa-plus-circle me-1"></i> Add Subgroup
          </button>
        </div>

    </div>`;
    }


    function addMoreToGroup(groupIndex) {
        const label = `Field ${formStructure[groupIndex].elements.length + 1}`;
        formStructure[groupIndex].elements.push({
            label: label,
            functionality: 'text' // default or let user pick later
        });

        renderPreviewLayout();
    }



    function addSubGroup(groupIndex) {
        if (!formStructure[groupIndex].subgroups) {
            formStructure[groupIndex].subgroups = [];
        }

        formStructure[groupIndex].subgroups.push({
            elements: []  // blank so user adds fields via drag
        });

        renderPreviewLayout();
    }






    function renderInputByFunctionality(el) {
        const label = el.label || '';
        const functionality = (el.functionality || 'text').toLowerCase();

        switch (functionality) {
            // 📌 Standard Types
            case 'optional':
            case 'select':
                return `<select class="form-control">
                        <option value="">Select ${label}</option>
                        <option>Option 1</option>
                        <option>Option 2</option>
                    </select>`;
            case 'checkbox':
                return `<div class="form-check">
                        <input type="checkbox" class="form-check-input" id="${label}">
                        <label class="form-check-label" for="${label}">${label}</label>
                    </div>`;
            case 'multiselect':
                return `<select class="form-control" multiple>
                        <option>Option 1</option>
                        <option>Option 2</option>
                    </select>`;
            case 'radio':
                return `<div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${label}" id="${label}1">
                            <label class="form-check-label" for="${label}1">Option 1</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="${label}" id="${label}2">
                            <label class="form-check-label" for="${label}2">Option 2</label>
                        </div>
                    </div>`;
            case 'text':
                return `<input class="form-control" type="text" placeholder="${label}">`;
            case 'description':
            case 'textarea':
                return `<textarea class="form-control" placeholder="${label}"></textarea>`;
            case 'unit':
            case 'price':
                return `<input type="number" class="form-control" placeholder="${label}">`;
            case 'rating':
                return `<input type="range" min="1" max="5" class="form-range" title="Rating">`;
            case 'range':
                return `<input type="range" min="0" max="100" class="form-range">`;
            case 'review':
                return `<textarea class="form-control" placeholder="Write your review..."></textarea>`;
            case 'table':
            case 'table checkbox':
            case 'column table':
                return `<div class="border p-2">[${functionality}] Table Placeholder</div>`;

            // 📌 Dynamic Element Types
            case 'chip view':
            case 'expandable dropdown':
            case 'checkbox dropdown':
            case 'button dropdown':
            case 'icon dropdown':
            case 'checkbox row table':
            case 'checkbox column table':
            case 'multiple text fields':
            case 'checklist':
            case 'dynamic textbox':
            case 'data grid':
            case 'scrollable description':
            case 'multiselect grid':
            case 'progress bar':
            case 'orderable list':
            case 'sliders with result':
            case 'range slider':
            case 'code editor':
            case 'color picker':
            case 'cloth size':
            case 'shoe size':
            case 'text editor':
                return `<div class="border rounded p-2 bg-light">[${functionality}] Placeholder Component</div>`;

            // 📌 Date & Time Types
            case 'date':
            case 'last date':
            case 'previous date':
                return `<input type="date" class="form-control" placeholder="${label}">`;
            case 'date & time':
                return `<input type="datetime-local" class="form-control" placeholder="${label}">`;
            case 'date range':
                return `<div class="d-flex gap-2">
                        <input type="date" class="form-control" placeholder="Start ${label}">
                        <input type="date" class="form-control" placeholder="End ${label}">
                    </div>`;
            case 'time':
                return `<input type="time" class="form-control" placeholder="${label}">`;
            case 'timer':
                return `<input type="number" class="form-control" placeholder="Set timer (seconds)">`;
            case 'date reservation':
                return `<input type="date" class="form-control" placeholder="Reserve ${label}">`;

            // 📌 Default fallback
            default:
                return `<input class="form-control" placeholder="${label}">`;
        }
    }






    function bindFieldRemoveButtons() {
        document.querySelectorAll('.remove-field-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                const field = e.target.closest('.form-element');
                const groupIndex = parseInt(field.dataset.groupIndex);
                const elementIndex = parseInt(field.dataset.elementIndex);

                if (!isNaN(groupIndex) && !isNaN(elementIndex)) {
                    formStructure[groupIndex].elements.splice(elementIndex, 1);
                    renderPreviewLayout();
                    bindSidebarDragEvents();
                    bindFieldRemoveButtons(); // re-attach
                }
            });
        });
    }



    document.addEventListener('dragover', function (e) {
        const zone = e.target.closest('.drop-zone');
        if (zone) {
            e.preventDefault();
            zone.classList.add('drop-zone-hover');
        }
    });

    document.addEventListener('dragleave', function (e) {
        const zone = e.target.closest('.drop-zone');
        if (zone) {
            zone.classList.remove('drop-zone-hover');
        }
    });



    document.addEventListener('drop', function (e) {
        e.preventDefault();
        const dropZone = e.target.closest('.drop-zone');
        if (!dropZone) return;

        const targetGroupIndex = parseInt(dropZone.dataset.groupIndex);
        const targetSubgroupIndex = parseInt(dropZone.dataset.subgroupIndex);
        const label = e.dataTransfer.getData('label');
        const functionality = e.dataTransfer.getData('functionality') || 'text';

        if (!formStructure[targetGroupIndex].subgroups[targetSubgroupIndex]) {
            formStructure[targetGroupIndex].subgroups[targetSubgroupIndex] = { elements: [] };
        }

        formStructure[targetGroupIndex].subgroups[targetSubgroupIndex].elements.push({
            label,
            functionality
        });

        renderPreviewLayout();
        bindSidebarDragEvents();
    });


    function removeGroup(index) {
        formStructure.splice(index, 1);
        renderPreviewLayout();
    }

    function bindSidebarDragEvents() {
        document.querySelectorAll('#elementTabsContent .form-element').forEach(el => {
            const label = el.dataset.label || el.textContent.trim();
            const functionality = el.dataset.functionality || 'text';

            el.setAttribute('draggable', 'true');
            el.setAttribute('data-type', 'new');
            el.setAttribute('data-label', label);
            el.setAttribute('data-functionality', functionality); // ✅ ensure it's present

            el.addEventListener('dragstart', function (e) {
                e.dataTransfer.setData('type', 'new');
                e.dataTransfer.setData('label', label);
                e.dataTransfer.setData('functionality', functionality); // ✅ set it in the transfer
            });

            el.addEventListener('dragend', function () {
                draggedElement = null;
            });
        });

        // Existing field drag config
        document.querySelectorAll('#formCanvas .form-element').forEach(el => {
            const label = el.dataset.label;
            const functionality = el.dataset.functionality || 'text';

            el.setAttribute('draggable', 'true');
            el.setAttribute('data-type', 'existing');
            el.setAttribute('data-functionality', functionality); // ✅ include for reorder if needed

            el.addEventListener('dragstart', function (e) {
                draggedElement = this;
                e.dataTransfer.setData('type', 'existing');
                e.dataTransfer.setData('label', label);
                e.dataTransfer.setData('functionality', functionality);
            });

            el.addEventListener('dragend', function () {
                draggedElement = null;
            });
        });
    }



    function showFormPreview() {
        let html = '';

        formStructure.forEach((group, groupIndex) => {
            html += `<h4 class="mt-3">${group.label}</h4>`;

            if (group.subgroups && group.subgroups.length > 0) {
                group.subgroups.forEach((subgroup, subgroupIndex) => {
                    html += `<div class="border rounded p-3 mb-3 bg-light">
                            <h6>Entry ${subgroupIndex + 1}</h6>
                            <div class="row">`;

                    subgroup.elements.forEach(el => {
                        html += `
                        <div class="col-md-6 mb-3">
                            <label class="form-label">${el.label}</label>
                            ${renderInputByFunctionality(el)}
                        </div>`;
                    });

                    html += `</div></div>`;
                });
            }
        });

        document.getElementById('formPreviewContent').innerHTML = html;
        const modal = new bootstrap.Modal(document.getElementById('formPreviewModal'));
        modal.show();
    }

</script>


@endsection