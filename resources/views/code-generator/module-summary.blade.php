@extends('layouts.master')

@section('title', 'Module Summary - Code Generator')

@push('styles')
<style>
    .module-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .module-card {
        background: var(--surface-color);
        border-radius: 0.5rem;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
    }
</style>
@endpush

@section('content')
<div class="container">
    @include('code-generator.partials.navigation')
    
    <main class="main-content">
        <div class="module-header">
            <h1>Module Summary</h1>
            <div class="module-actions">
                <button class="btn btn-primary" id="refreshBtn">
                    <i class="fas fa-sync"></i> Refresh
                </button>
            </div>
        </div>

        <div class="module-summary">
            @foreach($modules as $module)
                <div class="module-card">
                    <h3>{{ $module->name }}</h3>
                    <div class="module-stats">
                        <div class="stat">
                            <span class="label">Status:</span>
                            <span class="value {{ $module->status }}">{{ $module->status }}</span>
                        </div>
                        <div class="stat">
                            <span class="label">Progress:</span>
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ $module->progress }}%"></div>
                            </div>
                        </div>
                        <div class="stat">
                            <span class="label">Last Updated:</span>
                            <span class="value">{{ $module->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="module-actions">
                        <a href="{{ route('code-generator.module-details', $module->id) }}" class="btn btn-secondary">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const refreshBtn = document.getElementById('refreshBtn');
        
        refreshBtn.addEventListener('click', function() {
            window.location.reload();
        });
    });
</script>
@endpush 