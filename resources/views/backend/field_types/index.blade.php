@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Field Types</span>
                    <div>
                        <a href="{{ route('field-types.documentation') }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-book"></i> Documentation
                        </a>
                        <a href="{{ route('field-types.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create New Field Type
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('field-types.index') }}" method="GET" id="search-form">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by name or component...">
                                    <select class="form-select" name="category" onchange="document.getElementById('search-form').submit()">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="form-select" name="status" onchange="document.getElementById('search-form').submit()">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if(request()->anyFilled(['search', 'category', 'status']))
                                        <a href="{{ route('field-types.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-outline-primary btn-sm me-2" type="button" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-file-import"></i> Import
                            </button>
                            <a href="{{ route('field-types.export') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-file-export"></i> Export
                            </a>
                        </div>
                    </div>

                    @if($fieldTypes->isEmpty())
                        <div class="alert alert-info">
                            No field types found. <a href="{{ route('field-types.create') }}">Create a new field type</a> to get started.
                        </div>
                    @else
                        <form id="batch-form" action="{{ route('field-types.batch') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="40">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="select-all">
                                                </div>
                                            </th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Component</th>
                                            <th>Status</th>
                                            <th>Fields</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fieldTypes as $fieldType)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input field-type-checkbox" type="checkbox" name="selected[]" value="{{ $fieldType->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <strong>{{ $fieldType->name }}</strong>
                                                            @if($fieldType->description)
                                                                <div><small class="text-muted">{{ $fieldType->description }}</small></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $fieldType->category->name ?? 'No Category' }}</td>
                                                <td><code>{{ $fieldType->component_name }}</code></td>
                                                <td>
                                                    @if($fieldType->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $fieldType->fields->count() }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('field-types.edit', $fieldType) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-info" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#previewModal" 
                                                                data-field-type="{{ json_encode($fieldType) }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" 
                                                                onclick="confirmDelete('{{ $fieldType->id }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id="delete-form-{{ $fieldType->id }}" 
                                                            action="{{ route('field-types.destroy', $fieldType) }}" 
                                                            method="POST" 
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="batch-actions" style="display: none;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Batch Actions <span class="selected-count badge bg-secondary">0</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><button type="button" class="dropdown-item" onclick="batchAction('activate')">Activate</button></li>
                                            <li><button type="button" class="dropdown-item" onclick="batchAction('deactivate')">Deactivate</button></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><button type="button" class="dropdown-item" onclick="batchAction('duplicate')">Duplicate</button></li>
                                            <li><button type="button" class="dropdown-item text-danger" onclick="batchAction('delete')">Delete</button></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div>
                                    {{ $fieldTypes->appends(request()->query())->links() }}
                                </div>
                            </div>
                            <input type="hidden" name="action" id="batch-action">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Field Type Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modal-preview-container" class="border p-3 rounded mb-3"></div>
                <div class="alert alert-info">
                    <small>This is a preview of how this field type will appear in forms.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="edit-field-type-link" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Field Types</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('field-types.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="importFile" class="form-label">Field Types JSON File</label>
                        <input class="form-control" type="file" id="importFile" name="import_file" accept=".json" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="overwrite" name="overwrite">
                        <label class="form-check-label" for="overwrite">
                            Overwrite existing field types with the same slug
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle select all checkbox
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.field-type-checkbox');
        const batchActions = document.querySelector('.batch-actions');
        const selectedCount = document.querySelector('.selected-count');
        
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateBatchActionsVisibility();
            });
        }
        
        // Handle individual checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBatchActionsVisibility();
                
                // Update "select all" checkbox if needed
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    selectAll.checked = allChecked;
                }
            });
        });
        
        // Preview modal
        const previewModal = document.getElementById('previewModal');
        if (previewModal) {
            previewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const fieldType = JSON.parse(button.getAttribute('data-field-type'));
                
                // Set the modal title
                document.getElementById('previewModalLabel').textContent = `Preview: ${fieldType.name}`;
                
                // Set the edit link
                document.getElementById('edit-field-type-link').href = `/admin/field-types/${fieldType.id}/edit`;
                
                // Generate preview HTML based on field type
                generatePreview(fieldType, 'modal-preview-container');
            });
        }
        
        function updateBatchActionsVisibility() {
            const checkedCount = document.querySelectorAll('.field-type-checkbox:checked').length;
            
            if (checkedCount > 0) {
                batchActions.style.display = 'block';
                selectedCount.textContent = checkedCount;
            } else {
                batchActions.style.display = 'none';
            }
        }
    });
    
    function confirmDelete(fieldTypeId) {
        if (confirm('Are you sure you want to delete this field type? This action cannot be undone.')) {
            document.getElementById('delete-form-' + fieldTypeId).submit();
        }
    }
    
    function batchAction(action) {
        const selectedCount = document.querySelectorAll('.field-type-checkbox:checked').length;
        
        if (selectedCount === 0) {
            alert('Please select at least one field type.');
            return;
        }
        
        let confirmMessage = '';
        
        switch(action) {
            case 'activate':
                confirmMessage = `Are you sure you want to activate ${selectedCount} field type(s)?`;
                break;
            case 'deactivate':
                confirmMessage = `Are you sure you want to deactivate ${selectedCount} field type(s)?`;
                break;
            case 'duplicate':
                confirmMessage = `Are you sure you want to duplicate ${selectedCount} field type(s)?`;
                break;
            case 'delete':
                confirmMessage = `Are you sure you want to delete ${selectedCount} field type(s)? This action cannot be undone.`;
                break;
        }
        
        if (confirm(confirmMessage)) {
            document.getElementById('batch-action').value = action;
            document.getElementById('batch-form').submit();
        }
    }
    
    function generatePreview(fieldType, containerId) {
        const name = fieldType.name || 'Unnamed Field';
        const component = fieldType.component_name || 'text';
        const description = fieldType.description || '';
        const isActive = fieldType.is_active;
        
        let defaultConfig = {};
        try {
            defaultConfig = typeof fieldType.default_config === 'string' 
                ? JSON.parse(fieldType.default_config) 
                : fieldType.default_config || {};
        } catch (e) {
            // Invalid JSON, use empty object
        }
        
        // Generate preview HTML based on component type
        let previewHTML = '';
        
        if (!isActive) {
            previewHTML = '<div class="alert alert-warning">This field type is inactive and will not be available for selection.</div>';
        } else {
            previewHTML = `
                <div class="mb-3">
                    <label class="form-label">${name}</label>
            `;
            
            // Simple component preview based on the component_name
            switch(component.toLowerCase()) {
                case 'text':
                    previewHTML += `<input type="text" class="form-control" placeholder="${defaultConfig.placeholder || 'Enter text...'}" ${defaultConfig.required ? 'required' : ''}>`;
                    break;
                case 'textarea':
                    previewHTML += `<textarea class="form-control" rows="${defaultConfig.rows || 3}" placeholder="${defaultConfig.placeholder || 'Enter text...'}" ${defaultConfig.required ? 'required' : ''}></textarea>`;
                    break;
                case 'select':
                    previewHTML += `<select class="form-select" ${defaultConfig.required ? 'required' : ''}>`;
                    previewHTML += `<option value="">${defaultConfig.placeholder || 'Select an option'}</option>`;
                    if (defaultConfig.options) {
                        for (const [value, label] of Object.entries(defaultConfig.options)) {
                            previewHTML += `<option value="${value}">${label}</option>`;
                        }
                    } else {
                        previewHTML += `<option value="example">Example Option</option>`;
                    }
                    previewHTML += `</select>`;
                    break;
                case 'checkbox':
                    previewHTML += `<div class="form-check">
                                      <input class="form-check-input" type="checkbox" ${defaultConfig.checked ? 'checked' : ''}>
                                      <label class="form-check-label">${defaultConfig.label || 'Check me out'}</label>
                                    </div>`;
                    break;
                case 'radio':
                    if (defaultConfig.options) {
                        for (const [value, label] of Object.entries(defaultConfig.options)) {
                            previewHTML += `<div class="form-check">
                                              <input class="form-check-input" type="radio" name="previewRadio" value="${value}">
                                              <label class="form-check-label">${label}</label>
                                            </div>`;
                        }
                    } else {
                        previewHTML += `<div class="form-check">
                                          <input class="form-check-input" type="radio" name="previewRadio" value="option1">
                                          <label class="form-check-label">Option 1</label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="previewRadio" value="option2">
                                          <label class="form-check-label">Option 2</label>
                                        </div>`;
                    }
                    break;
                case 'number':
                    previewHTML += `<input type="number" class="form-control" 
                                   min="${defaultConfig.min || ''}" 
                                   max="${defaultConfig.max || ''}" 
                                   step="${defaultConfig.step || '1'}" 
                                   placeholder="${defaultConfig.placeholder || 'Enter a number'}" 
                                   ${defaultConfig.required ? 'required' : ''}>`;
                    break;
                case 'date':
                    previewHTML += `<input type="date" class="form-control" ${defaultConfig.required ? 'required' : ''}>`;
                    break;
                case 'file':
                    previewHTML += `<input type="file" class="form-control" ${defaultConfig.required ? 'required' : ''}>`;
                    break;
                default:
                    previewHTML += `<input type="text" class="form-control" placeholder="Default text field">`;
            }
            
            previewHTML += `
                    ${description ? '<small class="form-text text-muted">' + description + '</small>' : ''}
                </div>
            `;
        }
        
        document.getElementById(containerId).innerHTML = previewHTML;
    }
</script>
@endpush
@endsection 