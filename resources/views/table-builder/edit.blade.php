@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Table: {{ $tableBuilder->name }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('table-builder.update', $tableBuilder) }}" method="POST" id="tableBuilderForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Table Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $tableBuilder->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $tableBuilder->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Columns</label>
                            <div id="columns-container">
                                @foreach($tableBuilder->columns as $index => $column)
                                    <div class="column-item mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Column Name</label>
                                                    <input type="text" class="form-control" 
                                                           name="columns[{{ $index }}][name]" 
                                                           value="{{ $column['name'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control" 
                                                            name="columns[{{ $index }}][type]" required>
                                                        <option value="text" {{ $column['type'] == 'text' ? 'selected' : '' }}>Text</option>
                                                        <option value="number" {{ $column['type'] == 'number' ? 'selected' : '' }}>Number</option>
                                                        <option value="decimal" {{ $column['type'] == 'decimal' ? 'selected' : '' }}>Decimal</option>
                                                        <option value="date" {{ $column['type'] == 'date' ? 'selected' : '' }}>Date</option>
                                                        <option value="datetime" {{ $column['type'] == 'datetime' ? 'selected' : '' }}>DateTime</option>
                                                        <option value="boolean" {{ $column['type'] == 'boolean' ? 'selected' : '' }}>Boolean</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Required</label>
                                                    <div class="form-check mt-2">
                                                        <input type="checkbox" class="form-check-input" 
                                                               name="columns[{{ $index }}][required]" 
                                                               value="1" {{ $column['required'] ? 'checked' : '' }}>
                                                        <label class="form-check-label">Yes</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="btn btn-danger btn-block delete-column">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" id="addColumn">
                                <i class="fas fa-plus"></i> Add Column
                            </button>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Table
                            </button>
                            <a href="{{ route('table-builder.show', $tableBuilder) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const columnsContainer = document.getElementById('columns-container');
    const addColumnBtn = document.getElementById('addColumn');
    let columnCount = {{ count($tableBuilder->columns) }};

    function addColumn() {
        const columnDiv = document.createElement('div');
        columnDiv.className = 'column-item mb-3 p-3 border rounded';
        columnDiv.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Column Name</label>
                        <input type="text" class="form-control" name="columns[${columnCount}][name]" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="columns[${columnCount}][type]" required>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="decimal">Decimal</option>
                            <option value="date">Date</option>
                            <option value="datetime">DateTime</option>
                            <option value="boolean">Boolean</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Required</label>
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="columns[${columnCount}][required]" value="1">
                            <label class="form-check-label">Yes</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-block delete-column">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        columnsContainer.appendChild(columnDiv);
        columnCount++;

        // Add event listener for delete button
        columnDiv.querySelector('.delete-column').addEventListener('click', function() {
            columnDiv.remove();
        });
    }

    // Add column button click handler
    addColumnBtn.addEventListener('click', addColumn);

    // Add event listeners for existing delete buttons
    document.querySelectorAll('.delete-column').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.column-item').remove();
        });
    });
});
</script>
@endpush
@endsection 