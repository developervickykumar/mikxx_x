@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Add Field to: {{ $form->title }}</span>
                    <div>
                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Form
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('forms.fields.store', $form) }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="label">Field Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                           id="label" name="label" value="{{ old('label') }}" required>
                                    @error('label')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Field Name (system identifier)</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Leave blank to auto-generate from label (recommended)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field_type_id">Field Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('field_type_id') is-invalid @enderror" 
                                            id="field_type_id" name="field_type_id" required>
                                        <option value="">Select field type</option>
                                        
                                        @foreach($fieldTypes as $categoryName => $types)
                                            <optgroup label="{{ $categoryName }}">
                                                @foreach($types as $fieldType)
                                                    <option value="{{ $fieldType->id }}" 
                                                            {{ old('field_type_id') == $fieldType->id ? 'selected' : '' }}>
                                                        {{ $fieldType->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('field_type_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="section">Section (optional)</label>
                                    <input type="text" class="form-control @error('section') is-invalid @enderror" 
                                           id="section" name="section" value="{{ old('section') }}">
                                    @error('section')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Group fields into sections with a heading
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="placeholder">Placeholder</label>
                                    <input type="text" class="form-control @error('placeholder') is-invalid @enderror" 
                                           id="placeholder" name="placeholder" value="{{ old('placeholder') }}">
                                    @error('placeholder')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="help_text">Help Text</label>
                                    <input type="text" class="form-control @error('help_text') is-invalid @enderror" 
                                           id="help_text" name="help_text" value="{{ old('help_text') }}">
                                    @error('help_text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="default_value">Default Value</label>
                                    <input type="text" class="form-control @error('default_value') is-invalid @enderror" 
                                           id="default_value" name="default_value" value="{{ old('default_value') }}">
                                    @error('default_value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">Field Width</label>
                                    <select class="form-select @error('width') is-invalid @enderror" 
                                            id="width" name="width">
                                        <option value="12" {{ old('width', '12') == '12' ? 'selected' : '' }}>Full width</option>
                                        <option value="6" {{ old('width') == '6' ? 'selected' : '' }}>Half width</option>
                                        <option value="4" {{ old('width') == '4' ? 'selected' : '' }}>One third</option>
                                        <option value="3" {{ old('width') == '3' ? 'selected' : '' }}>One quarter</option>
                                    </select>
                                    @error('width')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_field_id">Parent Field (for nested fields)</label>
                                    <select class="form-select @error('parent_field_id') is-invalid @enderror" 
                                            id="parent_field_id" name="parent_field_id">
                                        <option value="">None (top level field)</option>
                                        @foreach($fields as $parentField)
                                            <option value="{{ $parentField->id }}" 
                                                    {{ old('parent_field_id') == $parentField->id ? 'selected' : '' }}>
                                                {{ $parentField->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_field_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Options</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="required" 
                                               name="required" {{ old('required') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="required">
                                            Required field
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_enabled" 
                                               name="is_enabled" {{ old('is_enabled', '1') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_enabled">
                                            Field is enabled
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_visible" 
                                               name="is_visible" {{ old('is_visible', '1') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_visible">
                                            Field is visible
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validation">Validation Rules</label>
                                    <input type="text" class="form-control @error('validation') is-invalid @enderror" 
                                           id="validation" name="validation" value="{{ old('validation') }}">
                                    @error('validation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Laravel validation rules (e.g., "min:3|max:100")
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div id="field-options" class="mb-4">
                            <h5>Field-specific Settings</h5>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Select a field type to see additional settings.
                            </div>

                            <div id="field-type-settings"></div>
                        </div>

                        <div id="conditions-section" class="mb-4 d-none">
                            <h5>Conditional Logic</h5>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="has_conditions" 
                                       name="has_conditions" {{ old('has_conditions') ? 'checked' : '' }}>
                                <label class="form-check-label" for="has_conditions">
                                    Enable conditional logic for this field
                                </label>
                            </div>

                            <div id="conditions-container" class="card p-3 {{ old('has_conditions') ? '' : 'd-none' }}">
                                <p class="text-muted">Set conditions that determine when this field should be shown.</p>
                                
                                <!-- Conditions will be added dynamically here -->
                                <div id="conditions-list"></div>
                                
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-condition">
                                    <i class="fas fa-plus"></i> Add Condition
                                </button>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Add Field
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle conditions section
        const hasConditionsCheckbox = document.getElementById('has_conditions');
        const conditionsContainer = document.getElementById('conditions-container');
        
        if (hasConditionsCheckbox) {
            hasConditionsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    conditionsContainer.classList.remove('d-none');
                } else {
                    conditionsContainer.classList.add('d-none');
                }
            });
        }
        
        // Load field type specific options
        const fieldTypeSelect = document.getElementById('field_type_id');
        const fieldTypeSettings = document.getElementById('field-type-settings');
        
        if (fieldTypeSelect) {
            fieldTypeSelect.addEventListener('change', function() {
                const fieldTypeId = this.value;
                
                if (fieldTypeId) {
                    // Here you would fetch field-specific settings via AJAX
                    // For example:
                    /*
                    fetch(`/admin/field-types/${fieldTypeId}/settings`)
                        .then(response => response.json())
                        .then(data => {
                            fieldTypeSettings.innerHTML = data.html;
                        });
                    */
                    
                    // Show different options based on field type
                    // This is just a simple example
                    const selectedOption = this.options[this.selectedIndex];
                    const fieldTypeName = selectedOption.text.trim().toLowerCase();
                    
                    if (fieldTypeName.includes('select') || 
                        fieldTypeName.includes('radio') || 
                        fieldTypeName.includes('checkbox')) {
                        // Show options for select/radio/checkbox
                        fieldTypeSettings.innerHTML = `
                            <div class="card p-3">
                                <h6>Options</h6>
                                <p class="text-muted small">Add options for this field</p>
                                
                                <div id="options-container">
                                    <div class="row mb-2">
                                        <div class="col-md-5">
                                            <label>Label</label>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Value</label>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    
                                    <div class="row mb-2 option-row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="option_labels[]" placeholder="Option label">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="option_values[]" placeholder="Option value">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-danger remove-option">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-option">
                                    <i class="fas fa-plus"></i> Add Option
                                </button>
                            </div>
                        `;
                        
                        // Add event listener for add option button
                        document.getElementById('add-option').addEventListener('click', function() {
                            const optionsContainer = document.getElementById('options-container');
                            const newOption = document.createElement('div');
                            newOption.className = 'row mb-2 option-row';
                            newOption.innerHTML = `
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="option_labels[]" placeholder="Option label">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="option_values[]" placeholder="Option value">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-danger remove-option">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            `;
                            optionsContainer.appendChild(newOption);
                            
                            // Add event listener to remove button
                            newOption.querySelector('.remove-option').addEventListener('click', function() {
                                newOption.remove();
                            });
                        });
                        
                        // Add event listeners to existing remove buttons
                        document.querySelectorAll('.remove-option').forEach(btn => {
                            btn.addEventListener('click', function() {
                                this.closest('.option-row').remove();
                            });
                        });
                    } else {
                        fieldTypeSettings.innerHTML = `
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> This field type doesn't have additional settings.
                            </div>
                        `;
                    }
                } else {
                    fieldTypeSettings.innerHTML = '';
                }
            });
            
            // Trigger change if a value is already selected (e.g., on validation error)
            if (fieldTypeSelect.value) {
                fieldTypeSelect.dispatchEvent(new Event('change'));
            }
        }
    });
</script>
@endsection
@endsection 