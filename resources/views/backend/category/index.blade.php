@extends('layouts.master')

@section('title') Categories @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Admin @endslot
@slot('title') Categories @endslot
@endcomponent

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Keep existing CSS imports -->
<link href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">

<style>
/* Add new styles for the card layout */
.category-card {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    background: white;
    transition: all 0.3s ease;
}

.category-card:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.category-header {
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e5e7eb;
}

.expand-icon {
    cursor: pointer;
    border-radius: 0.375rem;
    transition: transform 0.3s ease;
    color: #6b7280;
}

.expand-icon:hover {
    background: #f3f4f6;
    color: #111827;
}

.expand-icon.expanded {
    transform: rotate(180deg);
}

.category-content {
    padding: 1rem;
    display: none;
}

.category-content.show {
    display: block;
}

.category-badge {
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-default {
    background: #e5e7eb;
    color: #374151;
}

.badge-premium {
    background: #dbeafe;
    color: #1e40af;
}

.badge-enterprise {
    background: #dcfce7;
    color: #166534;
}

.badge-admin {
    background: #fee2e2;
    color: #991b1b;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.action-group {
    display: flex;
    gap: 0.25rem;
    padding: 0.25rem;
    /* background: #f3f4f6; */
    border-radius: 0.375rem;
}

.action-button {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 1rem;
    transition: all 0.2s ease;
    white-space: nowrap;
    height: 24px;
    line-height: 1;
}

.action-button:hover {
    transform: translateY(-1px);
}

.action-button i {
    font-size: 0.875rem;
}

.category-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.category-icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    border-radius: 0.375rem;
}

.category-details {
    flex: 1;
}

.category-name {
    font-weight: 500;
    color: #111827;
}

.category-link {
    color: #111827;
    text-decoration: none;
    transition: color 0.2s ease;
}

.category-link:hover {
    color: #2563eb;
}

.category-meta {
    font-size: 0.875rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Keep existing styles */
label {
    cursor: pointer;
}

#edit_image,
#edit_icon {
    opacity: 0;
    position: absolute;
    z-index: -1;
}

.custom-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-menu-custom {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 0.5rem;
    width: 220px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.dropdown-menu-custom.show {
    display: block;
}

.dropdown-menu-custom .dropdown-item {
    padding: 5px 10px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dropdown-menu-custom .dropdown-item input {
    border: none;
    background: #f8f9fa;
    width: 70%;
    padding: 0;
    margin: 0;
    outline: none;
    cursor: text;
}

.dropdown-menu-custom input[type="text"]#newOptionInput {
    margin-top: 10px;
    padding: 5px;
    width: 100%;
    border: 1px solid #ccc;
}

#dropdownTrigger {
    cursor: pointer;
    padding: 5px;
    /* border: 1px solid #ccc; */
    border-radius: 5px;
    min-width: 130px;
}

#selectedOption {
    font-size: 14px;
    font-weight: 500;
    color: #adadad;
}

.label-heading {
    font-weight: 600;
    font-size: 14px;
    /* margin-bottom: 5px; */
}

/* Editor Layout */
.editor-layout {
    display: grid;
    /*grid-template-columns: 1fr 1fr;*/
    gap: 1rem;
    height: calc(100vh - 120px);
    
}

@media (max-width: 768px) {
    .editor-layout {
        grid-template-columns: 1fr;
        height: auto;
    }
}

/* Top Controls */
.top-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--surface-color);
    border-radius: 0.5rem;
    box-shadow: var(--shadow-sm);
    margin-bottom: 1rem;
}

.control-group {
    display: flex;
    gap: 0.5rem;
}

/* Editor Panel */
.editor-panel {
    background: var(--surface-color);
    border-radius: 0.5rem;
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    height: 100vh;
    width:100%;
}

.editor-header {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.editor-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.editor-title::before {
    content: '📝';
    font-size: 1.2rem;
}

.editor-content {
    flex: 1;
    position: relative;
    overflow: hidden;
}

#codeEditor {
    width: 100%;
    height: 100%;
    padding: 1rem;
    border: none;
    font-family: 'Fira Code', monospace;
    font-size: 0.875rem;
    line-height: 1.5;
    color: var(--text-color);
    background: var(--surface-color);
    resize: none;
    outline: none;
}



.preview-header {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.preview-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.preview-title::before {
    content: '👁️';
    font-size: 1.2rem;
}

.preview-content {
    flex: 1;
    position: relative;
    overflow: hidden;
}

#previewFrame {
    width: 100%;
    height: 100%;
    border: none;
    background: white;
}

/* Buttons */
.button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.button-primary {
    background: var(--primary-color);
    color: white;
} 

.button-primary:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.button-secondary {
    background: var(--hover-color);
    color: var(--text-color);
}

.button-secondary:hover {
    background: #e2e8f0;
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

/* Toast Notifications */
.toast-container {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.toast {
    background: var(--surface-color);
    border-radius: 0.375rem;
    padding: 1rem;
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideIn 0.3s ease-out;
    min-width: 300px;
    border-left: 4px solid var(--primary-color);
}

.toast.success {
    border-left-color: var(--success-color);
}

.toast.error {
    border-left-color: var(--error-color);
}

.toast.warning {
    border-left-color: var(--warning-color);
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Accessibility */
.visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}

.focus-visible {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

.focus-visible:not(:focus-visible) {
    outline: none;
}

/* Skip to main content link */
.skip-link {
    position: absolute;
    top: -40px;
    left: 0;
    background: var(--primary-color);
    color: white;
    padding: 8px;
    z-index: 100;
    transition: top 0.3s;
}

.skip-link:focus {
    top: 0;
}
.collapse.show {
    visibility: visible;
}

/* High contrast mode support */
@media (forced-colors: active) {

    .editor-panel,
    .preview-panel {
        border: 2px solid CanvasText;
    }
}

.image-uploader-wrapper{
    display: flex !important;
}
</style>

<div id="pageMessage" class="my-2"></div>

<!-- Keep existing modals -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Add Apps</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="createCategoryForm">
                    @csrf

                    <input type="hidden" name="parent_id" id="parent_id" value="">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>

                        <textarea class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            required> {{ old('name') }}</textarea>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Add Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Add Icon</label>
                        <input type="file" class="form-control" id="icon" name="icon">
                    </div>

                    <!-- <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div> -->

                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createAppLabelModal" tabindex="-1" aria-labelledby="createAppLabelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAppLabelModalLabel">App Label</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="createAppCategoryForm">
                    @csrf
                    <input type="hidden" name="parent_id" id="app_label_parent_id" value="">
                    <input type="hidden" name="icon" id="icon_input" value="">

                    <div class="mb-3">
                        <label for="labelSelect" class="form-label">Select App Label</label>
                        <select name="label" class="form-control labelSelect" data-selected-label="">
                            <option value="">Loading...</option>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="subcategorySelect" class="form-label">Select App Label Subcategory</label>
                        <select name="subcategory" id="subcategorySelect" class="form-control">
                            <option value="">Please select an App Label first</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="edit_functionality" class="form-label">Select Page (Route)</label>
                        <select name="functionality" id="edit_functionality" class="form-control">
                            <option value="">-- Select a Route --</option>
                            @foreach($routes as $route)
                            <option value="{{ url($route['uri']) }}">
                                {{ $route['uri'] }} @if($route['name']) ({{ $route['name'] }}) @endif
                            </option>
                            @endforeach
                        </select>
                    </div>




                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class=" ">
    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" id="reportTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab" aria-controls="summary" aria-selected="true">
                📊 Report Summary
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="labels-tab" data-bs-toggle="tab" data-bs-target="#labels" type="button" role="tab" aria-controls="labels" aria-selected="false">
                🏷️ Label Report
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content  border border-top-0 p-3" id="reportTabsContent">
        <!-- Report Summary Tab -->
        <div class="tab-pane d-block fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-2">
                <div class="col"><div class="border rounded p-2 text-center"><strong>Total Pages</strong><br>{{ $labelCounts['Page'] ?? 0 }}</div></div>
                <div class="col"><div class="border rounded p-2 text-center"><strong>Linked Pages</strong><br>{{ $linkedPages ?? 'N/A' }}</div></div>
                <div class="col"><div class="border rounded p-2 text-center"><strong>Unlinked Pages</strong><br>{{ $unlinkedPages ?? 'N/A' }}</div></div>
                <div class="col"><div class="border rounded p-2 text-center"><strong>HTML in Segments</strong><br>{{ $htmlSegmentPages ?? 'N/A' }}</div></div>
                <div class="col"><div class="border rounded p-2 text-center"><strong>Without HTML</strong><br>{{ $noHtmlPages ?? 'N/A' }}</div></div>
            </div>
        </div>

        <!-- Label Report Tab -->
       <div class="tab-pane d-block fade" id="labels" role="tabpanel" aria-labelledby="labels-tab">
    <div class="row">
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Total Labels</strong><br>{{ array_sum($labelCounts->all()) }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Categories</strong><br>{{ $labelCounts['Categories'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Widgets</strong><br>{{ $labelCounts['Widgets'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Objects</strong><br>{{ $labelCounts['Objects'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Products</strong><br>{{ $labelCounts['Products'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Page</strong><br>{{ $labelCounts['Page'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Tools</strong><br>{{ $labelCounts['Tools'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Services</strong><br>{{ $labelCounts['Services'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Integration</strong><br>{{ $labelCounts['Integration'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Module</strong><br>{{ $labelCounts['Module'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Form</strong><br>{{ $labelCounts['Form'] ?? 0 }}
            </div>
        </div>
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Field</strong><br>{{ $labelCounts['Field'] ?? 0 }}
            </div>
        </div>
        <!--<div class="col">-->
        <!--    <div class="border rounded p-2 text-center">-->
        <!--        <strong>Field Functionality</strong><br>{{ $labelCounts['Field Functionality'] ?? 0 }}-->
        <!--    </div>-->
        <!--</div>-->
        <div class="col">
            <div class="border rounded p-2 text-center">
                <strong>Templates</strong><br>{{ $labelCounts['Templates'] ?? 0 }}
            </div>
        </div>
    </div>
</div>

    </div>
</div>

<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" id="breadcrumb">
        <li class="breadcrumb-item active" data-category-id="0" id="showAllCategories">
            <a href="#" class="breadcrumb-link">All Categories</a>
        </li>
    </ol>
</nav>

<!-- Categories Container -->
<div id="categoryContainer">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-soft-light" data-bs-toggle="modal"
                            data-bs-target="#createCategoryModal">
                            Add Categories
                        </button>

                        <div class="d-inline-block ms-2">
                        <label for="appLabelFilterData" id="appLabelFilter">App Label (0)</label>
                            <select name="" id="appLabelFilterData" class="form-select d-inline-block w-auto">
                            <option value="">All App Labels</option>
                        </select>
                        </div>

                        <div class="btn-group ms-2">
                            <button id="copySelected" title="Copy" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-copy"></i>
                            </button>
                            <button id="moveSelected" class="btn btn-outline-warning btn-sm">
                                <i class="bx bx-move"></i>
                            </button>
                            <button id="pasteSelected" class="btn btn-outline-success btn-sm d-none">
                                <i class="mdi mdi-content-paste"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="col-md-5" id="categoryStats">
                        <span>Loading stats...</span>
                    </div>
                    


                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" placeholder="Search categories...">
                            <button class="btn btn-primary" id="searchButton">Search</button>
                            <i class="mdi mdi-cog-outline fs-4 icon-choice ms-2" data-bs-toggle="modal"
                                data-bs-target="#permissionModal" style="cursor: pointer;"></i>
                        </div>
                        <div class="export btn">
                            <button type="button" class="btn btn-outline-primary px-3 py-1 rounded-full bg-gray-100 text-xs text-gray-700" data-bs-toggle="modal" data-bs-target="#exampleModal">
                              Import
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Categories List -->
            <div id="categoryTable" class="sortable-cards">
                    @foreach ($categories as $categorie)

                    @php 
                    $published = collect($categorie->children)->filter(function ($child) {
                    return !empty($child['code']);
                    })->count();

                    $pending = collect($categorie->children)->filter(function ($child) {
                    return empty($child['code']);
                    })->count(); 

                    $units = $published + $pending;

                    @endphp
                    
                    <div class="category-card  @if($categorie->is_excluded == 1) bg-light @endif" data-position="{{ $categorie->position}}" id="category-{{ $categorie->id }}" data-id="{{ $categorie->id }}"
                        data-parent-id="{{ $categorie->parent_id }}">
                        <div class="category-header">
                            <div class="category-info">
                                <input type="checkbox" class="category-checkbox me-2" value="{{ $categorie->id }}">

                                @include('backend.components.image-uploader', [
                                'inputId' => "imageInput-{$categorie->id}",
                                'imageUrl' => $categorie->image ? asset('storage/category/images/' . $categorie->image)
                                : asset('images/no-img.jpg'),
                                'categoryId' => $categorie->id
                                ])
                                <div class="category-details">
                                    <div class="d-flex">
                                        <!--@php echo 'herer is ' . $categorie->icon ;  @endphp-->
                                    @include('backend.components.icon-selector', [
                                    'inputId' => "iconInput-{$categorie->id}",
                                    'iconClass' => $categorie->icon ? $categorie->icon : 'dripicons-italic',
                                    'categoryId' => $categorie->id
                                    ])

                                        <div class="category-name ps-2">

                                            <p class="mb-0 text-info font-size-11">{{ $categorie->level_name }}</p>
                                            <a href="#" class="category-link" data-category-id="{{ $categorie->id }}"
                                                data-category-name="{{ $categorie->name }}">
                                                {{ $categorie->name }}
                                            </a>

                                            <div class="category-meta">

                                           @php
                                                $label = data_get($categorie->label_json, 'label'); // No json_decode needed
                                            @endphp
                                            
                                            <span class="text-info category-badge badge-{{ strtolower($categorie->status) }}">
                                                {{ ucfirst($categorie->label) }}
                                            </span>


                                                <small>Subcategories: {{ $categorie->children->count() }}</small>
                                                <div class="expand-icon" data-category-id="{{ $categorie->id }}"
                                                    onclick="toggleCategory(this)">
                                                    <i class="bx bx-chevron-down"></i>
                                                </div>

                                            </div>
                                            
                                            <style>
                                                .badge.disabled {
                                                pointer-events: none;
                                                opacity: 0.6;
                                            }

                                            </style>
                                            
                                            @php $badgeClass = $categorie->is_published ? 'bg-success' : 'bg-warning'; @endphp
                                            <span class="badge {{ $badgeClass }} toggle-publish-status"
                                                  data-id="{{ $categorie->id }}"
                                                  style="cursor: pointer;"
                                                  id="status-badge-{{ $categorie->id }}">
                                                {{ $categorie->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                            
                                            
                                        <!-- <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#routeModal-{{ $categorie->id }}">-->
                                        <!--    ➕ Add Route/Page-->
                                        <!--</button>-->
                                         
                                        @if( $categorie->label == 'Page') 
                                        <button
                                            type="button"
                                            class="btn btn-soft-success action-button edit-page"
                                            data-id="{{ $categorie->id }}"
                                            data-name="{{ $categorie->name }}"
                                            data-path="/categories"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editDynamicPageModal">
                                            <i class="mdi mdi-pencil"></i>
                                            <span>Edit Page</span>
                                        </button>
                                        
                                          @elseif( $categorie->label == 'Products')
                                          <a href="{{ route('prodview') }}?level3={{ $categorie->id }}" class="badge bg-danger btn btn btn-info">Product</a>

                                        @else
                                        @endif
                                        <span class="badge bg-secondary">Units: {{ $units }} </span>
                                        <!--<span class="badge bg-success">Published: {{ $published }}</span>-->
                                        <span class="badge bg-warning">Pending: {{ $pending }}</span>
                                        <span class="badge bg-danger"> Bugs: {{ '1' }} </span>
                                      
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <div class="action-group">
                                    <button type="button" class="btn btn-soft-primary action-button"
                                        data-bs-toggle="modal" data-bs-target="#createSubcategoryModal"
                                        data-parent-id="{{ $categorie->id }}" data-parent-name="{{ $categorie->name }}">
                                    <i class="bx bx-duplicate"></i>
                                        <span>Add Sub</span>
                                </button>
                                <button type="button" class="btn btn-soft-secondary action-button edit-category"
                                data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                                data-status="{{ $categorie->status }}">
                                <i class="bx bx-edit-alt"></i>
                                        <span>Edit</span>
                            </button>

                                    <button type="button" class="btn btn-soft-success action-button edit-html"
                                        data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                                          data-bs-toggle="modal"
                                        data-bs-target="#editHtmlModal">
                                        <i class="mdi mdi-code-tags icon-choice " style="cursor:pointer;"
                                            title="edit html"></i>
                                        <span>Edit HTML</span>
                                    </button>

                                    <button onclick="openChecklistById({{ $categorie->id }})">🧾 Checklist</button>

                                    @php
                                    $categoriesJson = $categories->map(function ($c) {
                                        return [
                                            'id' => $c->id,
                                            'name' => $c->name,
                                            'type' => data_get($c->label_json, 'label') ?? 'Unknown'
                                        ];
                                    })->values();
                                @endphp

                                    <script>
                                        window.categoriesFromLaravel = @json($categoriesJson);
                                        console.log(categoriesFromLaravel);
                                    </script>

                            </div>

                                <div class="action-group">
                                    
                                    <!-- <button type="button" class="btn btn-soft-secondary action-button edit-product"
                                data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                                data-status="{{ $categorie->status }}">
                                        <i class="bx bx-box"></i>
                                        <span>Product</span>
                            </button>
                                    <button type="button" class="btn btn-soft-secondary action-button edit-service"
                                data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}"
                                data-status="{{ $categorie->status }}">
                                        <i class="fas fa-user-nurse"></i>
                                        <span>Service</span>
                                    </button> -->
                                </div>
                                <div class="action-group">
                            <button
                                        class="btn btn-soft-secondary action-button lock-btn {{ $categorie->is_protected ? 'btn-secondary' : '' }}"
                                data-id="{{ $categorie->id }}" title="Toggle Protection">
                                <i class="bx bx-lock-alt"></i>
                                        <span>Protect</span>
                            </button>
                            @if(!$categorie->is_protected)
                                    <button class="btn btn-soft-secondary action-button delete-category"
                                        data-id="{{ $categorie->id }}" data-name="{{ $categorie->name }}">
                                <i class="bx bx-trash"></i>
                                        <span>Delete</span>
                            </button>
                            @endif
                                </div>
                            </div>
                       
                        </div>
                        <div class="category-content">
                            <!-- Category details and additional content -->
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>Category Details</h6>
                                    <p><strong>Description:</strong> {{ $categorie->description ?? 'No description' }}
                                    </p>
                                    <p><strong>Functionality:</strong>
                                        {{ $categorie->functionality ?? 'Not specified' }}</p>

                                        <div class="col-md-5 categoryStatsExpanded">
                                            <span>Loading stats...</span>
                                        </div>
                                </div>

                                <div class="col-md-4">
                                    <h6>Actions</h6>
                                    <!--<button type="button" class="btn btn-soft-primary action-button"-->
                                    <!--    data-bs-toggle="modal" data-bs-target="#createAppLabelModal"-->
                                    <!--    data-category-id="{{ $categorie->id }}" data-parent-id="{{ $categorie->id }}"-->
                                    <!--    data-parent-name="{{ $categorie->name }}">-->
                                    <!--    <i class="{{ $categorie->icon ?? 'dripicons-photo' }}"></i>-->
                                    <!--    <span>App Label</span>-->
                                    <!--</button>-->

                                    <div class="action-group">
                                        <button class="btn btn-soft-success action-button">
                                            <i class="dripicons-code"></i>
                                            <span>Copy ID</span>
                                        </button>
                                        <button class="btn btn-soft-secondary action-button">
                                            <i class="mdi mdi-animation-outline"></i>
                                            <span>Copy Sub</span>
                                        </button>
                                        <button class="btn btn-soft-warning action-button">
                                            <i class="mdi mdi-emoticon-happy-outline"></i>
                                            <span>Copy Icon</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="subcategories-container" id="subcategories-{{ $categorie->id }}">
                                        <!-- Loaded via AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                    
                    <div class="modal fade" id="routeModal-{{ $categorie->id }}" tabindex="-1" aria-labelledby="routeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <form method="POST" action="{{ route('html-template.store') }}">
                          @csrf
                          <input type="hidden" name="category_id" value="{{ $categorie->id }}">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Create Dynamic Page for: {{ $categorie->name }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                    
                            <div class="modal-body">
                              <div class="row g-3">
                                  <div class="col-md-6">
                                      <label class="form-label">Route Path</label>
                                      <input type="text" name="route" class="form-control" placeholder="/user/profile" required>
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label">HTTP Method</label>
                                      <select name="method" class="form-select">
                                          <option>GET</option>
                                          <option>POST</option>
                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label">Controller</label>
                                      <input type="text" name="controller" class="form-control" placeholder="UserController">
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label">Controller Method</label>
                                      <input type="text" name="controller_method" class="form-control" placeholder="profile">
                                  </div>
                                  <div class="col-md-12">
                                      <label class="form-label">View File (Blade)</label>
                                      <input type="text" name="view_file" class="form-control" placeholder="user.profile">
                                  </div>
                                  <div class="col-md-12">
                                      <label class="form-label">Custom Logic (optional)</label>
                                      <textarea name="custom_logic" rows="5" class="form-control" placeholder="return 'Hello World';"></textarea>
                                  </div>
                              </div>
                            </div>
                    
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Save Page</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>

                    @endforeach
                </div>

            </div>

            <div class="d-flex justify-content-center mt-3">
                {!! $categories->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
 
@include('backend.category.partials.module-validation')
@include('backend.category.modals')
@include('backend.category.partials.create-subcategory')
@include('backend.components.icon-selector-modal')


<style>
.modal-fullscreen {
    width: 100vw;
    max-width: none;
    height: 100%;
    margin: auto;
}

:root {
    --primary-color: #2563eb;
    --success-color: #059669;
    --warning-color: #d97706;
    --error-color: #dc2626;
    --border-color: #e5e7eb;
    --text-color: #1f2937;
    --text-muted: #6b7280;
    --bg-light: #f8fafc;
    --surface-color: #ffffff;
    --hover-color: #f1f5f9;
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --transition: all 0.2s ease-in-out;
}

/* Dark Mode Variables */
[data-theme="dark"] {
    --primary-color: #3b82f6;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --error-color: #ef4444;
    --border-color: #374151;
    --text-color: #f3f4f6;
    --text-muted: #9ca3af;
    --bg-light: #1f2937;
    --surface-color: #111827;
    --hover-color: #374151;
}



.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1rem;
}

/* Editor Layout */
 

@media (max-width: 768px) {
    .editor-layout {
        grid-template-columns: 1fr;
        height: auto;
    }
}

/* Top Controls */
.top-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--surface-color);
    border-radius: 0.5rem;
    box-shadow: var(--shadow-sm);
    margin-bottom: 1rem;
}

.control-group {
    display: flex;
    gap: 0.5rem;
}

 

.editor-header {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.editor-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.editor-title::before {
    content: '📝';
    font-size: 1.2rem;
}

.editor-content {
    flex: 1;
    position: relative;
    overflow: hidden;
}

#codeEditor {
    width: 100%;
    height: 100%;
    padding: 1rem;
    border: none;
    font-family: 'Fira Code', monospace;
    font-size: 0.875rem;
    line-height: 1.5;
    color: var(--text-color);
    background: var(--surface-color);
    resize: none;
    outline: none;
}

/* Preview Panel */
.preview-panel {
   
    border-radius: 0.5rem;
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    height: 190vh;
    width: 100%;
}

.preview-header {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.preview-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.preview-title::before {
    content: '👁️';
    font-size: 1.2rem;
}

.preview-content {
    flex: 1;
    position: relative;
    overflow: hidden;
}

#previewFrame {
    width: 100%;
    height: 100%;
    border: none;
    background: white;
}

/* Buttons */
.button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.button-primary {
    background: var(--primary-color);
    color: white;
}

.button-primary:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

.button-secondary {
    background: var(--hover-color);
    color: var(--text-color);
}

.button-secondary:hover {
    background: #e2e8f0;
    transform: translateY(-1px);
    box-shadow: var(--shadow-sm);
}

/* Toast Notifications */
.toast-container {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.toast {
    background: var(--surface-color);
    border-radius: 0.375rem;
    padding: 1rem;
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideIn 0.3s ease-out;
    min-width: 300px;
    border-left: 4px solid var(--primary-color);
}

.toast.success {
    border-left-color: var(--success-color);
}

.toast.error {
    border-left-color: var(--error-color);
}

.toast.warning {
    border-left-color: var(--warning-color);
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }

    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Accessibility */
.visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}

.focus-visible {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

.focus-visible:not(:focus-visible) {
    outline: none;
}

/* Skip to main content link */
.skip-link {
    position: absolute;
    top: -40px;
    left: 0;
    background: var(--primary-color);
    color: white;
    padding: 8px;
    z-index: 100;
    transition: top 0.3s;
}

.skip-link:focus {
    top: 0;
}

/* High contrast mode support */
@media (forced-colors: active) {

    .editor-panel,
    .preview-panel {
        border: 2px solid CanvasText;
    }
}
</style>

<!-- html edit modal -->
<div class="modal fade" id="editHtmlModal" tabindex="-1" aria-labelledby="editHtmlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            
            


            <div class="modal-body">
                <div class="toast-container" id="toastContainer" role="alert" aria-live="polite"></div>

                <div class="">
                    

                    <section class="prompt-section" aria-labelledby="prompt-label" style="display: none;">
                        <label id="prompt-label" class="prompt-label" for="suggestedPrompt">
                            Enter your prompt to generate HTML
                        </label>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item
                                    Name</label>
                                <input type="text" id="itemName"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 form-control">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Detected
                                    Type</label>
                                <input type="text" id="itemType"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 form-control"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suggested
                                    Prompt</label>
                                <textarea id="suggestedPrompt" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 form-control"></textarea>
                            </div>
                             
                        </div>

                        <div class="mt-2 control-group">
                            <button id="generateHtmlBtn" class="button button-primary">
                                <span>⚙️</span> Generate HTML
                            </button>
                        </div>
                    </section>
                    
                    <div class="d-flex justify-content-between">
                        
                        <ul class="nav nav-tabs border-0" id="htmlEditorTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="preview-tab" data-bs-toggle="tab" data-bs-target="#previewTab"
                                    type="button" role="tab" aria-controls="previewTab" aria-selected="true"> Preview</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="editor-tab" data-bs-toggle="tab" data-bs-target="#editorTab"
                                    type="button" role="tab" aria-controls="editorTab" aria-selected="false">HTML Editor</button>
                            </li>
                            
                          
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="recheck-tab" data-bs-toggle="tab" data-bs-target="#recheckTab"
                                    type="button" role="tab">Recheck HTML</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="improvement-tab" data-bs-toggle="tab" data-bs-target="#improvementTab"
                                    type="button" role="tab">Improvements</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="duplicate-tab" data-bs-toggle="tab" data-bs-target="#duplicateTab"
                                    type="button" role="tab">Duplicates</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tag-tab" data-bs-toggle="tab" data-bs-target="#tagTab"
                                    type="button" role="tab">Auto Tag</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="scan-tab" data-bs-toggle="tab" data-bs-target="#scanTab"
                                    type="button" role="tab">Scan Functionality</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="convert-tab" data-bs-toggle="tab" data-bs-target="#convertTab"
                                    type="button" role="tab">Convert to Code</button>
                            </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="custom-prompt-tab" data-bs-toggle="tab" data-bs-target="#customPromptTab"
                                    type="button" role="tab">Custom Prompt</button>
                            </li>
                            
                            

                                
                        </ul>
                        <h5 class="modal-title" id="editHtmlModalLabel">Edit HTML For: <span id="modalItemName">[Item Name]</span></h5>
                        
                      <div class="control-group">
                          
                          <input type="hidden" name="name" id="code-category-name">
                            <button id="saveCodeBtn" class="btn button-secondary" aria-label="Save changes">
                                
                                <span>Save Changes</span>
                            </button>
                    
                         <button id="backBtn" class="btn button-secondary" aria-label="Back to library">
                    
                            <span>Back to Library</span>
                        </button>
                        </div>
                        
                        
                    </div>
                    
                    
                    



                    <main id="main-content" class="editor-layout" role="main">
                        
                        
                        <div class="tab-content mt-3" id="htmlEditorTabsContent">
                            <div class="tab-pane fade show active" id="previewTab" role="tabpanel" aria-labelledby="preview-tab">
                          
                                   <!-- Live Preview Panel -->
                                <section class="preview-panel" aria-labelledby="preview-title">
                                    <!--<div class="preview-header">-->
                                    <!--    <h2 id="preview-title" class="preview-title">Live Preview</h2>-->
                                    <!--    <div class="control-group">-->
                                    <!--        <button id="" class="refreshBtn button button-secondary"-->
                                    <!--            aria-label="Refresh preview">-->
                                    <!--            <span>🔄</span>-->
                                    <!--            <span>Refresh Preview</span>-->
                                    <!--        </button>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    
                                     
                                    <div class="preview-content">
                                        <iframe id="previewFrame" title="HTML preview"
                                            sandbox="allow-same-origin allow-scripts allow-popups allow-forms"></iframe>
                                    </div>
                                </section>
                            
                                       
                            </div>

                             <div class="tab-pane fade" id="editorTab" role="tabpanel" aria-labelledby="editor-tab">
  
<!-- HTML Editor Panel -->
                                <section class="editor-panel" aria-labelledby="editor-title">
                                    <div class="editor-header">
                                        <h2 id="editor-title" class="editor-title">HTML Editor</h2>
                                        <div class="control-group">
                                            
                                            <button id="generateAiBtn" class="button button-secondary" aria-label="Generate AI">
                                                <span>💾</span>
                                                <span>Generate AI</span>
                                            </button>
                                            
                                         
                                            <button id="downloadBtn" class="button button-primary" aria-label="Download HTML">
                                                <span>📥</span>
                                                <span>Download HTML</span>
                                            </button>
                
                                            
                                        </div>
                                    </div>
                                    <div class="editor-content">
                                        <textarea id="codeEditor" class="code-editor" spellcheck="false"
                                            aria-label="HTML code editor"></textarea>
                                    </div>
                                </section>
                     
                              
                            </div>
                            
                            <!-- Recheck HTML -->
                            <div class="tab-pane fade" id="recheckTab" role="tabpanel">
                                <h5 class="mb-2">🔁 Recheck Output</h5>
                                <pre id="recheckOutput" class="bg-light p-3 border rounded"></pre>
                            </div>
                            
                            <!-- Improvement Suggestions -->
                            <div class="tab-pane fade" id="improvementTab" role="tabpanel">
                                <h5 class="mb-2">🚀 Improvements Suggested</h5>
                                <pre id="improvementOutput" class="bg-light p-3 border rounded"></pre>
                                
                                  <div class="form-group mb-3">
                                    <label for="improvementSummary">Improvement Summary</label>
                                    <textarea id="improvementSummary" class="form-control" rows="3" placeholder="Suggested improvements will appear here..."></textarea>
                                </div>
                            </div>
                            
                            <!-- Find Duplicates -->
                            <div class="tab-pane fade" id="duplicateTab" role="tabpanel">
                                <h5 class="mb-2">🔍 Duplicates Found</h5>
                                <ul id="duplicateOutput" class="list-group"></ul>
                            </div>
                            
                            <!-- Auto Tag & Categorization -->
                            <div class="tab-pane fade" id="tagTab" role="tabpanel">
                                <h5 class="mb-2">🏷️ Auto Tags</h5>
                                <input type="text" class="form-control" id="autoTagOutput" readonly>
                                
                                <div class="form-group mb-2">
                                    <label for="tagsInput">Tags</label>
                                    <input type="text" class="form-control" id="tagsInput" placeholder="e.g., login-form, user-profile">
                                </div>
                            </div>
                            
                            <!-- Functionality Scanner -->
                            <div class="tab-pane fade" id="scanTab" role="tabpanel">
                                <h5 class="mb-2">🧩 Functionality Scanner</h5>
                                <pre id="functionalityOutput" class="bg-light p-3 border rounded"></pre>
                            </div>
                            
                            <!-- Convert to Blade/Migration -->
                            <div class="tab-pane fade" id="convertTab" role="tabpanel">
                                <h5 class="mb-2">⚙️ Converted Blade + Migration</h5>
                                <h6 class="text-muted">Blade Code</h6>
                                <pre id="bladeOutput" class="bg-dark text-white p-3 rounded mb-3"></pre>
                                <h6 class="text-muted">Migration Code</h6>
                                <pre id="migrationOutput" class="bg-dark text-white p-3 rounded"></pre>
                            </div>
                            
                         <div class="tab-pane fade" id="customPromptTab" role="tabpanel">
                            <h5 class="mb-2">🧩 Custom Prompt</h5>
                        
                            <div class="mb-3">
                                <label for="initialPrompt">Initial Instruction</label>
                                <input type="text" id="initialPrompt" class="form-control" placeholder="e.g., Create a contact form">
                            </div>
                        
                            <div class="mb-3">
                                <button id="makePromptBtn" class="btn btn-primary">Make Prompt</button>
                            </div>
                        
                            <div class="mb-3">
                                <label for="suggestedPrompt">Generated Prompt</label>
                                <textarea id="suggestedPrompt" rows="4" class="form-control" readonly></textarea>
                            </div>
                        
                            <hr>
                        
                            <div id="customPromptOutput" class="bg-light p-3 border rounded">
                                <p>Custom prompt result will appear here...</p>
                            </div>
                        </div>



                        </div>
                    </main>
                </div>

                <script>
                // Theme Management
                const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

                function setTheme(theme) {
                    document.documentElement.setAttribute('data-theme', theme);
                    localStorage.setItem('theme', theme);
                }

                // Initialize theme
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    setTheme(savedTheme);
                } else if (prefersDarkScheme.matches) {
                    setTheme('dark');
                }

                // Toast Notifications
                function showToast(message, type = 'success') {
                    const toast = document.createElement('div');
                    toast.className = `toast ${type}`;
                    toast.setAttribute('role', 'alert');
                    toast.innerHTML = `
                <span>${type === 'success' ? '✅' : type === 'error' ? '❌' : '⚠️'}</span>
                <span>${message}</span>
            `;

                    const container = document.getElementById('toastContainer');
                    container.appendChild(toast);

                    // Announce to screen readers
                    const announcement = document.createElement('div');
                    announcement.setAttribute('aria-live', 'polite');
                    announcement.className = 'visually-hidden';
                    announcement.textContent = message;
                    document.body.appendChild(announcement);

                    setTimeout(() => {
                        toast.remove();
                        announcement.remove();
                    }, 3000);
                }

                // Editor Functions
                function initializeEditor() {
                    const codeEditor = document.getElementById('codeEditor');
                    const savedCode = localStorage.getItem('generatedHTML');

                    if (savedCode) {
                        codeEditor.value = savedCode;
                        updatePreview();
                    } else {
                        codeEditor.value = `<!-- Your HTML code here -->
                        <div class="container">
                            <h1>Welcome to the HTML Editor</h1>
                            <p>Start editing your HTML code here...</p>
                        </div>`;
                        updatePreview();
                    }
                }

                function updatePreview() {
                    const codeEditor = document.getElementById('codeEditor');
                    const previewFrame = document.getElementById('previewFrame');
                    const previewDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;

                    previewDoc.open();
                    previewDoc.write(`
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <style>
                                body { font-family: system-ui, sans-serif; line-height: 1.5; padding: 2rem; }
                            </style>
                        </head>
                        <body>
                            ${codeEditor.value}
                        </body>
                        </html>
                    `);
                    previewDoc.close();
                }

                function saveChanges() {
                    const codeEditor = document.getElementById('codeEditor');
                    localStorage.setItem('generatedHTML', codeEditor.value);
                    showToast('Changes saved successfully');
                }

                function downloadHTML() {
                    const codeEditor = document.getElementById('codeEditor');
                    const blob = new Blob([codeEditor.value], {
                        type: 'text/html'
                    });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'generated-template.html';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                    showToast('HTML file downloaded');
                }

                function goBack() {
                    window.location.href = 'template-library.html';
                }

                // Event Listeners
                document.addEventListener('DOMContentLoaded', () => {
                    const codeEditor = document.getElementById('codeEditor');
                    const refreshBtn = document.querySelector('.refreshBtn'); 
                    const saveBtn = document.getElementById('saveBtn');
                    const downloadBtn = document.getElementById('downloadBtn');
                    const backBtn = document.getElementById('backBtn');
                    const previewTabBtn = document.getElementById('preview-tab');

                    // Initialize editor with saved or default content
                    initializeEditor();

                    // Add event listeners
                    refreshBtn.addEventListener('click', updatePreview);
                    previewTabBtn.addEventListener('click', updatePreview);
                    saveBtn.addEventListener('click', saveChanges);
                    downloadBtn.addEventListener('click', downloadHTML);
                    backBtn.addEventListener('click', goBack);

                    // Auto-update preview on input (with debounce)
                    let debounceTimer;
                    codeEditor.addEventListener('input', () => {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(updatePreview, 500);
                    });

                    // Add keyboard shortcuts
                    document.addEventListener('keydown', (e) => {
                        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                            e.preventDefault();
                            saveChanges();
                        }
                        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                            e.preventDefault();
                            updatePreview();
                        }
                    });

                    // Add keyboard navigation
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Tab') {
                            document.body.classList.add('keyboard-navigation');
                        }
                    });

                    document.addEventListener('mousedown', () => {
                        document.body.classList.remove('keyboard-navigation');
                    });
                });

                // Error Handling
                window.addEventListener('error', function(e) {
                    console.error('Global error:', e.error);
                    showToast('An error occurred. Please try again.', 'error');
                });

                window.addEventListener('unhandledrejection', function(e) {
                    console.error('Unhandled promise rejection:', e.reason);
                    showToast('An error occurred. Please try again.', 'error');
                });

                // Cleanup
                window.addEventListener('unload', function() {
                    const highestTimeoutId = setTimeout(() => {}, 0);
                    for (let i = 0; i < highestTimeoutId; i++) {
                        clearTimeout(i);
                    }
                });
                </script>
            </div>
           
            <div class="modal-footer flex-wrap justify-between gap-2">

            
            
                <div class="w-100 d-flex flex-column mt-3">
                    
            
                  
                    
                    <div class="d-flex gap-3">
                        
                       <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" id="usableUser">
                            <label class="form-check-label" for="usableUser">Usable in User</label>
                        </div>
                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" id="usableBusiness">
                            <label class="form-check-label" for="usableBusiness">Usable in Business</label>
                        </div>
                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" id="usableMikxx">
                            <label class="form-check-label" for="usableMikxx">Usable in Mikxx Frontend</label>
                        </div>
                        <div class="form-check form-switch mb-1">
                            <input class="form-check-input" type="checkbox" id="usableModules">
                            <label class="form-check-label" for="usableModules">Usable in Modules</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="usableAdmin">
                            <label class="form-check-label" for="usableAdmin">Usable in Admin</label>
                        </div>
                        
                    </div>
            
                  
            
                    <div class="d-grid">
                        <button id="publishBtn" class="btn btn-success">📤 Publish</button>
                    </div>
                </div>
            
            </div>

        </div>
    </div>
</div>
 
@endsection


@section('script')

<!-- choices js -->
<script src="{{ asset('js/universal-module.js') }}"></script>

<script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

<!-- color picker js -->
<script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

<!-- datepicker js -->
<script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>

<!-- init js -->
<script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
// Auto-fill modal when clicking Edit Page button
document.addEventListener('click', function(e) {
  if (e.target.closest('.edit-page')) {
    const button = e.target.closest('.edit-page');

    const name = button.dataset.name.trim();
    const slug = name.toLowerCase().replace(/\s+/g, '-');
    const controllerName = name
      .toLowerCase()
      .split(' ')
      .map(w => w.charAt(0).toUpperCase() + w.slice(1))
      .join('') + 'Controller';

    // Autofill slug input
    document.getElementById('pageSlug').value = slug;

    // Autofill route
    document.getElementById('routeEditor').value =
`Route::get('/${slug}', [${controllerName}::class, 'index']);
Route::get('/${slug}/report', [${controllerName}::class, 'report']);
Route::get('/${slug}/edit', [${controllerName}::class, 'edit']);
Route::get('/${slug}/custom', [${controllerName}::class, 'custom']);`;

    // Autofill controller stub
    document.getElementById('controllerEditor').value =
`class ${controllerName} extends Controller
{
    public function index() {
        return view('${slug}.index');
    }

    public function report() {
        return view('${slug}.report');
    }

    public function edit() {
        return view('${slug}.edit');
    }

    public function custom() {
        return view('${slug}.custom');
    }
}`;

    // Autofill model stub
    document.getElementById('modelEditor').value =
`class ${name.replace(/\s+/g, '')} extends Model
{
    protected $fillable = ['name', 'description'];
}`;

    // Clear view editor
    document.getElementById('viewEditor').value = '';
  }
});


// Update View template dropdown
function updateViewTemplate() {
  const type = document.getElementById('viewType').value;
  let template = '';

  if (type === 'form') {
    template = `<form method="POST" action="/resource">
  @csrf
  <input type="text" name="name" class="form-control mb-2" placeholder="Name">
  <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>`;
  } else if (type === 'table') {
    template = `<table class="table">
  <thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead>
  <tbody>
    @isset($resources)
    @foreach($resources as $item)
    <tr><td>{{$item->id}}</td><td>{{$item->name}}</td><td>Edit | Delete</td></tr>
    @endforeach
    @endisset
  </tbody>
</table>`;
  } else if (type === 'report') {
    template = `<div class="report">
  <h3>Resource Report</h3>
  <p>Total: </p>
</div>`;
  }

  document.getElementById('viewEditor').value = template;
}

// Save dynamic page files
function saveDynamicPageFiles() {
  const slug = document.getElementById('pageSlug').value.trim();
  if (!slug) {
    alert('Please enter a page slug.');
    return;
  }

  const payload = {
    slug: slug,
    routeContent: document.getElementById('routeEditor').value,
    controllerContent: document.getElementById('controllerEditor').value,
    modelContent: document.getElementById('modelEditor').value,
    viewContent: document.getElementById('viewEditor').value,
  };

  axios.post('/admin/dynamic-pages/save', payload)
    .then(response => {
      alert('Files saved successfully.');
      console.log(response.data);
    })
    .catch(error => {
      alert('Error saving files.');
      console.error(error);
    });
}
</script>

<script>

$(document).ready(function() {
    loadStats(0); // Load root level
});


$(document).on('click', '.category-link', function(e) {
    e.preventDefault();

    const categoryId = $(this).data('category-id');
    const categoryName = $(this).data('category-name');

    // Prevent duplicate breadcrumb entries
    if ($('#breadcrumb').find(`li[data-category-id="${categoryId}"]`).length === 0) {
        $('#breadcrumb').append(`
            <li class="breadcrumb-item" data-category-id="${categoryId}">
                <a href="#" class="breadcrumb-link">${categoryName}</a>
            </li>
        `);
    }

    loadCategories(categoryId);
});

// AJAX to fetch and render child categories
function loadCategories(categoryId) {
    
    $.ajax({
        url: '/admin/categories/' + categoryId + '/children',
        type: 'GET',
        success: function(data) {
            $('#categoryTable').html(data);

            // Reset Select All checkbox when loading new rows
            $('.selectAll').prop('checked', false);

            loadStats(categoryId);
        },
        error: function() {
            alert("Failed to load categories.");
        }
    });

}

function loadStats(categoryId) {
    $.ajax({
        url: '/admin/categories/' + categoryId + '/counts',
        type: 'GET',
        success: function(data) {
            let html = '';

            if (categoryId == 0) {
                html += `<span>Home: ${data.home}</span> | `;
            }

            if (data.sector > 0) {
                html += `<span>Sectors: ${data.sector}</span> | `;
            }

            if (data.department > 0) {
                html += `<span>Departments: ${data.department}</span> | `;
            }

            if (data.segment > 0) {
                html += `<span>Segments: ${data.segment}</span> | `;
            }

            if (data.pages > 0) {
                html += `<span>Pages: ${data.pages}</span> | `;
            }

            if (data.forms > 0) {
                html += `<span>Forms: ${data.forms}</span> | `;
            }

            if (data.code > 0) {
                html += `<span>Items with Code: ${data.code}</span>`;
            }

            $('#categoryStats').html(html || '<span>No data</span>');
        },
        error: function() {
            $('#categoryStats').html('<span>Error loading stats</span>');
        }
    });
}


function loadStatsForCard(categoryId, container) {
    if (!container) return;

    $.ajax({
        url: '/admin/categories/' + categoryId + '/counts',
        type: 'GET',
        success: function(data) {
            let html = '';

            if (categoryId == 0 && data.home > 0) html += `<span>Home: ${data.home}</span> | `;
            if (data.sector > 0) html += `<span>Sectors: ${data.sector}</span> | `;
            if (data.department > 0) html += `<span>Departments: ${data.department}</span> | `;
            if (data.segment > 0) html += `<span>Segments: ${data.segment}</span> | `;
            if (data.pages > 0) html += `<span>Pages: ${data.pages}</span> | `;
            if (data.forms > 0) html += `<span>Forms: ${data.forms}</span> | `;
            if (data.code > 0) html += `<span>Items with Code: ${data.code}</span>`;

            container.innerHTML = html || '<span>No data</span>';
        },
        error: function() {
            container.innerHTML = '<span>Error loading stats</span>';
        }
    });
}


$(document).on('click', '.breadcrumb-link', function(e) {
    e.preventDefault();
    var categoryId = $(this).parent().data('category-id');

    $(this).parent().nextAll().remove();
    loadCategories(categoryId);
});




$('#createCategoryForm').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var parentId = $('#category_parent_id').val();
    var currentLevelId = $('#breadcrumb li:last').data('category-id');

    $.ajax({
        url: '/admin/categories',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function() {
            $('#createCategoryModal').modal('hide');
            $('#createCategoryForm')[0].reset();
            loadCategories(currentLevelId || '0');

        }
    });
});



// let currentCategoryName = '';
// $(document).on('click', '.edit-category', function() {
//     var categoryId = $(this).data('id');
//     currentCategoryName = $(this).data('name');

//     $.ajax({
//         url: '/admin/categories/' + categoryId + '/edit',
//         type: 'GET',
//         success: function(data) {
//             $('#edit_category_id').val(data.id);
//             $('#edit_name').val(data.name);
//             $('#edit_status').val(data.status);
//             $('#edit_validation').val(data.validation);
//             $('#edit_tooltip').val(data.tooltip);
//             $('#edit_description').val(data.description);
//             $('#edit_functionality').val(data.functionality);
//             $('#edit_level_name').val(data.level_name);
//             $('#edit_price_list').val(data.price_list);
//             $('#edit_create_form').val(data.create_form);

//             $('#edit_code_area').val(data.code);

//             // Populate messages
//             if (data.messages) {
//                 $('#edit_user_message').val(data.messages.user || '');
//                 $('#edit_own_message').val(data.messages.own || '');
//                 $('#edit_custom_message').val(data.messages.other || '');
//             }

//             // Populate notifications
//             if (data.notifications) {
//                 $('#edit_user_notification').val(data.notifications.user || '');
//                 $('#edit_own_notification').val(data.notifications.own || '');
//                 $('#edit_custom_notification').val(data.notifications.other || '');
//             }

//             // Populate "Page Display" select
//             if (data.display_at_decoded && data.display_at_decoded.type) {
//                 $('select[name="page_display_type"]').val(data.display_at_decoded.type);
//             }

//             // Uncheck all checkboxes first
//             $('input[name="display_at[]"]').prop('checked', false);

//             // Re-check saved checkboxes
//             if (data.display_at_decoded && Array.isArray(data.display_at_decoded.positions)) {
//                 data.display_at_decoded.positions.forEach(function(value) {
//                     $('input[name="display_at[]"][value="' + value + '"]').prop('checked',
//                         true);
//                 });
//             }

//             $('#editCategoryModal').modal('show');
//         }
//     });
// });


/////////////////////////////////////




let currentCategoryName = '';

const labelTabMap = {
    "Products": ["product-tab", "variants-tab", "filters-tab", "features-tab", "specifications-tab", "size-tab", "media-tab", "subscriptions-tab", "mapping-tab"],
    "Module": ["module-tab", "modules", "integration-tab"],
    "Form": ["form-tab"],
    "Page": ["page_elements-tab", "view-tab", "keywords-tab"],
    "Tools": ["tools-tab"],
    "Integration": ["integration-tab"],
    "Services": ["goods-and-service-tab"],
    "Widgets": ["view-tab"],
    "Templates": ["keywords-tab", "media-tab"],
    "Objects": ["media-tab", "keywords-tab"],
    "Field": ["edit-tab", "form-tab"],
    "Field Functionality": ["edit-tab"],
    "Categories": ["edit-tab", "message-tab", "notification-tab"]
};

const alwaysVisibleTabs = [
    "edit-tab",
    "view-tab",
    "message-tab",
    "notification-tab",
    "media-tab",
    "keywords-tab",
    "code-tab",
    "integration-tab"
];
 
 function updateTabsByLabel(label) {
    // Hide all tabs first
    $('#editCategoryTab .nav-link').hide();
    $('#editCategoryTabContent .tab-pane').removeClass('show active');

    // Show always-visible tabs
    alwaysVisibleTabs.forEach(tabId => {
        $(`#${tabId}`).show();
        $($(`#${tabId}`).attr('data-bs-target')).addClass('show');
    });

    // Show label-specific tabs
    const labelTabs = labelTabMap[label] || [];
    labelTabs.forEach(tabId => {
        $(`#${tabId}`).show();
        $($(`#${tabId}`).attr('data-bs-target')).addClass('show');
    });

    // Remove any previously active tabs and panes
    $('#editCategoryTab .nav-link').removeClass('active');
    $('#editCategoryTabContent .tab-pane').removeClass('active show');
    
    // Activate the first visible tab
    const firstVisible = $('#editCategoryTab .nav-link:visible').first();
    if (firstVisible.length) {
        firstVisible.addClass('active');
        const target = $(firstVisible).attr('data-bs-target');
        $(target).addClass('show active');
    }

}


$(document).on('click', '.edit-category', function() {
    
    const categoryId = $(this).data('id');

    $.ajax({
        url: '/admin/categories/' + categoryId + '/edit',
        type: 'GET',
        success: function(data) {
            // console.log(data);
            
            currentCategoryName = data.name || '';  

            $('#edit_category_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_label').val(data.label);
            $('#edit_level_name').val(data.level_name);

            if (data.functionality) {
                const functionalityVal = data.functionality.trim();
                // console.log('Functionality:', functionalityVal);

                setTimeout(() => {
                    $('#edit_functionality option').each(function() {
                        if ($(this).val().trim() === functionalityVal) {
                            $(this).prop('selected', true);
                        } else {
                            $(this).prop('selected', false);
                        }
                    });

                    $('#edit_functionality').trigger('change');
                }, 100);

            }
 
            if (data.label) {
                
                const labelValue = data.label.trim();
                
                updateTabsByLabel(labelValue);
                
                const intervalLabel = setInterval(() => {
                    if ($('#labelSelect option').length > 1) {
                        $('#labelSelect').val(labelValue).trigger('change');
                        clearInterval(intervalLabel);
                    }
                }, 100);
            }
            
            // First clear all product-specific fields
$('.product-fields input, .product-fields select').val('');
$('.product-fields').hide(); // Hide all sections

if (data.price_list) {
    let priceList = data.price_list;

    try {
        priceList = typeof priceList === 'string' ? JSON.parse(priceList) : priceList;
        $('#edit_price_list').val(JSON.stringify(priceList)); // hidden input

        const productType = priceList.product_type || '';
        $('#product_type').val(productType).trigger('change');

        setTimeout(() => {
            if (productType === 'digital') {
                $('#digitalFields').show();
                $('input[name="price_list[value]"]').val(priceList.value || '');
                $('select[name="price_list[value_type]"]').val(priceList.value_type || '');
                $('input[name="price_list[conversion_rate]"]').val(priceList.conversion_rate || '');
                $('input[name="price_list[theme]"]').val(priceList.theme || '');
                $('select[name="price_list[is_collectible]"]').val(priceList.is_collectible || '0');
            }

            if (productType === 'service') {
                $('#serviceFields').show();
                $('input[name="price_list[service_duration]"]').val(priceList.service_duration || '');
                $('input[name="price_list[service_area]"]').val(priceList.service_area || '');
            }

            if (productType === 'event') {
                $('#eventFields').show();
                $('input[name="price_list[event_date]"]').val(priceList.event_date || '');
                $('input[name="price_list[event_location]"]').val(priceList.event_location || '');
            }

        }, 200);

    } catch (err) {
        console.warn("Invalid price_list JSON", err);
    }
} else {
    // If no price_list exists, ensure fields are cleared
    $('#product_type').val('').trigger('change');
    $('#edit_price_list').val('');
}

            
              
            $('#edit_status').val(data.status);

            if (data.meta) {
                $('#edit_validation').val(data.meta.validation || '');
                $('#edit_tooltip').val(data.meta.tooltip || '');
                $('#edit_description').val(data.meta.description || '');
            }

            $('#edit_code_area').val(data.code);
            $('#edit_create_form').val(data.create_form);
            if (data.allow_user_options) {
                $('#allow_user_options').prop('checked', true);
            } else {
                $('#allow_user_options').prop('checked', false);
            }


            // Display At
            $('input[name="display_at[]"]').prop('checked', false);
            if (data.display?.display_at) {
                const display = data.display.display_at;
                $('select[name="page_display_type"]').val(display.type);
                (display.positions || []).forEach(val => {
                    $('input[name="display_at[]"][value="' + val + '"]').prop('checked',
                        true);
                });
            }

            // Create Form
            if (data.display?.create_form) {
                $('#createFormCheckbox').prop('checked', true);
                $('#formNameWrapper').show();
                $('#formName').val(data.display.form_name || '');
            } else {
                $('#createFormCheckbox').prop('checked', false);
                $('#formNameWrapper').hide();
            }

            // Group View
            if (data.group_view) {
                try {
                    const groupViewDecoded = typeof data.group_view === 'string' ? JSON.parse(data
                        .group_view) : data.group_view;
                    if (groupViewDecoded.enabled) {
                        $('#groupCategory').prop('checked', true);
                        if (groupViewDecoded.view_type) {
                            $('input[name="group_view_type"][value="' + groupViewDecoded.view_type +
                                '"]').prop('checked', true);
                        }
                    }
                } catch (e) {
                    console.warn('Invalid group_view JSON:', e);
                }
            }

            // Messages
            if (data.messages) {
                const messages = typeof data.messages === 'string' ? JSON.parse(data.messages) :
                    data.messages;
                $('#edit_user_message').val(messages.user || '');
                $('#edit_own_message').val(messages.own || '');
                $('#edit_custom_message').val(messages.other || '');
            }

            // Notifications
            if (data.notifications) {
                const notifications = typeof data.notifications === 'string' ? JSON.parse(data
                    .notifications) : data.notifications;
                $('#edit_user_notification').val(notifications.user || '');
                $('#edit_own_notification').val(notifications.own || '');
                $('#edit_custom_notification').val(notifications.other || '');
            }

            // Advanced
            if (data.advanced) {
                const adv = data.advanced;
                $('#review_text').val(adv.ratings || '');

                $('#filter_container').html('');
                if (Array.isArray(adv.filters)) {
                    adv.filters.forEach((f, i) => {
                        $('#filter_container').append(`
                            <div class="row g-2 mb-2">
                                <div class="col"><input name="filters[${i}][label]" value="${f.label}" class="form-control"/></div>
                                <div class="col"><input name="filters[${i}][value]" value="${f.value}" class="form-control"/></div>
                                <div class="col"><button type="button" onclick="this.closest('.row').remove()" class="btn btn-danger btn-sm">Remove</button></div>
                            </div>`);
                    });
                }

                $('#feature_container').html('');
                if (Array.isArray(adv.features)) {
                    adv.features.forEach((f, i) => {
                        $('#feature_container').append(`
                            <div class="row g-2 mb-2">
                                <div class="col"><input name="features[${i}]" value="${f}" class="form-control"/></div>
                                <div class="col"><button type="button" onclick="this.closest('.row').remove()" class="btn btn-danger btn-sm">Remove</button></div>
                            </div>`);
                    });
                }

                if (adv.specs?.key && adv.specs.value) {
                    $('#default_spec_container').html('');
                    adv.specs.key.forEach((key, i) => {
                        $('#default_spec_container').append(`
                            <div class="row g-2 mb-2">
                                <div class="col"><input name="default_specifications[key][]" value="${key || ''}" class="form-control"/></div>
                                <div class="col"><input name="default_specifications[value][]" value="${adv.specs.value[i] || ''}" class="form-control"/></div>
                            </div>`);
                    });
                }

                // Integrations
                $('#integration_container').html('');
                if (Array.isArray(adv.integrations)) {
                    adv.integrations.forEach((i, index) => {
                        addIntegration(index, i);
                    });
                }

                // Units
                if (adv.units) {
                    $('#unit_id').val(adv.units.unit_id);
                    $('#editable').prop('checked', adv.units.editable_type === 'editable');
                    $('#non_editable').prop('checked', adv.units.editable_type === 'non_editable');
                    $('#field_count').val(adv.units.inputs.length);
                    const fieldEvent = new Event('change');
                    document.getElementById('field_count').dispatchEvent(fieldEvent);
                    setTimeout(() => {
                        adv.units.inputs.forEach((unit, i) => {
                            $(`input[name='unit_inputs[${i}][title]']`).val(unit
                                .title);
                            $(`input[name='unit_inputs[${i}][value]']`).val(unit
                                .value);
                        });
                        $('select[name="common_unit_id"]').val(adv.units.common_unit_id);
                    }, 500);
                }
            }

            // Subscription Plans
            $('#subscription_container').html('');
            if (Array.isArray(data.subscription_plans)) {
                $('#subscription_container').html('');
                data.subscription_plans.forEach((plan, i) => {
                    addSubscriptionPlan(i, plan);
                });
            }


            // SEO
            if (data.seo) {
                $('#meta_title').val(data.seo.meta_title || '');
                $('#meta_description').val(data.seo.meta_description || '');
                $('#meta_keywords').val(data.seo.meta_keywords || '');
            }

            // 📌 Show previously uploaded media
            if (Array.isArray(data.media)) {
                const mediaWrapper = $('#media-preview-mediaInput-edit');
                mediaWrapper.html(''); // Clear old content

                data.media.forEach(file => {
                    mediaWrapper.append(`
                        <div class="media-file-box" data-media-id="${file.id}">
                            <span class="media-remove" onclick="removeMediaFile(this, ${file.id})">&times;</span>
                            <img src="/storage/${file.file_path}" style="width: 60px; height: 60px; object-fit: cover;" class="mb-2">
                            <input type="hidden" name="category-media-id[]" value="${file.id}">
                            <input type="text" name="category-media-title-${file.id}" class="form-control mb-2" value="${file.title || ''}">
                            <textarea name="category-media-description-${file.id}" class="form-control mb-2" placeholder="Description">${file.description || ''}</textarea>
                            <input type="text" name="category-media-keywords-${file.id}" class="form-control mb-2" placeholder="Keywords" value="${file.keywords || ''}">
                        </div>
                    `);
                });
            }


            // ✅ Preload previously mapped products
            if (data.advanced && data.advanced.product_mappings) {
                selectedProducts = data.advanced.product_mappings.map(item => ({
                    id: item.id,
                    name: item.name,
                    category: item.category
                }));
                renderProductChips(); // call your existing chip render function
            } else {
                selectedProducts = [];
                renderProductChips();
            }


            $('#editCategoryModal').modal('show');

        }
    });
});














// function addIntegration(index = integrationCount++, data = {}) {
//     const container = document.getElementById('integration_container');
//     const html = `
//         <div class="border p-3 mb-2 rounded">
//             <h5>Category: <strong>${currentCategoryName || 'Unknown Category'}</strong></h5>
//             <h6>Integration #${index + 1}</h6>
//             <input name="integrations[${index}][name]" value="${data.name || ''}" class="form-control mb-2" placeholder="Integration Name">
//             <select name="integrations[${index}][type]" class="form-select mb-2">
//                 <option value="">Select Type</option>
//                 <option value="script" ${data.type === 'script' ? 'selected' : ''}>Script</option>
//                 <option value="webhook" ${data.type === 'webhook' ? 'selected' : ''}>Webhook URL</option>
//                 <option value="api_key" ${data.type === 'api_key' ? 'selected' : ''}>API Key</option>
//                 <option value="oauth" ${data.type === 'oauth' ? 'selected' : ''}>OAuth Token</option>
//             </select>
//             <input name="integrations[${index}][code]" value="${data.code || ''}" class="form-control mb-2" placeholder="Code / URL / Key">
//             <textarea name="integrations[${index}][description]" class="form-control mb-2" placeholder="Description">${data.description || ''}</textarea>
//             <div class="form-check">
//                 <input class="form-check-input" type="checkbox" name="integrations[${index}][enabled]" value="1" ${data.enabled ? 'checked' : ''}>
//                 <label class="form-check-label">Enable</label>
//             </div>
//             <button type="button" class="btn btn-sm btn-danger mt-2" onclick="this.closest('.border').remove()">Remove</button>
//         </div>
//     `;
//     container.insertAdjacentHTML('beforeend', html);
// }




//////////////////////////////////////////////





// $(document).on('click', '#showAllCategories', function() {
//     location.reload();
// });

$('#editCategoryForm').submit(function(e) {
    e.preventDefault();
    saveProductData();

    var categoryId = $('#edit_category_id').val();
    var formData = new FormData(this);
    var currentLevelId = $('#breadcrumb li:last').data('category-id');
    $.ajax({
        url: '/admin/categories/' + categoryId + '/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function() {
            $('#editCategoryModal').modal('hide');
            loadCategories(currentLevelId);
        }
    });
});


$(document).on('click', '.delete-category', function() {
    var categoryId = $(this).data('id');
    var categoryName = $(this).data('name');
    var currentLevelId = $('#breadcrumb li:last').data('category-id');

    if (confirm(
            `Are you sure you want to delete "${categoryName}"? This will also delete all its subcategories.`
        )) {
        $.ajax({
            url: '/admin/categories/' + categoryId,
            type: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {
                alert("Category deleted successfully!");
                loadCategories(currentLevelId);
            },
            error: function() {
                alert("Error! Unable to delete category.");
            }
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('edit_functionality_select');

    if (!selectElement) return;

    function handleFunctionalityChange() {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedCond = selectedOption.dataset.cond;

        console.log('🔁 Changed functionality:', selectedOption.value, '→', selectedCond);

        // Hide all
        document.querySelectorAll('#functionality-conditions .condition').forEach(el =>
            el.classList.add('d-none')
        );

        // Show common always
        document.querySelectorAll('#functionality-conditions .condition-common').forEach(el =>
            el.classList.remove('d-none')
        );

        // Show specific group
        if (selectedCond) {
            document.querySelectorAll(`#functionality-conditions .condition-${selectedCond}`)
                .forEach(el => el.classList.remove('d-none'));
        }
    }

    // Bind only once
    selectElement.addEventListener('change', handleFunctionalityChange);

    // Run once in case default value is already selected
    handleFunctionalityChange();
});
</script>

<script>
$(document).ready(function() {



    $('#searchButton').on('click', function() {
        let query = $('#search').val();

        $.ajax({
            url: "{{ route('categories.search') }}",
            type: "GET",
            data: {
                search: query
            },
            success: function(response) {
                $('#categoryTable').html(response);

                // ✅ Find first category with full breadcrumb path
                let fullPathLink = null;
                $('#categoryTable .category-link').each(function() {
                    const bc = $(this).data('breadcrumb');
                    if (Array.isArray(bc) && bc.length > 1) {
                        fullPathLink = $(this);
                        return false; // break loop
                    }
                });

                // ✅ Fallback to first if no full path found
                if (!fullPathLink) {
                    fullPathLink = $('#categoryTable .category-link').first();
                }

                const breadcrumb = fullPathLink.data('breadcrumb');

                if (Array.isArray(breadcrumb)) {
                    // ✅ Remove all breadcrumb items except the first ("All Categories")
                    $('#breadcrumb').find('li').not(':first').remove();

                    breadcrumb.slice(0, -1).forEach((item, index) => {

                        if (index === breadcrumb.length - 1) {
                            $('#breadcrumb').append(`
                                <li class="breadcrumb-item active" data-category-id="${item.id}">
                                    ${item.name}
                                </li>`);
                        } else {
                            $('#breadcrumb').append(`
                                <li class="breadcrumb-item" data-category-id="${item.id}">
                                    <a href="#" class="breadcrumb-link">${item.name}</a>
                                </li>`);
                        }
                    });
                }
            },
            error: function() {
                $('#categoryTable').html(
                    "<tr><td colspan='6' class='text-center'>No categories found.</td></tr>"
                );
            }
        });
    });
});
</script>

<script>
let selectedButton = null;

$(document).on('click', '.toggle-status-btn', function() {
    let categoryId = $(this).data('id');
    selectedButton = $(this); // Store clicked button

    if ($(this).hasClass('is-protected')) {
        let pin = prompt("This category is protected. Enter PIN to continue:");
        if (!pin) return;

        $.post(`/admin/categories/${categoryId}/verify-pin`, {
            _token: "{{ csrf_token() }}",
            pin: pin
        }, function(res) {
            if (res.status === 'success') {
                openStatusModal(categoryId);
            } else {
                alert(res.message || "❌ Invalid PIN.");
            }
        });
    } else {
        openStatusModal(categoryId);
    }
});

function openStatusModal(categoryId) {
    $('#statusCategoryId').val(categoryId);
    $('#statusModal').modal('show');
}

// Handle radio click inside modal
$('#statusForm input[type=radio]').on('change', function() {
    const selectedStatus = $(this).val();
    const categoryId = $('#statusCategoryId').val();

    $.post(`/admin/categories/${categoryId}/update-status`, {
        _token: "{{ csrf_token() }}",
        status: selectedStatus
    }, function(res) {
        if (res.status === 'success') {
            $('#statusModal').modal('hide');
            updateButtonStyle(selectedButton, selectedStatus);
        } else {
            alert(res.message || "Failed to update status.");
        }
    });
});

function updateButtonStyle(button, status) {
    button.removeClass('btn-secondary btn-info btn-success btn-danger');

    if (status === 'default') {
        button.addClass('btn-secondary');
    } else if (status === 'premium') {
        button.addClass('btn-info');
    } else if (status === 'enterprices') {
        button.addClass('btn-success');
    } else if (status === 'admin') {
        button.addClass('btn-danger');
    }
}


function toggleStatus(categoryId) {
    $.post(`/admin/categories/${categoryId}/toggle-status`, {
        _token: "{{ csrf_token() }}"
    }, function(res) {
        alert(res.message || '✅ Status updated.');
        loadCategories($('#breadcrumb li:last').data('category-id'));
    });
}


$(document).on('click', '.lock-btn', function() {
    let categoryId = $(this).data('id');
    let isProtected = $(this).hasClass('btn-secondary');
    if (isProtected) {
        let pin = prompt("Enter PIN to toggle protection:");
        if (!pin) return;
        $.post(`/admin/categories/${categoryId}/toggle-protection`, {
            _token: "{{ csrf_token() }}",
            pin: pin
        }, function(res) {
            alert(res.message);
            loadCategories($('#breadcrumb li:last').data('category-id'));
        });
    } else {
        $.post(`/admin/categories/${categoryId}/toggle-protection`, {
            _token: "{{ csrf_token() }}"
        }, function(res) {
            alert(res.message);
            loadCategories($('#breadcrumb li:last').data('category-id'));
        });
    }
});
</script>

<!-- 
<script>
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('icon-choice')) {
        const selectedClass = e.target.dataset.iconClass;
        if (currentTargetInput) {
            currentTargetInput.value = selectedClass;
            const preview = currentTargetInput.previousElementSibling;
            if (preview && preview.classList.contains('choose-icon-btn')) {
                preview.className = `choose-icon-btn fs-4 ${selectedClass}`;
            }

            // OPTIONAL: AJAX Save
            const categoryId = currentTargetInput.dataset.categoryId;
            if (categoryId) {
                fetch(`/admin/categories/${categoryId}/update-icon`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        icon: selectedClass
                    })
                });
            }

            bootstrap.Modal.getInstance(document.getElementById('iconSelectionModal')).hide();
        }
    }
});
</script> -->

<script>
$(document).ready(function() {
    // Initially hide the form name
    $('#formNameWrapper').hide();

    // Toggle the visibility when the checkbox is checked/unchecked
    $('#createFormCheckbox').change(function() {
        if ($(this).is(':checked')) {
            $('#formNameWrapper').show();
        } else {
            $('#formNameWrapper').hide();
        }
    });
});
</script>

<script>
// ---------- Dropdown: Categorize Level ----------
const dropdownTrigger = document.getElementById("dropdownTrigger");
const dropdownMenu = document.getElementById("dropdownMenu");
const newOptionInput = document.getElementById("newOptionInput");
const dropdownOptions = document.getElementById("dropdownOptions");
const selectedOptionDisplay = document.getElementById("selectedOption");
const levelNameInput = document.getElementById("levelNameInput");

dropdownTrigger.addEventListener("click", () => {
    dropdownMenu.classList.toggle("show");
});

newOptionInput.addEventListener("keydown", function(e) {
    if (e.key === "Enter" && this.value.trim()) {
        const newOptionWrapper = document.createElement("div");
        newOptionWrapper.className = "dropdown-item";

        const newInput = document.createElement("input");
        newInput.type = "text";
        newInput.value = this.value.trim();
        newInput.classList.add("editable-option");

        newOptionWrapper.appendChild(newInput);
        dropdownOptions.appendChild(newOptionWrapper);
        this.value = "";
    }
});

dropdownOptions.addEventListener("click", function(e) {
    if (e.target.tagName === 'INPUT') {
        e.stopPropagation(); // Allow editing input
    } else if (e.target.classList.contains('dropdown-item')) {
        const input = e.target.querySelector("input");
        if (input) {
            selectedOptionDisplay.textContent = input.value;
            levelNameInput.value = input.value;
            dropdownMenu.classList.remove("show");
        }
    }
});

dropdownOptions.addEventListener("focusout", function(e) {
    if (e.target.tagName === 'INPUT') {
        const editedValue = e.target.value;
        if (selectedOptionDisplay.textContent === e.target.defaultValue) {
            selectedOptionDisplay.textContent = editedValue;
            levelNameInput.value = editedValue;
        }
    }
});

// ---------- Close all dropdowns on outside click ----------
document.addEventListener("click", function(event) {
    if (!dropdownMenu.contains(event.target) && !dropdownTrigger.contains(event.target)) {
        dropdownMenu.classList.remove("show");
    }
    if (!conditionsMenu.contains(event.target) && !conditionsTrigger.contains(event.target)) {
        conditionsMenu.classList.remove("show");
    }
});

// ---------- Unit Dropdown on Checkbox ----------
const unitCheckbox = document.getElementById("checkboxUnit");
const unitDropdownWrapper = document.getElementById("unitDropdownWrapper");
const unitSelect = document.getElementById("unitSelect");

unitCheckbox?.addEventListener("change", function() {
    if (this.checked) {
        unitDropdownWrapper.style.display = "block";
        fetch('/admin/categories/children-by-name/Unit')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    unitSelect.innerHTML = '<option value="">Select Unit</option>';
                    data.children.forEach(child => {
                        unitSelect.innerHTML +=
                            `<option value="${child.id}">${child.name}</option>`;
                    });
                } else {
                    alert("No unit categories found.");
                }
            })
            .catch(error => console.error("Error fetching unit categories:", error));
    } else {
        unitDropdownWrapper.style.display = "none";
    }
});

// ---------- Conditions Dropdown + Label Management ----------
const conditionsTrigger = document.getElementById("conditionsDropdownTrigger");
const conditionsMenu = document.getElementById("conditionsDropdownMenu");
const newConditionInput = document.getElementById("newConditionInput");
const conditionsOptions = document.getElementById("conditionsOptions");
const conditionsTextInput = document.getElementById("conditionsTextInput");
const conditionsSelectedText = document.getElementById("conditionsSelectedText");

const labelInputsContainer = document.getElementById("labelInputsContainer");

conditionsTrigger.addEventListener("click", () => {
    conditionsMenu.classList.toggle("show");
});

newConditionInput.addEventListener("keydown", function(e) {
    if (e.key === "Enter" && this.value.trim()) {
        const val = this.value.trim();
        const label = document.createElement("label");
        label.className = "dropdown-item";
        label.innerHTML = `
                <input type="checkbox" class="condition-checkbox" value="${val}"> ${val}
            `;
        conditionsOptions.appendChild(label);
        this.value = "";
    }
});

document.addEventListener("change", function(e) {
    if (e.target.classList.contains("condition-checkbox")) {
        const selected = Array.from(document.querySelectorAll(".condition-checkbox:checked"))
            .map(cb => cb.value);
        conditionsTextInput.value = selected.join(",");
        conditionsSelectedText.textContent = selected.length > 0 ? selected.join(", ") : "Conditions";

        if (selected.includes("Label")) {
            labelInputsContainer.style.display = "flex";
        } else {
            labelInputsContainer.style.display = "none";
            labelInputsContainer.innerHTML = `
                    <input type="text" name="label_name[]" placeholder="Label Name" class="form-control" style="width: auto;">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addMoreLabels">Add More</button>
                `;
        }
    }
});

// Delegate Add More for dynamic label inputs
document.addEventListener("click", function(e) {
    if (e.target && e.target.id === "addMoreLabels") {
        const input = document.createElement("input");
        input.type = "text";
        input.name = "label_name[]";
        input.placeholder = "Label Name";
        input.className = "form-control";
        input.style.width = "90px";
        input.style.marginLeft = "1px";
        labelInputsContainer.insertBefore(input, e.target);
    }
});
</script>

<!-- //drag and drop  -->


<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    const sortable = new Sortable(document.getElementById('categoryTable'), {
        animation: 150,
        handle: '.category-header', // draggable by header
        ghostClass: 'sortable-ghost', // optional visual feedback
        onEnd: function (evt) {
            const ordered = [];

            document.querySelectorAll('#categoryTable .category-card').forEach((el, index) => {
                ordered.push({
                    id: el.dataset.id,
                    position: index + 1
                });
            });

            fetch('/admin/categories/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ ordered })
            }).then(response => {
                if (!response.ok) throw new Error("Server error");
                return response.json();
            }).then(data => {
                console.log("Order updated", data);
            }).catch(err => {
                alert("Failed to reorder categories");
                console.error(err);
            });
        }
    });
</script>

<script>
let selectedAction = null;
let selectedIds = [];

// Select all checkboxes when "Select All" is clicked
$(document).on('change', '.selectAll', function() {
    const isChecked = $(this).is(':checked');
    $('.category-checkbox').prop('checked', isChecked);
});

// Get IDs of all selected checkboxes
function getSelectedIds() {
    return $('.category-checkbox:checked').map(function() {
        return $(this).val();
    }).get();
}

// Handle Copy or Move selection
$('#copySelected, #moveSelected').on('click', function() {
    selectedIds = getSelectedIds();

    if (selectedIds.length === 0) {
        alert("Please select at least one category.");
        return;
    }

    selectedAction = this.id === 'copySelected' ? 'copy' : 'move';
    $('#pasteSelected').removeClass('d-none');

    alert(`Selected ${selectedIds.length} categories to ${selectedAction}. Now click "Paste Here".`);
});

// Handle Paste operation
$('#pasteSelected').on('click', function() {
    const targetId = $('#breadcrumb li:last').data('category-id') || 0;

    $.ajax({
        url: '/admin/categories/bulk-action',
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            category_ids: selectedIds,
            target_id: targetId,
            action: selectedAction
        },
        beforeSend: function() {
            $('#pasteSelected').text("Processing...").attr("disabled", true);
        },
        success: function(response) {
            alert(response.message);
            $('#pasteSelected').addClass('d-none').text("Paste Here").attr("disabled", false);
            selectedIds = [];
            selectedAction = null;
            loadCategories(targetId);
        },
        error: function() {
            alert("Error performing bulk operation.");
            $('#pasteSelected').text("Paste Here").attr("disabled", false);
        }
    });
});
</script>

<script>
$(document).ready(function() {
    const labelSelect = $('.labelSelect');
    const subcategorySelect = $('#subcategorySelect');
    const appLabelFilterText = $('#appLabelFilter'); // <label>
    const appLabelFilterData = $('#appLabelFilterData'); // <select>

    // Load App Labels
   $.ajax({
    url: '/categories/96129/childrens',
    method: 'GET',
    success: function(response) {
        labelSelect.empty();
        appLabelFilterData.empty();
          
        const categories = Array.isArray(response) ? response : (response.children || []);
        
        if (categories.length > 0) {
            labelSelect.append('<option value="">Select App Label</option>');
            appLabelFilterData.append('<option value="">Select App Label</option>');
            
            categories.forEach(function(label) {
                labelSelect.append('<option value="' + label.name + '">' + label.name + '</option>');
                appLabelFilterData.append('<option value="' + label.name + '">' + label.name + '</option>');
            });
            
            appLabelFilterText.text('App Label (' + categories.length + ')');
        } else {
            labelSelect.append('<option value="">No App Labels Found</option>');
            appLabelFilterData.append('<option value="">No App Labels Found</option>');
            appLabelFilterText.text('App Label (0)');
        }
    },
    error: function() {
        labelSelect.html('<option value="">Failed to load labels</option>');
        appLabelFilterData.html('<option value="">Failed to load labels</option>');
        appLabelFilterText.text('App Label (Err)');
    }
});

    // When changing label dropdown
    // $('.labelSelect').on('change', function () {
    //     const selectedLabel = $(this).val();

    //     if (selectedLabel) {
    //         $.ajax({
    //             url: '/admin/categories/icon-by-label/' + encodeURIComponent(selectedLabel),
    //             method: 'GET',
    //             success: function(response) {
    //                 if (response.success && response.icon) {
    //                     $('#icon_input').val(response.icon); // save icon to hidden input
    //                     $('button[data-bs-target="#createAppLabelModal"] .icon-choice')
    //                         .attr('class', response.icon + ' fs-6 icon-choice');
    //                 } else {
    //                     $('#icon_input').val('bx bx-purchase-tag');
    //                 }
    //             }
    //         });
    //     } else {
    //         $('#icon_input').val('bx bx-purchase-tag');
    //     }
    // });


    // Load Subcategories
    labelSelect.on('change', function() {
        const selectedLabel = $(this).val();
        const parentId = $('#app_label_parent_id').val(); // Get current category id
        subcategorySelect.empty();

        if (selectedLabel) {
            subcategorySelect.append('<option value="">Loading...</option>');

            // Load subcategories
            $.ajax({
                url: '/admin/categories/children-by-name/' + encodeURIComponent(selectedLabel),
                method: 'GET',
                success: function(response) {
                    subcategorySelect.empty();
                    if (response.status && response.children.length > 0) {
                        subcategorySelect.append(
                            '<option value="">Select Subcategory</option>');
                        response.children.forEach(function(child) {
                            subcategorySelect.append('<option value="' + child.id +
                                '">' + child.name + '</option>');
                        });
                    } else {
                        subcategorySelect.append(
                            '<option value="">No Subcategories Found</option>');
                    }
                },
                error: function() {
                    subcategorySelect.append(
                        '<option value="">Error loading subcategories</option>');
                }
            });

            // Load and update icon for this specific button
            $.ajax({
                url: '/admin/categories/icon-by-label/' + encodeURIComponent(selectedLabel),
                method: 'GET',
                success: function(response) {
                    if (response.success && response.icon) {
                        $('#icon_input').val(response.icon);

                        // Update the <i> icon only in the specific button
                        $('.icon-choice-' + parentId)
                            .attr('class', response.icon +
                                ' fs-6 icon-choice icon-choice-' + parentId);
                    } else {
                        $('#icon_input').val('bx bx-purchase-tag');
                        $('.icon-choice-' + parentId)
                            .attr('class',
                                'bx bx-purchase-tag fs-6 icon-choice icon-choice-' +
                                parentId);
                    }
                }
            });
        } else {
            subcategorySelect.append('<option value="">Please select an App Label first</option>');
        }
    });


    $('#appLabelFilterData').on('change', function() {
        const selectedLabel = $(this).val();

        if (selectedLabel) {
            $.ajax({
                url: '/categories/filter-by-label/' + encodeURIComponent(selectedLabel),
                type: 'GET',
                success: function(response) {
                    // Inject table rows
                    $('#categoryTable').html(response.html);

                    // Update count in label
                    $('#appLabelFilter').text(`App Label (${response.count})`);

                    // Reset select all
                    $('.selectAll').prop('checked', false);
                },
                error: function() {
                    alert('Failed to load filtered categories.');
                }
            });
        } else {
            $('#appLabelFilter').text('App Label (0)');
        }
    });



});
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {


    $('#createAppLabelModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const parentId = button.data('parent-id');
        const labelJsonString = button.attr('data-label-json'); // get raw JSON string
        let selectedLabel = null;

        // Parse JSON safely
        try {
            const labelJson = JSON.parse(labelJsonString);
            selectedLabel = labelJson.label || null;
        } catch (e) {
            console.error('Invalid JSON:', e);
        }

        $('#app_label_parent_id').val(parentId);

        // Wait for the labelSelect options to load via AJAX
        const interval = setInterval(function() {
            if ($('.labelSelect option').length > 1) {
                $('.labelSelect').val(selectedLabel).trigger('change');
                clearInterval(interval);
            }
        }, 100);
    });


    // 🚀 AJAX form submission
    $('#createAppCategoryForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: '{{ route("category.storeAppLabel") }}',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#createAppLabelModal').modal('hide');

                    // Get selected label & icon
                    const selectedLabel = $('.labelSelect').val();
                    const selectedIcon = $('#icon_input').val();
                    const parentId = $('#app_label_parent_id').val();

                    // Update button's data-label-json
                    const relatedButton = $('button[data-category-id="' + parentId + '"]');
                    relatedButton.attr('data-label-json', JSON.stringify({
                        label: selectedLabel,
                        subcategory: null,
                        icon: selectedIcon
                    }));

                    // ✅ Update the unique icon element
                    $('.icon-choice-' + parentId).attr('class', selectedIcon +
                        ' fs-6 icon-choice icon-choice-' + parentId);

                    // Reset form
                    form[0].reset();

                }

            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message ?? 'Something went wrong.';
                alert(errorMsg);
            }
        });
    });
});












// Product Modal Handler
// $(document).on('click', '.edit-product', function() {
//     const categoryId = $(this).data('id');
//     const modal = $('#editProductModal');

//     $.ajax({
//         url: '/admin/categories/' + categoryId + '/edit',
//         type: 'GET',
//         success: function(data) {
//             // Populate modal content
//             modal.find('.modal-title').text('Edit Product - ' + data.name);

//             $('#edit_category_id').val(data.id); // if needed
//             modal.modal('show');
//         }
//     });
// });

// Service Modal Handler
// $(document).on('click', '.edit-service', function() {
//     const categoryId = $(this).data('id');
//     const modal = $('#editServiceModal');

//     $.ajax({
//         url: '/admin/categories/' + categoryId + '/edit',
//         type: 'GET',
//         success: function(data) {
//             // Populate modal content
//             modal.find('.modal-title').text('Edit Service - ' + data.name);

//             $('#edit_category_id').val(data.id); // if needed
//             modal.modal('show');
//         }
//     });
// });
</script>

<script>
function toggleCategory(element) {
    const card = element.closest('.category-card');
    const content = card.querySelector('.category-content');
    const subcategoryContainer = content.querySelector('.subcategories-container');
    const categoryId = element.getAttribute('data-category-id');

    // Toggle visibility
    element.classList.toggle('expanded');
    content.classList.toggle('show');

    // Load stats into expanded area
    const statsContainer = content.querySelector('.categoryStatsExpanded');
    if (statsContainer) {
        statsContainer.innerHTML = `<span>Loading stats...</span>`;
        loadStatsForCard(categoryId, statsContainer);
    }

    // Load subcategories if not already loaded
    if (!subcategoryContainer.getAttribute('data-loaded')) {
        subcategoryContainer.innerHTML = `<p>Loading...</p>`;

        fetch(`/admin/categories/${categoryId}/children-html`)
            .then(response => response.text())
            .then(html => {
                subcategoryContainer.innerHTML = html;
                subcategoryContainer.setAttribute('data-loaded', 'true');
            })
            .catch(() => {
                subcategoryContainer.innerHTML = `<p>Error loading subcategories</p>`;
            });
    }
}


</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-html');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const name = button.getAttribute('data-name') || 'Unnamed Item';
            document.getElementById('modalItemName').textContent = name;
            document.getElementById('code-category-name').value = name;
        });
    });
});
</script>


<script>
    document.getElementById('recheck-tab').addEventListener('click', function () {
    const htmlContent = document.getElementById('codeEditor').value.trim();

    const output = document.getElementById('recheckOutput');
    if (!htmlContent) {
        output.innerText = '⚠️ No HTML content to analyze.';
        return;
    }

    output.innerText = '⏳ Rechecking HTML... Please wait...';

    fetch('/admin/ai/recheck-html', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ html: htmlContent })
    })
    .then(response => response.json())
    .then(data => {
        output.innerText = data.analysis || '✅ No issues found.';
    })
    .catch(error => {
        console.error('Error during HTML recheck:', error);
        output.innerText = '❌ An error occurred while rechecking HTML.';
    });
});
</script>

<script>
document.getElementById('makePromptBtn').addEventListener('click', function () {
    const userInstruction = document.getElementById('initialPrompt').value.trim();
    const promptBox = document.getElementById('suggestedPrompt');
    const outputBox = document.getElementById('customPromptOutput');

    if (!userInstruction) {
        promptBox.value = '⚠️ Please enter an instruction first.';
        outputBox.innerHTML = '';
        return;
    }

    const promptTemplate = `You are an expert HTML developer and UI/UX assistant.
Based on the instruction: "${userInstruction}", generate a clean, semantic, and accessible HTML structure.
Ensure proper use of ARIA roles, label associations, and grouping.
Avoid styling or JavaScript — only return valid raw HTML.`;

    promptBox.value = promptTemplate;
    outputBox.innerHTML = '<p>⏳ Sending prompt to GPT...</p>';

    fetch('/admin/ai/custom-prompt', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            html: '', // No input HTML required
            prompt: promptTemplate
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.result) {
            outputBox.innerHTML = `<pre class="bg-light p-3 border rounded">${data.result}</pre>`;
        } else {
            outputBox.innerHTML = `<p class="text-danger">❌ ${data.error || 'No response from GPT.'}</p>`;
        }
    })
    .catch(err => {
        console.error('Prompt error:', err);
        outputBox.innerHTML = '<p class="text-danger">❌ Failed to generate response from GPT.</p>';
    });
});
</script>

<script>
   
document.addEventListener('DOMContentLoaded', function () {
document.querySelectorAll('.toggle-publish-status').forEach(function (el) {
    el.addEventListener('click', function (e) {
        
        e.preventDefault(); // prevent default behavior if any
        const badge = this;
        const categoryId = badge.dataset.id;

        // Prevent double click
        if (badge.classList.contains('disabled')) return;

        badge.classList.add('disabled');

        fetch('{{ route('category.toggle-publish') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: categoryId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                badge.textContent = data.new_status;
                badge.className = `badge toggle-publish-status ${data.new_class}`;
            }
        })
        .catch(error => {
            console.error('Error updating publish status:', error);
        })
        .finally(() => {
            badge.classList.remove('disabled');
        });
    });
});
});
</script>

@endsection