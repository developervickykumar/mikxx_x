@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Table</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('table-builder.store') }}" method="POST" id="tableBuilderForm">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name">Table Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Table Structure</label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tableStructure">
                                    <thead>
                                        <tr>
                                            <th>Column Name</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th>Default Value</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Initial 26 rows -->
                                        @for($i = 0; $i < 26; $i++)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="columns[{{ $i }}][name]" 
                                                           value="{{ chr(65 + $i) }}" required>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="columns[{{ $i }}][type]" required>
                                                        <option value="text">Text</option>
                                                        <option value="number">Number</option>
                                                        <option value="decimal">Decimal</option>
                                                        <option value="date">Date</option>
                                                        <option value="datetime">DateTime</option>
                                                        <option value="boolean">Boolean</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" 
                                                               name="columns[{{ $i }}][required]" value="1">
                                                        <label class="form-check-label">Yes</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" 
                                                           name="columns[{{ $i }}][default]" 
                                                           placeholder="Default value">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm delete-row">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" id="addRow">
                                <i class="fas fa-plus"></i> Add Row
                            </button>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Table
                            </button>
                            <a href="{{ route('table-builder.index') }}" class="btn btn-secondary">
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
    const tableBody = document.querySelector('#tableStructure tbody');
    const addRowBtn = document.getElementById('addRow');
    let rowCount = 26; // Start from 26 since we already have 26 rows

    function addRow() {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" class="form-control" 
                       name="columns[${rowCount}][name]" required>
            </td>
            <td>
                <select class="form-control" name="columns[${rowCount}][type]" required>
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="decimal">Decimal</option>
                    <option value="date">Date</option>
                    <option value="datetime">DateTime</option>
                    <option value="boolean">Boolean</option>
                </select>
            </td>
            <td>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" 
                           name="columns[${rowCount}][required]" value="1">
                    <label class="form-check-label">Yes</label>
                </div>
            </td>
            <td>
                <input type="text" class="form-control" 
                       name="columns[${rowCount}][default]" 
                       placeholder="Default value">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        tableBody.appendChild(tr);
        rowCount++;

        // Add event listener for delete button
        tr.querySelector('.delete-row').addEventListener('click', function() {
            tr.remove();
        });
    }

    // Add row button click handler
    addRowBtn.addEventListener('click', addRow);

    // Add event listeners for existing delete buttons
    document.querySelectorAll('.delete-row').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });

    // Form submission handler
    document.getElementById('tableBuilderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Collect all non-empty rows
        const rows = Array.from(tableBody.querySelectorAll('tr')).filter(row => {
            const nameInput = row.querySelector('input[name$="[name]"]');
            return nameInput && nameInput.value.trim() !== '';
        });

        if (rows.length === 0) {
            alert('Please add at least one column to the table.');
            return;
        }

        // Submit the form
        this.submit();
    });
});
</script>
@endpush
@endsection 