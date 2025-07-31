@extends('layouts.master')

@section('title')
    @lang('translation.Profile')
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Contacts @endslot
    @slot('title') {{ ucfirst(Auth::user()->user_type) }} Profile @endslot
@endcomponent

@php
use App\Models\Category;

// Load all sectors with full recursive data, including label_json
$sectors = Category::with(['childrenRecursive'])->where('parent_id', 120399)->orderBy('position')->get();

// Helper: Get all leaf units (deepest nodes with no childrenRecursive)
function getLeafUnits($category) {
    $units = [];

    foreach ($category->childrenRecursive as $child) {
        if (empty($child->childrenRecursive) || $child->childrenRecursive->isEmpty()) {
            $units[] = $child;
        } else {
            $units = array_merge($units, getLeafUnits($child));
        }
    }

    return $units;
}
@endphp

<div class="row">
    <div class="col-12">
        <h4 class="ps-md-4 card-title">Sectors</h4>
        <div class="accordion" id="sectorAccordion">
            @foreach($sectors as $index => $sector)
                @php
                    $units = getLeafUnits($sector);
                    $departments = $sector->childrenRecursive;

                    $published = collect($units)->filter(function ($unit) {
                        return !empty($unit['code']);
                    })->count();
                    
                    $pending = collect($units)->filter(function ($unit) {
                        return empty($unit['code']);
                    })->count();

                    
                @endphp

                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                            <span>{{ $sector->name }}</span>
                            <div class="ms-auto d-flex gap-2">
                                <span class="badge bg-secondary">{{ count($units) }} Units</span>
                                <span class="badge bg-success filter-badge" onclick="filterUnits({{ $index }}, 'publish')">{{ $published }} Published</span>
                                <span class="badge bg-warning text-dark filter-badge" onclick="filterUnits({{ $index }}, 'pending')">{{ $pending }} Pending</span>
                                <span class="badge bg-dark filter-badge" onclick="filterUnits({{ $index }}, 'all')">Show All</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#sectorAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                @forelse($departments as $department)
                                    @php
                                        $deptUnits = getLeafUnits($department);
                                    @endphp
                                   <div class="col-md-4 mb-3 department-card" data-sector="{{ $index }}" data-department="{{ $department->id }}">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between">
                                            <strong>{{ $department->name }}</strong>
                                            <span class="badge bg-dark">{{ count($deptUnits) }}</span>
                                        </div>
                                        <div class="card-body d-flex flex-wrap gap-2">
                                            @foreach($deptUnits as $unit)
                                                @php
                                                    $label = data_get($unit->label_json, 'label');
                                                $circleLetter = match($label) {
                                                    'Page' => 'P',
                                                    'Form' => 'F',
                                                    'Video' => 'V',
                                                    'Link' => 'L',
                                                    default => Str::limit($unit->name, 1, '')
                                                };
                                                
                                                $isPublished = !empty($unit->code);
                                                $badgeClass = $isPublished ? 'bg-primary' : 'bg-secondary';

                                                @endphp
                                                <a href="{{ route('module.view', ['parentId' => $unit->id]) }}"
                                                   class="circle-badge {{ $badgeClass }}"
                                                   title="{{ $unit->name }} - {{ $label ?? 'N/A' }}"
                                                   data-status="{{ !empty($unit->code) ? 'publish' : 'pending' }}"
                                                   data-sector="{{ $index }}">
                                                    {{ $circleLetter }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-light">No departments found in this sector.</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .circle-badge {
        width: 16px;
        height: 16px;
        background-color: #17a2b8;
        color: white;
        font-size: 10px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    .circle-badge:hover {
        background-color: #138496;
        text-decoration: none;
    }

    .accordion-button span {
        font-weight: 500;
    }

    .card-body {
        min-height: 60px;
    }

    .filter-badge {
        cursor: pointer;
    }

    .filter-badge:hover {
        opacity: 0.8;
    }
</style>

<!-- JavaScript for Filtering -->
<script>
function filterUnits(sectorIndex, status) {
    const selector = `.circle-badge[data-sector="${sectorIndex}"]`;
    const cardSelector = `.department-card[data-sector="${sectorIndex}"]`;

    // Filter badges
    document.querySelectorAll(selector).forEach(badge => {
        const badgeStatus = badge.getAttribute('data-status');
        badge.style.display = (status === 'all' || badgeStatus === status) ? 'inline-flex' : 'none';
    });

    // Hide department cards with 0 visible badges
    document.querySelectorAll(cardSelector).forEach(card => {
        const visibleBadges = card.querySelectorAll(`.circle-badge[data-sector="${sectorIndex}"]`)
            .length;
        const shownBadges = card.querySelectorAll(`.circle-badge[data-sector="${sectorIndex}"]:not([style*="display: none"])`)
            .length;
        card.style.display = (shownBadges > 0) ? 'block' : 'none';
    });
}
</script>

@endsection
