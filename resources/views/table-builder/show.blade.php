@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Table Details: {{ $tableBuilder->name }}</h5>
                    <div>
                        <a href="{{ route('table-builder.edit', $tableBuilder) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('table-builder.generate', $tableBuilder) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-database"></i> Generate Table
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Description</h6>
                            <p>{{ $tableBuilder->description ?: 'No description provided.' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Created</h6>
                            <p>{{ $tableBuilder->created_at->format('M d, Y H:i:s') }}</p>
                        </div>
                    </div>

                    <h6>Columns</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tableBuilder->columns as $column)
                                    <tr>
                                        <td>{{ $column['name'] }}</td>
                                        <td>{{ ucfirst($column['type']) }}</td>
                                        <td>
                                            @if($column['required'])
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <h6>SQL Preview</h6>
                        <pre class="bg-light p-3 rounded"><code>CREATE TABLE {{ strtolower(str_replace(' ', '_', $tableBuilder->name)) }} (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    @foreach($tableBuilder->columns as $column)
    {{ $column['name'] }} {{ strtoupper($column['type']) }}{{ $column['required'] ? ' NOT NULL' : '' }},
    @endforeach
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);</code></pre>
                    </div>

                    <!-- Form Preview Section -->
                    <div class="mt-4">
                        <h6>Form Preview</h6>
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    @foreach($tableBuilder->columns as $column)
                                        <div class="mb-3">
                                            <label class="form-label">{{ $column['name'] }}</label>
                                            @switch($column['type'])
                                                @case('text')
                                                    <input type="text" class="form-control" {{ $column['required'] ? 'required' : '' }}>
                                                    @break
                                                @case('number')
                                                    <input type="number" class="form-control" {{ $column['required'] ? 'required' : '' }}>
                                                    @break
                                                @case('decimal')
                                                    <input type="number" step="0.01" class="form-control" {{ $column['required'] ? 'required' : '' }}>
                                                    @break
                                                @case('date')
                                                    <input type="date" class="form-control" {{ $column['required'] ? 'required' : '' }}>
                                                    @break
                                                @case('datetime')
                                                    <input type="datetime-local" class="form-control" {{ $column['required'] ? 'required' : '' }}>
                                                    @break
                                                @case('boolean')
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" {{ $column['required'] ? 'required' : '' }}>
                                                    </div>
                                                    @break
                                            @endswitch
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Graph Preview Section -->
                    <div class="mt-4">
                        <h6>Graph Preview</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas id="barChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas id="pieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: @json($tableBuilder->columns->pluck('name')),
            datasets: [{
                label: 'Sample Data',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: @json($tableBuilder->columns->pluck('name')),
            datasets: [{
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
});
</script>
@endpush
@endsection 