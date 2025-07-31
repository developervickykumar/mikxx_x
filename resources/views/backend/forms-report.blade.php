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

<div class="row">
    <div class="col-xl-12">
        <div class="card">

            @php
            use App\Models\Category;

            // Parent category ID
            $horizontalTabs = Category::where('parent_id', 110719)->orderBy('position')->get();
            @endphp

            <div class="card-body">
                @php
                $horizontalTabs = \App\Models\Category::where('parent_id', 110719)->orderBy('position')->get();
                @endphp

                <!-- Horizontal Tabs -->
                <ul class="nav nav-tabs mb-3" id="horizontalTabs" role="tablist">
                    @foreach($horizontalTabs as $hIndex => $hTab)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $hIndex == 0 ? 'active' : '' }}" id="tab-{{ $hTab->id }}-tab"
                            data-bs-toggle="tab" data-bs-target="#tab-{{ $hTab->id }}" type="button" role="tab">
                            {{ $hTab->name }}
                        </button>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="horizontalTabsContent">
                    @foreach($horizontalTabs as $hIndex => $hTab)
                    @php
                    $secondLevelTabs = $hTab->children()->orderBy('position')->get();
                    @endphp
                    <div class="tab-pane fade {{ $hIndex == 0 ? 'show active' : '' }}" id="tab-{{ $hTab->id }}"
                        role="tabpanel">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Vertical Tabs -->
                                <div class="nav flex-column nav-pills" id="v-tabs-{{ $hTab->id }}" role="tablist"
                                    aria-orientation="vertical">
                                    @foreach($secondLevelTabs as $vIndex => $vTab)
                                    <button class="nav-link {{ $vIndex == 0 ? 'active' : '' }}"
                                        id="v-tab-{{ $vTab->id }}-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-tab-{{ $vTab->id }}" type="button" role="tab">
                                        {{ $vTab->name }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-9">
                                <!-- Vertical Tab Content: List of Child Items -->
                                <div class="tab-content" id="v-tabs-content-{{ $hTab->id }}">
                                    @foreach($secondLevelTabs as $vIndex => $vTab)
                                    @php
                                    $childItems = $vTab->children()->orderBy('position')->get();
                                    @endphp

                                    <div class="tab-pane fade {{ $vIndex == 0 ? 'show active' : '' }}"
                                        id="v-tab-{{ $vTab->id }}" role="tabpanel">
                                        <h5 class="mb-3">{{ $vTab->name }} - Subcategories</h5>
                                        @if($childItems->isNotEmpty())
                                        <div class="mb-3">
                                            <label class="form-label">Select Chart Type:</label>
                                            <select class="form-select chart-type-selector"
                                                data-chart-id="chart-{{ $vTab->id }}">
                                                <option value="bar">Bar</option>
                                                <option value="pie">Pie</option>
                                                <option value="line">Line</option>
                                            </select>
                                        </div>

                                        <ul class="list-group subcategory-list" data-chart-id="chart-{{ $vTab->id }}">
                                            @foreach($childItems as $child)
                                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                                data-label="{{ $child->name }}">
                                                {{ $child->name }}
                                                <span
                                                    class="badge bg-primary-subtle text-primary fw-semibold random-value">--</span>
                                            </li>
                                            @endforeach
                                        </ul>

                                        <canvas id="chart-{{ $vTab->id }}" height="150" class="mb-4"></canvas>

                                        @else
                                        <p>No subcategories found.</p>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>



            </div>



        </div>

    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const charts = {};

    function generateRandomData(count) {
        return Array.from({ length: count }, () => Math.floor(Math.random() * 100));
    }

    function renderChart(chartId, type, labels, data) {
        const ctx = document.getElementById(chartId).getContext('2d');

        // Destroy previous chart
        if (charts[chartId]) {
            charts[chartId].destroy();
        }

        const config = {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Report Data',
                    data: data,
                    backgroundColor: [
                        '#6366f1', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#ec4899', '#0ea5e9'
                    ],
                    borderColor: '#6366f1',
                    borderWidth: 1,
                    fill: type === 'line',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: type !== 'bar' }
                },
                indexAxis: (type === 'bar') ? 'x' : undefined,
                scales: (type === 'pie') ? {} : {
                    y: { beginAtZero: true }
                }
            }
        };

        charts[chartId] = new Chart(ctx, config);
    }

    // Initial Render
    document.querySelectorAll('.subcategory-list').forEach(list => {
        const chartId = list.getAttribute('data-chart-id');
        const labels = Array.from(list.querySelectorAll('li')).map(li => li.dataset.label);
        const data = generateRandomData(labels.length);

        // Apply values next to each <li>
        list.querySelectorAll('li').forEach((li, idx) => {
            li.querySelector('.random-value').textContent = data[idx];
        });

        renderChart(chartId, 'bar', labels, data);
    });

    // Change Chart Type
    document.querySelectorAll('.chart-type-selector').forEach(selector => {
        selector.addEventListener('change', function () {
            const chartId = this.getAttribute('data-chart-id');
            const type = this.value;
            const list = document.querySelector(`.subcategory-list[data-chart-id="${chartId}"]`);
            const labels = Array.from(list.querySelectorAll('li')).map(li => li.dataset.label);
            const data = Array.from(list.querySelectorAll('.random-value')).map(span => parseInt(span.textContent));

            renderChart(chartId, type, labels, data);
        });
    });

});
</script>