@extends('layouts.master')

@section('title') 
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


<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.form-control {
    margin-bottom: 0 !important;
}

input {
    border: 0;
    outline: none;
}

/* .field-block .open-settings {
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.2s linear;
} */


.functionality-settings {
    display: none;
}

.form-control {
    background: #e9e9ef;
}

/* 
.field-row-group {
    background-color: #eee;
}

.field-row-group .row {
    border: 1px solid #ccc;
} */
</style>

<div class="row">
    <div class="col-xl-9 col-lg-8">
        <div class="card">
            <div class="card-body">

                <h3 class=" pb-2"> {{ $formName ?? 'No Form Title' }} </h3>


                <ul class="nav nav-tabs-custom card-header-tabs " id="pills-tab" role="tablist">
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

        @php
        function countNestedCategories($category) {
        if (!$category || !$category->children || $category->children->isEmpty()) {
        return 0;
        }

        $maxDepth = 0;
        foreach ($category->children as $child) {
        $depth = countNestedCategories($child);
        $maxDepth = max($maxDepth, $depth);
        }


        return 1 + $maxDepth;
        }
        @endphp


        <div class="tab-content @if(Auth::user()->isAdmin())  @endif" id="tab-form-management-content">
            @foreach($profileTabs as $index => $tab)


            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ Str::slug($tab->name) }}"
                role="tabpanel">
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            @foreach($tab->subTabs as $subIndex => $subTab)
                            <a class="border nav-link {{ $subIndex === 0 ? 'active' : '' }}"
                                id="vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}-tab"
                                data-bs-toggle="pill"
                                href="#vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}" role="tab">
                                {{ $subTab->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content">

                            @foreach($tab->subTabs as $subIndex => $subTab)



                            <div class="tab-pane fade {{ $subIndex === 0 ? 'show active' : '' }}"
                                id="vtab-{{ Str::slug($tab->name) }}-{{ Str::slug($subTab->name) }}" role="tabpanel"
                                data-tab-id="{{ $tab->id }}" data-sub-tab-id="{{ $subTab->id }}">

                                <div class="d-flex justify-content-between pb-2 border-bottom mb-3 align-items-center">
                                    <h4 id="form_title" contentEditable="true" class="mb-0 ps-2">{{ $subTab->name }} </h4>

                                    @if(Auth::user()->isAdmin())

                                    <div>
                                        <button class="btn btn-sm btn-light btn-preview-form">Form Preview</button>

                                        <button class="btn btn-sm btn-light btn-preview-result">Result preview</button>
                                        <button class="btn btn-sm btn-light">CTA Preview</button>
                                        <button id="setting-submit" class="btn btn-sm btn-primary">Save
                                            Settings</button>

                                        <span class="form-setting ms-3" role="button" data-bs-toggle="modal"
                                            data-bs-target="#formSettingsModal">⋮</span>

                                        <button type="button" class="btn btn-soft-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#createSubcategoryModal" data-parent-id="{{ $subTab->id }}"
                                            data-parent-name="{{ $subTab->name }}">
                                            <i class="bx bx-duplicate"></i>
                                        </button>
                                    </div>
                                    @endif

                                </div>


                                <form method="POST" id="form-{{ $subTab->id }}" action="" data-preview-type="product" enctype="multipart/form-data">
                                    @csrf

                                    <!-- CTA Dropdown Button Selector -->



                                    <div id="sortable-fields">
                                        @php $currentWidth = 0; @endphp

                                        @foreach($subTab->fields as $index => $field)
                                        @php
                                        $fieldName = Str::slug($field->name, '_');
                                        $fieldValue = old($fieldName, $user->$fieldName ?? '');
                                        $fieldValueArray = is_array($fieldValue) ? $fieldValue :
                                        (array)json_decode($fieldValue, true) ?? [];
                                        $allowUserOptions = $field->advanced['allow_user_options'] ?? false;
                                        $selectedValues = is_array($fieldValue) ? $fieldValue :
                                        (array)json_decode($fieldValue, true) ?? [];
                                        $suggestions = flattenCategoryNames($field->children ?? collect());
                                        $columnWidth = $field->column_width ?? 12;
                                        $settings = $field->settings ?? [];

                                        if ($currentWidth === 0)
                                        echo '<div class="field-row-group mb-2">
                                            <div class="dropzone-row">
                                                <div class="row">';
                                                    $currentWidth += $columnWidth;
                                                    @endphp

                                                    <div class="col-md-{{ $columnWidth }} field-block"
                                                        data-id="{{ $field->id }}"
                                                        data-settings="{{ json_encode($field->settings ?? []) }}">
                                                        <div class="d-flex p-2 position-relative">
                                                            @include('components.inputs.base', [
                                                            'field' => $field,
                                                            'fieldValue' => $fieldValue,
                                                            'fieldValueArray' => $fieldValueArray,
                                                            'selectedValues' => $selectedValues,
                                                            'allowUserOptions' => $allowUserOptions,
                                                            'suggestions' => $suggestions,
                                                            'user' => $user,
                                                            'settings' => $settings
                                                            ])
                                                            <button type="button"
                                                                class="btn bg-white btn-sm fs-5 m-0 p-0 open-settings p-0"
                                                                data-functionality="{{ $field->functionality }}"
                                                                data-field-id="{{ $field->id }}"
                                                                data-form-id="{{ $subTab->id }}"
                                                                data-settings="{{ htmlspecialchars(json_encode($field->settings ?? [])) }}"
                                                                data-settings-type="{{ strtolower(Str::slug($field->name)) }}">
                                                                <i class="mdi mdi-cog"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    @php
                                                    $isLast = $loop->last;
                                                    if ($currentWidth >= 12 || $isLast) {
                                                    echo '
                                                </div>
                                            </div>';
                                            @endphp

                                            <div
                                                class="d-flex justify-content-center gap-2 mt-2 mb-4 align-items-center setting-tools">
                                                <label class="me-1 mb-0">Insert:</label>
                                                <select class="form-select form-select-sm w-auto split-count-select">
                                                    <option value="1">1 column</option>
                                                    <option value="2">2 column</option>
                                                    <option value="3">3 column</option>
                                                    <option value="4">4 column</option>
                                                    <option value="6">6 column</option>
                                                    <option value="12">12 column</option>
                                                </select>
                                                <button type="button"
                                                    class="btn btn-sm btn-soft-info insert-group-btn">Insert
                                                    Group</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-soft-danger clone-row-btn">Apply Add
                                                    More</button>
                                            </div>
                                        </div>
                                        @php
                                        $currentWidth = 0;
                                        }
                                        @endphp
                                        @endforeach
                                    </div>


                                    <!-- Group Container Section -->
                                    <div id="field-groups" class="mt-4">
                                        <!-- Groups will be dynamically added here -->
                                    </div>



                                </form>



                            </div>
                            @endforeach

                            @if(Auth::user()->isAdmin())    

                            <div class="d-flex gap-2 justify-content-end">


                                <button type="button" class="btn btn-light group-fields-btn" id="addGroupFieldBtn">
                                    + Add Group Field
                                </button>


                                <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#postSettingsModal">
                                    <i class="fas fa-cog"></i> Settings
                                </button>

                                <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#postSettingsModal">
                                    <i class="bx bx-purchase-tag"></i> Tags
                                </button>


                                @php
                                $ctaButtons = \App\Models\Category::where('parent_id', 115024)->get();
                                @endphp

                                <div class="btn-group">
                                    <button type="button"
                                        class="btn btn-primary dropdown-toggle d-flex align-items-center"
                                        data-bs-toggle="dropdown" id="ctaDropdownBtn" aria-expanded="false">
                                        <span id="selectedCtaText">Select Action</span>
                                        <i class="mdi mdi-chevron-down ms-1"></i>
                                    </button>

                                    <ul class="dropdown-menu" id="cta-dropdown-menu">
                                        @foreach($ctaButtons as $btn)
                                        <li class="dropdown-submenu position-relative">
                                            <button type="button" class="dropdown-item cta-parent-btn w-100 text-start"
                                                data-id="{{ $btn->id }}" data-name="{{ $btn->name }}">
                                                {{ $btn->name }}
                                            </button>
                                            <ul class="dropdown-menu sub-dropdown position-absolute start-100 top-0 mt-0 d-none"
                                                id="sub-dropdown-{{ $btn->id }}"></ul>
                                        </li>
                                        @endforeach
                                    </ul>

                                    <input type="hidden" name="cta_action" id="cta_action">
                                    <input type="hidden" name="cta_sub_action" id="cta_sub_action">
                                </div>

                                @if(Auth::user()->isAdmin())
                                <style>
                                .dropdown-submenu:hover>.sub-dropdown {
                                    display: block !important;
                                }

                                .dropdown-submenu>.sub-dropdown {
                                    left: 100%;
                                    top: 0;
                                    margin-left: .1rem;
                                    display: none;
                                }
                                </style>
                                @endif

                                <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const ctaText = document.getElementById('selectedCtaText');
                                    const actionInput = document.getElementById('cta_action');
                                    const subActionInput = document.getElementById('cta_sub_action');

                                    document.querySelectorAll('.cta-parent-btn').forEach(parentBtn => {
                                        parentBtn.addEventListener('mouseenter', function() {
                                            const parentId = this.dataset.id;
                                            const subDropdown = document.getElementById(
                                                `sub-dropdown-${parentId}`);
                                            if (!subDropdown.hasChildNodes()) {
                                                // Load subcategories
                                                fetch(`/categories/${parentId}/childrens`)
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        if (data.length) {
                                                            subDropdown.innerHTML = '';
                                                            data.forEach(sub => {
                                                                const subBtn =
                                                                    document
                                                                    .createElement(
                                                                        'button');
                                                                subBtn.classList
                                                                    .add(
                                                                        'dropdown-item',
                                                                        'text-start'
                                                                    );
                                                                subBtn.textContent =
                                                                    sub.name;
                                                                subBtn.dataset.id =
                                                                    sub.id;
                                                                subBtn.dataset
                                                                    .parent =
                                                                    parentBtn
                                                                    .dataset.name;
                                                                subBtn.dataset
                                                                    .name = sub
                                                                    .name;
                                                                subBtn
                                                                    .addEventListener(
                                                                        'click',
                                                                        function(
                                                                            e) {
                                                                            e
                                                                                .stopPropagation();
                                                                            ctaText
                                                                                .innerText =
                                                                                `${this.dataset.name}`;
                                                                            actionInput
                                                                                .value =
                                                                                parentId;
                                                                            subActionInput
                                                                                .value =
                                                                                this
                                                                                .dataset
                                                                                .id;
                                                                        });
                                                                subDropdown
                                                                    .appendChild(
                                                                        subBtn);
                                                            });
                                                        } else {
                                                            subDropdown.innerHTML =
                                                                '<li><span class="dropdown-item text-muted">No subcategories</span></li>';
                                                        }
                                                    });
                                            }
                                        });
                                    });
                                });
                                </script>



                            </div>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
            @endforeach
        </div>


    </div>
    <!-- end col -->
</div>
<!-- end row -->

@include('components.form-modals.form-modal')

@include('backend.category.partials.create-subcategory')




<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js"
    integrity="sha512-csIng5zcB+XpulRUa+ev1zKo7zRNGpEaVfNB9On1no9KYTEY/rLGAEEpvgdw6nim1WdTuihZY1eqZ31K7/fZjw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.btn-preview-form').forEach(button => {
        button.addEventListener('click', () => {
            const tabPane = button.closest('.tab-pane');
            const form = tabPane?.querySelector('form');
            if (!form) return;

            const formTitleElement = tabPane.querySelector('h4');
            const formTitle = formTitleElement?.textContent?.trim() || 'Form Preview';

            const clonedForm = form.cloneNode(true);
            clonedForm.querySelectorAll('.setting-tools, .open-settings, .btn').forEach(el => el
                .remove());

            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.tabIndex = -1;
            modal.innerHTML = `
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" contenteditable="true">${formTitle}</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ${clonedForm.innerHTML}
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();

            modal.addEventListener('hidden.bs.modal', () => {
                modal.remove();
            });
        });
    });

    document.querySelectorAll('.btn-preview-result').forEach(button => {
    button.addEventListener('click', () => {
        const tabPane = button.closest('.tab-pane');
        const form = tabPane?.querySelector('form');
        if (!form) return;

        const formTitle = tabPane.querySelector('h4')?.textContent.trim() || 'Result Preview';
        const formData = new FormData(form);
        const previewType = form.dataset.previewType || 'product';
        formData.append('preview_type', previewType); // append preview type

        fetch('/preview-result-template', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.tabIndex = -1;
            modal.innerHTML = `
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="text" class="form-control form-control-lg" value="${formTitle} - Result Preview" />
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-3">
                            ${html}
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            modal.addEventListener('hidden.bs.modal', () => modal.remove());
        });
    });
});




    function autoSplitRow(container) {
        const parentGroup = container.closest('.field-row-group');
        const splitSelect = parentGroup?.querySelector('.split-count-select');
        const splitCount = parseInt(splitSelect?.value || 2);

        const blocks = Array.from(container.querySelectorAll('.field-block'));
        if (!blocks.length) {
            const fullGroup = container.closest('.field-row-group');
            fullGroup?.remove();
            return;
        }

        const extracted = blocks.map(block => {
            const dFlex = block.querySelector('.d-flex');
            const cloned = block.cloneNode(true);
            return {
                dFlex: dFlex.cloneNode(true),
                id: block.dataset.id || '',
                settings: block.dataset.settings || '[]'
            };
        });

        container.innerHTML = '';

        for (let i = 0; i < extracted.length; i += splitCount) {
            const row = document.createElement('div');
            row.className = 'row mb-2';

            extracted.slice(i, i + splitCount).forEach(item => {
                const col = document.createElement('div');
                col.className = `col-md-${12 / splitCount} field-block resizable`;
                col.setAttribute('data-id', item.id);
                col.setAttribute('data-settings', item.settings);
                col.appendChild(item.dFlex);
                row.appendChild(col);
            });

            container.appendChild(row);
            initSortableRow(row, container);
        }
    }

    function initSortableRow(row, container) {
        new Sortable(row, {
            group: 'shared-fields',
            animation: 150,
            handle: '.field-block',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                if (!evt.to.contains(evt.item)) {
                    evt.from.appendChild(evt.item); // restore to source
                }

                const toContainer = evt.to.closest('.dropzone-row');
                const fromContainer = evt.from.closest('.dropzone-row');

                if (toContainer) autoSplitRow(toContainer);
                if (fromContainer) autoSplitRow(fromContainer);
            }
        });
    }

    document.querySelectorAll('.field-row-group').forEach(group => {
        const dropzone = group.querySelector('.dropzone-row');
        if (!dropzone) return;

        dropzone.querySelectorAll('.row').forEach(row => initSortableRow(row, dropzone));
        autoSplitRow(dropzone);
    });

    document.querySelectorAll('.split-count-select').forEach(select => {
        select.addEventListener('change', function() {
            const container = this.closest('.field-row-group')?.querySelector('.dropzone-row');
            if (container) autoSplitRow(container);
        });
    });

    document.getElementById('sortable-fields')?.addEventListener('click', function(e) {
        const target = e.target;
        const rowGroup = target.closest('.field-row-group');
        if (!rowGroup) return;

        if (target.classList.contains('clone-row-btn')) {
            const clone = rowGroup.cloneNode(true);
            rowGroup.after(clone);
            clone.querySelectorAll('input:not([type=hidden]), select, textarea').forEach(el => el
                .value = '');

            const container = clone.querySelector('.dropzone-row');
            container?.querySelectorAll('.row').forEach(row => initSortableRow(row, container));
        }

        if (target.classList.contains('insert-group-btn')) {
            const currentRow = rowGroup.querySelector('.dropzone-row');
            const groupId = 'group-' + Math.floor(Math.random() * 100000);
            const wrapper = document.createElement('div');

            wrapper.className = 'border rounded p-2 mb-3 bg-light';
            wrapper.setAttribute('data-group-id', groupId);

            wrapper.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <input type="text" class="form-control form-control-sm w-50" value="Grouped Fields" placeholder="Group Name">
                    <button class="btn btn-sm btn-danger ms-2 remove-group">Remove</button>
                </div>
                <div class="row group-dropzone" id="${groupId}" style="min-height: 100px; border: 2px dashed #ccc; padding: 10px;"></div>
            `;

            const dropzone = wrapper.querySelector('.group-dropzone');
            dropzone.appendChild(currentRow);
            rowGroup.after(wrapper);
            rowGroup.remove();

            new Sortable(dropzone, {
                group: 'shared-fields',
                animation: 150,
                ghostClass: 'bg-warning',
                handle: '.field-block'
            });
        }
    });

    document.getElementById('field-groups')?.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-group')) {
            e.target.closest('[data-group-id]')?.remove();
        }
    });

    // 🔧 Hover-based visibility for field controls and settings toolbar
    document.querySelectorAll('.field-row-group').forEach(group => {
        group.addEventListener('mouseenter', () => {
            const tools = group.querySelector('.setting-tools');
            if (tools) {
                tools.classList.add('show-tools');
            }
        });
        group.addEventListener('mouseleave', () => {
            const tools = group.querySelector('.setting-tools');
            if (tools) {
                tools.classList.remove('show-tools');
            }
        });
    });

    document.querySelectorAll('.field-block').forEach(block => {
        const resizer = document.createElement('div');
        resizer.style.width = '5px';
        resizer.style.cursor = 'col-resize';
        resizer.style.position = 'absolute';
        resizer.style.top = '0';
        resizer.style.right = '0';
        resizer.style.bottom = '0';
        resizer.style.zIndex = '10';
        block.style.position = 'relative';
        block.appendChild(resizer);

        let startX, startWidth;
        resizer.addEventListener('mousedown', function(e) {
            startX = e.clientX;
            startWidth = parseFloat(window.getComputedStyle(block).width);
            document.documentElement.addEventListener('mousemove', onMouseMove);
            document.documentElement.addEventListener('mouseup', onMouseUp);
        });

        function onMouseMove(e) {
            const diff = e.clientX - startX;
            const newWidth = startWidth + diff;
            block.style.flex = `0 0 ${newWidth}px`;
            block.style.maxWidth = `${newWidth}px`;
            block.style.minWidth = `${newWidth}px`;
        }

        function onMouseUp() {
            document.documentElement.removeEventListener('mousemove', onMouseMove);
            document.documentElement.removeEventListener('mouseup', onMouseUp);
        }
    });
});
</script>

<style>
.field-block .btn,
.field-block .open-settings {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease;
}


.setting-tools {
    opacity: 0;
    visibility: hidden;
    transform: scaleY(0);
    height: 0;
    overflow: hidden;
    transition: all 0.25s ease-in-out;
    transform-origin: top;
}

</style>

@if(Auth::user()->isAdmin())

<style>
    .field-row-group:hover .setting-tools,
    .setting-tools.show-tools {
        opacity: 1 !important;
        visibility: visible !important;
        transform: scaleY(1);
        height: auto;
    }


    .field-block:hover .btn,
    .field-block:hover .open-settings {
        opacity: 1 !important;
        visibility: visible !important;
    }

    
.field-block:hover .open-settings {
    visibility: visible;
    opacity: 1;
}

</style>
@endif



<script>
let currentFieldId = null;
let currentFormId = null;

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.open-settings').forEach(button => {
        button.addEventListener('click', () => {
            currentFieldId = button.getAttribute('data-field-id');
            currentFormId = button.getAttribute('data-form-id');

            const settings = JSON.parse(button.getAttribute('data-settings') || '{}');
            const type = button.getAttribute('data-settings-type') || '';

            populateModal(settings, type);

            document.getElementById('currentFieldId').value = currentFieldId;
            document.getElementById('formId').value = currentFormId;
        });
    });

    document.getElementById('saveColumnWidth').addEventListener('click', () => {
        const getVal = (id) => document.getElementById(id)?.value || '';
        const getCheck = (id) => document.getElementById(id)?.checked ? 1 : 0;

        const newSettings = {
            form_id: currentFormId,
            category_id: currentFieldId,
            input_type: getVal('input_type'),
            label: getVal('label'),
            placeholder: getVal('placeholder'),
            tooltip: getVal('tooltip'),
            default_value: getVal('default_value'),
            is_required: getCheck('is_required'),
            validation_rules: getVal('validation_rules'),
            is_visible: getCheck('is_visible'),
            is_readonly: getCheck('is_readonly'),
            is_disabled: getCheck('is_disabled'),
            column_span: getVal('column_span') || '1',
            custom_css_class: getVal('custom_css_class'),
            position: parseInt(getVal('position')) || 0,
            group_name: getVal('group_name'),
            help_text: getVal('help_text'),
            icon: getVal('icon'),
            has_child: getCheck('has_child'),
            child_display_type: getVal('child_display_type'),
            condition_on: getVal('condition_on'),
            condition_value: getVal('condition_value'),

            // optional nested json object
            extra_settings: JSON.stringify({
                min: getVal('min') || null,
                max: getVal('max') || null,
                step: getVal('step') || null,
                custom_note: getVal('custom_note') || '',
            }),
        };

        console.log('Saving settings:', newSettings); // debug log

        fetch('/form-field-settings/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(newSettings)
            })
            .then(async res => {
                const contentType = res.headers.get('content-type');
                if (contentType.includes('application/json')) {
                    const data = await res.json();
                    alert('Settings saved!');
                    location.reload();
                } else {
                    const text = await res.text();
                    console.error('Unexpected non-JSON response:', text);
                    alert('Unexpected response received.');
                }
            })
            .catch(err => {
                console.error('Save error:', err);
                alert('Error saving settings.');
            });
    });
});


function populateModal(settings, type) {
    // Optionally switch tab based on type
    new bootstrap.Modal(document.getElementById('settingsModal')).show();

    document.getElementById('profilePic').checked = settings.profile_pic ?? false;
    document.getElementById('userTitle').checked = settings.title ?? false;

    const nameFormat = settings.name_format || 'first_last';
    document.querySelectorAll('.name-format').forEach(input => {
        input.checked = input.value === nameFormat;
    });

    // Trigger render if needed
    const renderUserFields = window.renderUserFields;
    if (typeof renderUserFields === 'function') renderUserFields();
}




// document.getElementById('saveColumnWidth').addEventListener('click', function() {
//     const width = document.getElementById('column-width').value;
//     const id = document.getElementById('activeFieldId').value;
//     const block = document.querySelector(`[data-id='${id}']`);

//     if (block) {
//         block.className = block.className.replace(/col-md-\d+/, 'col-md-' + width);
//         bootstrap.Modal.getInstance(document.getElementById('settingsModal')).hide();
//     }
// });

// CTA selection logic
document.querySelectorAll('.cta-action-btn').forEach(btn => {
    u
    btn.addEventListener('click', function(e) {
        const label = this.textContent;
        const value = this.getAttribute('data-value');
        document.getElementById('selectedCtaText').textContent = label;
        document.getElementById('cta_action').value = value;
    });
});


document.getElementById('setting-submit').addEventListener('click', function() {
    const formData = new FormData();

    formData.append('publish', 'yes');
    formData.append('cta_action', document.getElementById('cta_action').value);
    formData.append('cta_success_message', document.querySelector('input[name="cta_success_message"]').value);
    formData.append('cta_redirect_url', document.querySelector('input[name="cta_redirect_url"]').value);
    formData.append('for_type', document.querySelector('select[name="for_type"]').value);
    formData.append('data_mode', document.querySelector('select[name="data_mode"]').value);
    const activeSubTab = document.querySelector('.tab-pane.show.active[data-tab-id][data-sub-tab-id]');
    if (activeSubTab) {
        const tabId = activeSubTab.getAttribute('data-tab-id');
        const subTabId = activeSubTab.getAttribute('data-sub-tab-id');
        formData.append('tab_id', tabId);
        formData.append('sub_tab_id', subTabId);
    } else {
        alert('No active sub-tab found!');
        return;
    }


    const fields = [];

    document.querySelectorAll('.field-block').forEach(function (block, index) {
        const fieldId = block.getAttribute('data-id');
        const settingsJson = block.getAttribute('data-settings');
        const settings = settingsJson ? JSON.parse(settingsJson) : {};

        fields.push({
            category_id: fieldId,
            order: index,
            column_span: block.className.match(/col-md-(\d+)/)?.[1] || 12,
            settings: settings
        });
    });


    console.log(fields);
    formData.append('fields', JSON.stringify(fields));

    fetch("{{ route('form.builder.save') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: new URLSearchParams({
                title: document.getElementById('form_title').value || 'user Form',
                tab_id: document.querySelector('.tab-pane.show.active[data-tab-id]').getAttribute('data-tab-id'),
                sub_tab_id: document.querySelector('.tab-pane.show.active[data-sub-tab-id]').getAttribute('data-sub-tab-id'),
                fields: JSON.stringify(fields)
            })
        });


});
</script>
<!-- <script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('showLabelToggle');

    toggle.addEventListener('change', function() {
        const show = this.checked;

        document.querySelectorAll('.field-block .field-label').forEach(label => {
            label.style.display = show ? 'block' : 'none';
        });
    });

    // Optional: auto-apply toggle state on load
    toggle.dispatchEvent(new Event('change'));
});
</script> -->
<script>
function formatGlobalDate(date) {
    const format = document.getElementById('globalDateFormat')?.value || 'yyyy-mm-dd';
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    const mmm = date.toLocaleString('default', {
        month: 'short'
    });

    switch (format) {
        case 'yyyy-mm-dd':
            return `${yyyy}-${mm}-${dd}`;
        case 'dd-mm-yyyy':
            return `${dd}-${mm}-${yyyy}`;
        case 'mm-dd-yyyy':
            return `${mm}-${dd}-${yyyy}`;
        case 'yyyy/dd/mm':
            return `${yyyy}/${dd}/${mm}`;
            5
        case 'dd M yyyy':
            return `${dd} ${mmm} ${yyyy}`;
        default:
            return `${yyyy}-${mm}-${dd}`;
    }
}

function attachGlobalDateFormatter(input) {
    if (input._hasFormatterAttached) return;

    const display = document.createElement('small');
    display.className = 'text-muted d-block mt-1';
    input.insertAdjacentElement('afterend', display);

    const updateFormatted = () => {
        const val = input.value;
        if (!val) return display.textContent = '';
        const date = new Date(val);
        if (isNaN(date)) return display.textContent = 'Invalid Date';
        display.textContent = `Formatted: ${formatGlobalDate(date)}`;
    };

    input.addEventListener('change', updateFormatted);
    input._hasFormatterAttached = true;
    updateFormatted(); // initial
}
 
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('saveSettingsBtn');
    if (btn) {
        btn.addEventListener('click', function () {
            const getVal = id => document.getElementById(id)?.value || '';
            const getCheck = id => document.getElementById(id)?.checked || false;

            const fieldId = getVal('currentFieldId'); // Corrected from field_id
            const block = document.querySelector(`.field-block[data-id="${fieldId}"]`);
            if (!block) return;

            const newSettings = {
                label: getVal('edit_field'), // Corrected
                placeholder: '', // You can add a new input for this if needed
                tooltip: getVal('edit_tooltip'), // Corrected
                is_required: false, // Add a checkbox to support this if needed
                is_readonly: false, // Add a checkbox to support this if needed
                has_child: false, // Add a checkbox to support this if needed
                condition_on: getVal('condition_on'),
                condition_value: getVal('condition_value'),
                validation_rules: getVal('edit_validation'),
                allow_user_options: getCheck('allow_user_options'),
                column_span: getVal('column-width')
            };

            block.setAttribute('data-settings', JSON.stringify(newSettings));
            $('#settingsModal').modal('hide');
        });
    }
});


</script>


@endsection

