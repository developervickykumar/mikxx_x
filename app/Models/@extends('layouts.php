@extends('layouts.master')

@section('title')
@lang('translation.Profile')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Contacts @endslot
@slot('title')
{{ ucfirst(Auth::user()->user_type) }} Profile
@endslot
@endcomponent

<style>
.btn-trans:hover {
    background-color: #e3e3e3;
    border: none;
}
</style>

<div class="row">
    <div class="col-xl-12">
        <div class="nav flex-row nav-pills me-3" id="v-tabs" role="tablist" aria-orientation="vertical">
            @foreach($primaryTabs as $index => $group)
            <button class="border text-start nav-link {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $group->id }}-tab"
                data-bs-toggle="pill" data-bs-target="#tab-{{ $group->id }}" type="button" role="tab"
                aria-controls="tab-{{ $group->id }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                <i class="{{ $group->icon ?? 'mdi mdi-folder' }}"></i> {{ $group->name }}
            </button>
            @endforeach
        </div>
    </div>

    @php  

    $descendants  = $group->getCategoryTreeByParentId($group->id);

    @endphp

    @if(count($descendants))


    <div class="col-xl-12">
        <div class="nav flex-row nav-pills me-3" id="v-tabs" role="tablist" aria-orientation="vertical">
            @foreach($descendants as $child)
            <button class="border text-start nav-link {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $child->id }}-tab"
                data-bs-toggle="pill" data-bs-target="#tab-{{ $child->id }}" type="button" role="tab"
                aria-controls="tab-{{ $child->id }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                <i class="{{ $child->icon ?? 'mdi mdi-folder' }}"></i> {{ $child->name }}
            </button>
            @endforeach
        </div>
    </div>

    @endif


    @php

    $children =  $descendants;


    @endphp

    <div class="col-md-12 pt-3">
    <div class="tab-content" id="v-tabs-content">
        @foreach($primaryTabs as $index => $group)
        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
            id="tab-{{ $group->id }}" role="tabpanel" aria-labelledby="tab-{{ $group->id }}-tab">

            @php $children = $group->children ?? []; @endphp

            @if(count($children))
                @if($loop->index === 0 || $loop->index === 1)
                    <!-- Level 2 Horizontal View for First and Second -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($children as $child)
                        <div class="border p-2 rounded d-flex flex-column" style="min-width: 200px;">
                            <div class="d-flex align-items-center">
                                <i class="{{ $child->icon ?? 'mdi mdi-folder' }} me-2"></i>
                                <a href="{{ route('tab.form', ['parent_id' => $child->id]) }}">{{ $child->name }}</a>
                            </div>
                            @php $grandChildren = $child->children ?? []; @endphp
                            @if(count($grandChildren))
                                <ul class="list-unstyled mt-2 ms-3">
                                    @foreach($grandChildren as $grand)
                                    <li>
                                        <a href="{{ route('tab.form', ['parent_id' => $grand->id]) }}">
                                            {{ $grand->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Level 2 Vertical View for Third and Others -->
                    <ul class="list-group list-group-flush">
                        @foreach($children as $child)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="{{ $child->icon ?? 'mdi mdi-folder' }}"></i>
                                    <a href="{{ route('tab.form', ['parent_id' => $child->id]) }}" class="ms-1">
                                        {{ $child->name }}
                                    </a>
                                    @php $grandChildren = $child->children ?? []; @endphp
                                    @if(count($grandChildren))
                                        <ul class="list-unstyled mt-2 ms-4">
                                            @foreach($grandChildren as $grand)
                                            <li>
                                                <a href="{{ route('tab.form', ['parent_id' => $grand->id]) }}">
                                                    {{ $grand->name }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <button class="btn btn-sm text-secondary open-settings-modal"
                                    data-child-id="{{ $child->id }}"
                                    data-child-name="{{ $child->name }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#settingsModal">
                                    <i class="fas fa-cog"></i>
                                </button>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            @else
                <p class="text-muted">No child tabs found for this group.</p>
            @endif

        </div>
        @endforeach
    </div>
</div>


    <div class="col-md-10 pt-3">
        <div class="card">
            <div style="background-color: #f8f9fa;">

                <div class="row">
                    <div class="col-md-12">

                        <div class="d-flex align-items-center">
                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-filter-variant"></i>
                                <span>Filter</span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-sort-variant"></i>
                                <span>Sort</span>
                            </div>
                            <div class="ms-2 p-2">
                                <div class="input-group">
                                    <input type="text" id="search" class="form-control m-0 bg-white"
                                        placeholder="Search categories...">
                                    <button class="btn btn-primary" id="searchButton">Search</button>

                                </div>
                            </div>
                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-chart-box-outline fs-4 icon-choice"></i>
                                <span> <a href="{{ route('form-report') }}">Report</a></span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-eye-check-outline fs-4 icon-choice" data-bs-toggle="modal"
                                    data-bs-target="#permissionModal" style="cursor: pointer;"></i>
                                <span>Show/Hide</span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-code-tags fs-4 icon-choice"></i>
                                <span>Embed</span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-link fs-4 icon-choice"></i>
                                <span>Copy Link</span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-qrcode fs-4 icon-choice"></i>
                                <span>QR Code</span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-export fs-4 icon-choice"></i>
                                <span>Export</span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-import fs-4 icon-choice"></i>
                                <span>Import</span>
                            </div>

                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-code-brackets fs-4 icon-choice"></i>
                                <span>Integrations</span>
                            </div>


                            <div class="align-items-center d-flex gap-1 justify-content-center btn-trans btn-trans p-2">
                                <i class="mdi mdi-api fs-4 icon-choice"></i>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection