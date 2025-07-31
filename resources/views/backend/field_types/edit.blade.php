@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Field Type: {{ $fieldType->name }}</span>
                    <a href="{{ route('field-types.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('field-types.update', $fieldType->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group mb-3">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $fieldType->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $fieldType->name) }}" required
                                           onkeyup="updatePreview()">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="component_name">Component Name</label>
                                    <input type="text" class="form-control @error('component_name') is-invalid @enderror" 
                                           id="component_name" name="component_name" value="{{ old('component_name', $fieldType->component_name) }}" required
                                           onkeyup="updatePreview()">
                                    @error('component_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3" 
                                              onkeyup="updatePreview()">{{ old('description', $fieldType->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="default_config">Default Configuration (JSON)</label>
                                    <textarea class="form-control @error('default_config') is-invalid @enderror" 
                                              id="default_config" name="default_config" rows="4"
                                              onkeyup="updatePreview()">{{ old('default_config', json_encode($fieldType->default_config, JSON_PRETTY_PRINT)) }}</textarea>
                                    @error('default_config')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="validation_rules">Validation Rules (JSON)</label>
                                    <textarea class="form-control @error('validation_rules') is-invalid @enderror" 
                                              id="validation_rules" name="validation_rules" rows="4"
                                              onkeyup="updatePreview()">{{ old('validation_rules', json_encode($fieldType->validation_rules, JSON_PRETTY_PRINT)) }}</textarea>
                                    @error('validation_rules')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="supported_attributes">Supported Attributes (JSON)</label>
                                    <textarea class="form-control @error('supported_attributes') is-invalid @enderror" 
                                              id="supported_attributes" name="supported_attributes" rows="4"
                                              onkeyup="updatePreview()">{{ old('supported_attributes', json_encode($fieldType->supported_attributes, JSON_PRETTY_PRINT)) }}</textarea>
                                    @error('supported_attributes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           {{ old('is_active', $fieldType->is_active) ? 'checked' : '' }} onChange="updatePreview()">
                                    <label class="form-check-label" for="is_active">Is Active</label>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        Live Preview
                                    </div>
                                    <div class="card-body">
                                        <div id="preview-container" class="border p-3 rounded mb-3">
                                            <p class="text-muted">Loading preview...</p>
                                        </div>
                                        <div class="alert alert-info">
                                            <small>This preview shows how this field type will appear in forms. Configuration changes are reflected in real-time.</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card mt-3">
                                    <div class="card-header">
                                        Usage Statistics
                                    </div>
                                    <div class="card-body">
                                        <p>Forms using this field type: <span class="badge bg-primary">{{ $fieldType->fields->count() }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                            <div>
                                <button type="submit" class="btn btn-primary">Update Field Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updatePreview() {
        const name = document.getElementById('name').value || 'Unnamed Field';
        const component = document.getElementById('component_name').value || 'text';
        const description = document.getElementById('description').value || '';
        const isActive = document.getElementById('is_active').checked;
        
        let defaultConfig = {};
        try {
            defaultConfig = JSON.parse(document.getElementById('default_config').value);
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
        
        document.getElementById('preview-container').innerHTML = previewHTML;
    }
    
    // Initialize preview on page load
    document.addEventListener('DOMContentLoaded', updatePreview);
</script>
@endpush
@endsection 