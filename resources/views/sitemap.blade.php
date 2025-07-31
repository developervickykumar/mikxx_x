@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Site Map</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" id="sitemapTabs" role="tablist">
            @foreach($categorizedRoutes as $category => $data)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                            id="{{ $category }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $category }}" 
                            type="button" 
                            role="tab" 
                            aria-controls="{{ $category }}" 
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $data['title'] }}
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="sitemapTabsContent">
            @foreach($categorizedRoutes as $category => $data)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                     id="{{ $category }}" 
                     role="tabpanel" 
                     aria-labelledby="{{ $category }}-tab">
                    
                    <div class="mb-4">
                        <h2 class="text-2xl font-semibold mb-2">{{ $data['title'] }}</h2>
                        <p class="text-gray-600">{{ $data['description'] }}</p>
                    </div>

                    @if(isset($data['subcategories']))
                        <!-- Admin Subcategories -->
                        <div class="space-y-8">
                            @foreach($data['subcategories'] as $subcategory)
                                <div class="border rounded-lg p-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $subcategory['title'] }}</h3>
                                    <p class="text-gray-600 mb-4">{{ $subcategory['description'] }}</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($subcategory['routes'] as $route)
                                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                                <h4 class="font-semibold text-lg mb-2">
                                                    @if($route['name'])
                                                        {{ $route['name'] }}
                                                    @else
                                                        {{ $route['uri'] }}
                                                    @endif
                                                </h4>
                                                <div class="text-sm text-gray-600">
                                                    <p><strong>URL:</strong> {{ $route['uri'] }}</p>
                                                    <p><strong>Methods:</strong> {{ implode(', ', $route['methods']) }}</p>
                                                    @if($route['name'])
                                                        <p><strong>Route Name:</strong> {{ $route['name'] }}</p>
                                                    @endif
                                                </div>
                                                <div class="mt-4 flex space-x-2">
                                                    <a href="{{ url($route['uri']) }}" 
                                                       class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                                        Visit Page
                                                    </a>
                                                    <button type="button" 
                                                            class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#previewModal{{ md5($route['uri']) }}">
                                                        Preview
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Preview Modal -->
                                            <div class="modal fade" 
                                                 id="previewModal{{ md5($route['uri']) }}" 
                                                 tabindex="-1" 
                                                 aria-labelledby="previewModalLabel{{ md5($route['uri']) }}" 
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="previewModalLabel{{ md5($route['uri']) }}">
                                                                Preview: {{ $route['name'] ?? $route['uri'] }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-0">
                                                            <div class="ratio ratio-16x9">
                                                                <iframe src="{{ url($route['uri']) }}" 
                                                                        class="w-100 h-100 border-0"
                                                                        loading="lazy"
                                                                        title="Preview of {{ $route['name'] ?? $route['uri'] }}">
                                                                </iframe>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="{{ url($route['uri']) }}" 
                                                               class="btn btn-primary" 
                                                               target="_blank">
                                                                Open in New Tab
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Regular Categories -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($data['routes'] as $route)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <h3 class="font-semibold text-lg mb-2">
                                        @if($route['name'])
                                            {{ $route['name'] }}
                                        @else
                                            {{ $route['uri'] }}
                                        @endif
                                    </h3>
                                    <div class="text-sm text-gray-600">
                                        <p><strong>URL:</strong> {{ $route['uri'] }}</p>
                                        <p><strong>Methods:</strong> {{ implode(', ', $route['methods']) }}</p>
                                        @if($route['name'])
                                            <p><strong>Route Name:</strong> {{ $route['name'] }}</p>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex space-x-2">
                                        <a href="{{ url($route['uri']) }}" 
                                           class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                                            Visit Page
                                        </a>
                                        <button type="button" 
                                                class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#previewModal{{ md5($route['uri']) }}">
                                            Preview
                                        </button>
                                    </div>
                                </div>

                                <!-- Preview Modal -->
                                <div class="modal fade" 
                                     id="previewModal{{ md5($route['uri']) }}" 
                                     tabindex="-1" 
                                     aria-labelledby="previewModalLabel{{ md5($route['uri']) }}" 
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="previewModalLabel{{ md5($route['uri']) }}">
                                                    Preview: {{ $route['name'] ?? $route['uri'] }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="{{ url($route['uri']) }}" 
                                                            class="w-100 h-100 border-0"
                                                            loading="lazy"
                                                            title="Preview of {{ $route['name'] ?? $route['uri'] }}">
                                                    </iframe>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <a href="{{ url($route['uri']) }}" 
                                                   class="btn btn-primary" 
                                                   target="_blank">
                                                    Open in New Tab
                                                </a>
                                            </div>
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
</div>

@push('scripts')
<script>
    // Initialize Bootstrap tabs
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('#sitemapTabs button'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

        // Handle iframe loading errors
        document.querySelectorAll('iframe').forEach(iframe => {
            iframe.onerror = function() {
                this.srcdoc = '<div class="p-4 text-center text-red-500">Unable to load preview. The page may require authentication or is not accessible.</div>';
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .modal-xl {
        max-width: 90%;
    }
    .modal-body {
        height: 80vh;
    }
    .ratio-16x9 {
        height: 100%;
    }
    iframe {
        background: white;
    }
</style>
@endpush
@endsection 