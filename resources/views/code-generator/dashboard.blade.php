@extends('layouts.master')

@section('title', 'Code Generator Dashboard')

@push('styles')
<style>
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
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
        <div class="dashboard-header">
            <h1>Code Generator Dashboard</h1>
            <div class="dashboard-actions">
                <button class="btn btn-primary" id="newTemplateBtn">
                    <i class="fas fa-plus"></i> New Template
                </button>
            </div>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Templates</h3>
                <p class="stat-value">{{ isset($totalTemplates) ? $totalTemplates : 0 }}</p>
            </div>
            <div class="stat-card">
                <h3>Generated Code</h3>
                <p class="stat-value">{{ isset($generatedCodeCount) ? $generatedCodeCount : 0 }}</p>
            </div>
            <div class="stat-card">
                <h3>Active Projects</h3>
                <p class="stat-value">{{ isset($activeProjects) ? $activeProjects : 0 }}</p>
            </div>
        </div>

        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <div class="activity-list">
                @if(isset($recentActivities) && $recentActivities->count() > 0)
                    @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                            <i class="fas {{ $activity->icon }}"></i>
                        </div>
                        <div class="activity-content">
                            <p>{{ $activity->description }}</p>
                            <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
                @else
                <p>No recent activities</p>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newTemplateBtn = document.getElementById('newTemplateBtn');
        
        newTemplateBtn.addEventListener('click', function() {
            window.location.href = '{{ route("code-generator.template-library") }}';
        });
    });
</script>
@endpush 