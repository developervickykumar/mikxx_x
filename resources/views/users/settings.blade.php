@extends('layouts.master')

@section('content')
<div class="card-body">
    <!-- Horizontal Nav Tabs for Parent Categories -->
    <ul class="nav nav-tabs mb-3" role="tablist">
        @foreach ($settingsData as $index => $group)
            <li class="nav-item">
                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                   href="#tab-{{ $group->id }}" role="tab">
                    <span class="d-sm-block">{{ $group->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach ($settingsData as $index => $group)
        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ $group->id }}" role="tabpanel">
            <div class="row">
                <!-- Left Side Vertical Nav-Pills for Children -->
                <div class="col-md-2">
                    @php $children = $group->children; @endphp

                    @if($children->count())
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            @foreach ($children as $cIndex => $child)
                                <a class="nav-link {{ $cIndex === 0 ? 'active' : '' }}" 
                                   id="child-tab-{{ $child->id }}" data-bs-toggle="pill" 
                                   href="#child-content-{{ $child->id }}" role="tab">
                                    <i class="{{ $child->icon ?? 'mdi mdi-image' }}"></i>
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No child categories available.</p>
                    @endif
                </div>

                <!-- Right Side Content Area for Children -->
                <div class="col-md-10">
                    <div class="tab-content">
                        @foreach ($children as $cIndex => $child)
                        <div class="tab-pane fade {{ $cIndex === 0 ? 'show active' : '' }}" 
                             id="child-content-{{ $child->id }}" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <h5>{{ $child->name }}</h5>
                                    <p class="text-muted">No further subcategories available.</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
