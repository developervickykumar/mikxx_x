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
    
    .left-accordion .form-element{
        width: 32.5%;
         display:flex;
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
        display: flex
    ;
        justify-content: center;
        align-items: center;
    }
    
    .drop-zone{
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
                            <button style="background:#f1f1f1" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
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
                                
                                @php
                                    $groupviewType = ($child->group_view['enabled'] ?? false) ? strtolower($child->group_view['view_type'] ?? '') : '';
                                    $isForm = (strtolower($child->label_json['label'] ?? '') === 'form'); 

                                @endphp
                                <div class="form-element" draggable="true" data-label="{{ $child->name }}" data-groupview="{{ $groupviewType }}"
                                    data-functionality="{{ strtolower($child->functionality ?? 'text') }}" data-isform="{{ $isForm ? '1' : '0' }}">

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
            elements: [],
            columns: 1, // default: 1-column layout
            addMoreBlocks: []
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

    // function renderGroup(group, index) {
    //     const groupId = `group-${index + 1}`;
    //     const label = group.label || `Group ${index + 1}`;

    //     if (previewType === 'horizontal-tabs' || previewType === 'vertical-tabs') {
    //         const tabHeaders = document.getElementById('tabHeaders');
    //         const tabContents = document.getElementById('tabContents');
    //         const tabId = `tab-${groupId}`;

    //         const tab = document.createElement('li');
    //         tab.className = 'nav-item';
    //         tab.innerHTML = `<a class="nav-link ${index === 0 ? 'active' : ''}" data-bs-toggle="tab" href="#${tabId}">${label}</a>`;
    //         tabHeaders.appendChild(tab);

    //         const pane = document.createElement('div');
    //         pane.className = `tab-pane fade ${index === 0 ? 'show active' : ''}`;
    //         pane.id = tabId;
    //         pane.innerHTML = getGroupContent(group, index);
    //         tabContents.appendChild(pane);

    //     } else if (previewType === 'multi-step') {
    //         const nav = document.getElementById('stepNav');
    //         nav.innerHTML += `<button class="btn btn-outline-primary">${label}</button>`;
    //         const content = document.getElementById('tabContents');
    //         content.innerHTML += `<div class="tab-pane fade show active">${getGroupContent(group, index)}</div>`;

    //     } else {
    //         const wrapper = document.getElementById('formAccordion');
    //         const item = document.createElement('div');
    //         item.className = 'accordion-item mb-3 border';
    //         item.innerHTML = `
    // <h2 class="accordion-header" id="acc-${groupId}">
    //   <div class="d-flex justify-content-between px-3 py-2 bg-light box-shadow-none rounded-top">
    //     <div contenteditable="true" class="editable-title">${label}</div>
    //     <button class="btn btn-sm btn-danger" onclick="removeGroup(${index})">&times;</button>
    //   </div>
    // </h2>
    // <div class="accordion-collapse collapse show">
    //   ${getGroupContent(group, index)}
    // </div>`;
    //         wrapper.appendChild(item);
    //     }
    // }
    
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
    
            if (group.groups && Array.isArray(group.groups)) {
                group.groups.forEach((subGroup, subIndex) => {
                    pane.innerHTML += getGroupContent(subGroup, `${index}-${subIndex}`);
                });
            } else {
                pane.innerHTML = getGroupContent(group, index);
            }
    
            tabContents.appendChild(pane);
    
        } else if (previewType === 'multi-step') {
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
    
        } else {
            // Default Accordion View (used for most form types)
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
                </div>`;
    
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
    
function getGroupContent(group, groupIndex) {
   let html = `<div class="accordion-body">`;
    
    if (group.label && !group.hideLabelHeading) {
        html += `<h5 class="mb-2 fw-semibold">${group.label}</h5>`;
    }
    
    if (!group.hideLayoutSelector) {
        html += `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="text-muted">Group Layout</small>
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
                        <label class="form-label">${el.label}</label>
                        ${renderInputByFunctionality(el)}
                    </div>
                `).join('')}
            </div>
        </div>
    `;
    
    //     <!-- 🔧 Group Layout Split Selector -->
    //     <div class="d-flex justify-content-between align-items-center mb-2">
    //         <small class="text-muted">Group Layout</small>
    //         <select onchange="updateGroupColumns(${groupIndex}, this.value)" class="form-select form-select-sm" style="width: auto;">
    //             ${[1, 2, 3, 4].map(n => `
    //                 <option value="${n}" ${group.columns === n ? 'selected' : ''}>${n} Column${n > 1 ? 's' : ''}</option>
    //             `).join('')}
    //         </select>
    //     </div>

    //     <!-- 🧱 Group Fields -->
    //     <div class="p-3 mb-3  rounded drop-zone" data-group-index="${groupIndex}">
    //         <div class="row">
    //             ${group.elements.map((el, elementIndex) => `
    //                 <div class="form-element col-md-${12 / (group.columns || 1)}" draggable="true"
    //                     data-label="${el.label}" 
    //                     data-functionality="${el.functionality || 'text'}"
    //                     data-group-index="${groupIndex}" 
    //                     data-element-index="${elementIndex}">
    //                     <span class="float-end ms-2 text-danger fw-bold fs-5 remove-field-btn" title="Remove Field" style="cursor:pointer;">×</span>
    //                     <label class="form-label">${el.label}</label>
    //                     ${renderInputByFunctionality(el)}
    //                 </div>
    //             `).join('')}
    //         </div>
    //     </div>
    // `;

    // 🧱 Add More Blocks
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
                             <label class="form-label">${field.label}</label>
                             ${renderInputByFunctionality(field)}
                        </div>
                    `).join('')}
                </div>
            </div>`;
        });
    }

    html += `</div>`; // closing .accordion-body
    return html;
}

 

document.addEventListener('dragover', function (e) {
    const zone = e.target.closest('.drop-zone, .add-more-drop-zone');
    if (zone) {
        e.preventDefault();
        zone.classList.add('drop-zone-hover');
    }
});

document.addEventListener('dragleave', function (e) {
    const zone = e.target.closest('.drop-zone, .add-more-drop-zone');
    if (zone) {
        zone.classList.remove('drop-zone-hover');
    }
});


document.addEventListener('drop', function (e) {
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
   
   
   if (isForm === '1') {
    fetch(`/admin/form-builder/get-child-by-name/${label}`)
        .then(res => res.json())
        .then(children => {
            if (!Array.isArray(children) || children.length === 0) return;

            const formAccordionLabel = label;
            const formGroups = [];

            const fetchAllChildren = children.map((groupItem) => {
                return fetch(`/admin/form-builder/get-child-by-name/${groupItem.name}`)
                    .then(res => res.json())
                    .then(grandChildren => {
                        const groupChildren = (grandChildren || []).map(c => ({
                            label: c.name,
                            functionality: c.functionality || 'text'
                        }));

                        formGroups.push({
                            label: groupItem.name, // e.g., Vital Details
                            elements: groupChildren,
                            columns: 2,
                            addMoreBlocks: []
                        });
                    });
            });

            Promise.all(fetchAllChildren).then(() => {
                // Final push: a full accordion for the form
                formStructure.push({
                    label: formAccordionLabel, // e.g., "User"
                    elements: [], // Leave empty at top level
                    columns: 1,
                    addMoreBlocks: [],
                    groups: formGroups // 👈 You can custom handle groups in renderGroup()
                });

                renderPreviewLayout();
            });
        })
        .catch(err => {
            console.error(`❌ Error fetching children for form "${label}":`, err);
        });

    return;
}

 
    //
   
    
       // 🧩 Custom Handler: LISTVIEW Group Rendering
    if (groupview.toLowerCase() === 'list') {
        fetch(`/admin/form-builder/get-child-by-name/${label}`)
            .then(res => res.json())
            .then(children => {
                const subElements = (children || []).map(c => ({
                    label: c.name,
                    functionality: c.functionality || 'text'
                }));

                // 📦 Create a new group with label like "Vital Details"
                formStructure.push({
                    label: label,
                    elements: subElements,
                    columns: 2,
                    addMoreBlocks: []
                });

                renderPreviewLayout();
            })
            .catch(err => {
                console.error(`❌ Error fetching children for listview "${label}":`, err);
            });

        return; // ✅ Skip default drop logic
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
            block.fields.push({ label, functionality });
            renderPreviewLayout();
            return;
        }
    }

    // 🟨 Normal drop into group
    if (!formStructure[groupIndex].elements) {
        formStructure[groupIndex].elements = [];
    }

    formStructure[groupIndex].elements.push({ label, functionality });

    renderPreviewLayout();
    bindSidebarDragEvents();
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
    
            el.addEventListener('dragstart', function (e) {
                e.dataTransfer.setData('type', 'new');
                e.dataTransfer.setData('label', label);
                e.dataTransfer.setData('functionality', functionality); 
                e.dataTransfer.setData('groupview', groupview); 
                e.dataTransfer.setData('isform', isForm); // ✅ added
            });
    
            el.addEventListener('dragend', function () {
                draggedElement = null;
            });
        });
    
        // 🧩 Existing field drag config (form canvas)
        document.querySelectorAll('#formCanvas .form-element').forEach(el => {
            const label = el.dataset.label;
            const functionality = el.dataset.functionality || 'text';
            const groupview = el.dataset.groupview || '';
            const isForm = el.dataset.isform || '0';
    
            el.setAttribute('draggable', 'true');
            el.setAttribute('data-type', 'existing');
            el.setAttribute('data-label', label);
            el.setAttribute('data-functionality', functionality); 
            el.setAttribute('data-groupview', groupview);
            el.setAttribute('data-isform', isForm); // ✅ for consistency
    
            el.addEventListener('dragstart', function (e) {
                draggedElement = this;
                e.dataTransfer.setData('type', 'existing');
                e.dataTransfer.setData('label', label);
                e.dataTransfer.setData('functionality', functionality);
                e.dataTransfer.setData('groupview', groupview);
                e.dataTransfer.setData('isform', isForm); // ✅ added
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

           html += `<div class="border rounded p-3 mb-3 bg-light">
            <div class="row">`;

            group.elements.forEach(el => {
                html += `
                    <div class="col-md-6 mb-3">
                        <label class="form-label">${el.label}</label>
                        ${renderInputByFunctionality(el)}
                    </div>`;
            });
            
            html += `</div></div>`; // Moved out of loop

        });

        document.getElementById('formPreviewContent').innerHTML = html;
        const modal = new bootstrap.Modal(document.getElementById('formPreviewModal'));
        modal.show();
    }
    
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


</script>


@endsection