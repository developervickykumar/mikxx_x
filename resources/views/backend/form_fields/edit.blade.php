@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Edit Field: {{ $field->label }}</span>
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

                    <form method="POST" action="{{ route('forms.fields.update', [$form, $field]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="label">Field Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('label') is-invalid @enderror" 
                                           id="label" name="label" value="{{ old('label', $field->label) }}" required>
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
                                           id="name" name="name" value="{{ old('name', $field->name) }}">
                                    @error('name')
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
                                    <label for="field_type_id">Field Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('field_type_id') is-invalid @enderror" 
                                            id="field_type_id" name="field_type_id" required>
                                        <option value="">Select field type</option>
                                        
                                        @foreach($fieldTypes as $categoryName => $types)
                                            <optgroup label="{{ $categoryName }}">
                                                @foreach($types as $fieldType)
                                                    <option value="{{ $fieldType->id }}" 
                                                            {{ old('field_type_id', $field->field_type_id) == $fieldType->id ? 'selected' : '' }}>
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
                                           id="section" name="section" value="{{ old('section', $field->section) }}">
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
                                           id="placeholder" name="placeholder" value="{{ old('placeholder', $field->placeholder) }}">
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
                                           id="help_text" name="help_text" value="{{ old('help_text', $field->help_text) }}">
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
                                           id="default_value" name="default_value" value="{{ old('default_value', $field->default_value) }}">
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
                                        <option value="12" {{ old('width', $field->width ?? '12') == '12' ? 'selected' : '' }}>Full width</option>
                                        <option value="6" {{ old('width', $field->width) == '6' ? 'selected' : '' }}>Half width</option>
                                        <option value="4" {{ old('width', $field->width) == '4' ? 'selected' : '' }}>One third</option>
                                        <option value="3" {{ old('width', $field->width) == '3' ? 'selected' : '' }}>One quarter</option>
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
                                            @if($parentField->id != $field->id)
                                                <option value="{{ $parentField->id }}" 
                                                        {{ old('parent_field_id', $field->parent_field_id) == $parentField->id ? 'selected' : '' }}>
                                                    {{ $parentField->label }}
                                                </option>
                                            @endif
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
                                               name="required" {{ old('required', $field->required) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="required">
                                            Required field
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_enabled" 
                                               name="is_enabled" {{ old('is_enabled', $field->is_enabled) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_enabled">
                                            Field is enabled
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_visible" 
                                               name="is_visible" {{ old('is_visible', $field->is_visible) ? 'checked' : '' }}>
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
                                           id="validation" name="validation" value="{{ old('validation', $field->validation) }}">
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
                            <div id="field-type-settings">
                                <!-- Field-specific settings will be loaded here via JavaScript -->
                                @if(!empty($field->options))
                                    <div class="card p-3">
                                        <h6>Options</h6>
                                        @if(is_array($field->options) && isset($field->options[0]) && is_array($field->options[0]))
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
                                                
                                                @foreach($field->options as $index => $option)
                                                    <div class="row mb-2 option-row">
                                                        <div class="col-md-5">
                                                            <input type="text" class="form-control" 
                                                                name="option_labels[]" 
                                                                value="{{ $option['label'] ?? '' }}" 
                                                                placeholder="Option label">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" class="form-control" 
                                                                name="option_values[]" 
                                                                value="{{ $option['value'] ?? '' }}" 
                                                                placeholder="Option value">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-sm btn-danger remove-option">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-option">
                                                <i class="fas fa-plus"></i> Add Option
                                            </button>
                                        @else
                                            <!-- Handle non-array options -->
                                            @foreach($field->options as $key => $value)
                                                <div class="mb-3">
                                                    <label for="options_{{ $key }}">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                    <input type="text" class="form-control" 
                                                        id="options_{{ $key }}" name="options[{{ $key }}]" value="{{ $value }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> No additional settings for this field type.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div id="conditions-section" class="mb-4">
                            <h5>Conditional Logic</h5>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="has_conditions" 
                                       name="has_conditions" {{ $field->conditions->count() > 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="has_conditions">
                                    Enable conditional logic for this field
                                </label>
                            </div>

                            <div id="conditions-container" class="card p-3 {{ $field->conditions->count() > 0 ? '' : 'd-none' }}">
                                <p class="text-muted">Set conditions that determine when this field should be shown.</p>
                                
                                <!-- Existing conditions -->
                                <div id="conditions-list">
                                    @foreach($field->conditions as $index => $condition)
                                        <div class="condition-row mb-3 border-bottom pb-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select name="conditions[{{ $index }}][field_id]" class="form-select">
                                                        <option value="">Select field</option>
                                                        @foreach($form->fields as $formField)
                                                            @if($formField->id != $field->id)
                                                                <option value="{{ $formField->id }}" {{ $condition->dependent_field_id == $formField->id ? 'selected' : '' }}>
                                                                    {{ $formField->label }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select name="conditions[{{ $index }}][operator]" class="form-select">
                                                        <option value="equals" {{ $condition->operator == 'equals' ? 'selected' : '' }}>Equals</option>
                                                        <option value="not_equals" {{ $condition->operator == 'not_equals' ? 'selected' : '' }}>Not equals</option>
                                                        <option value="contains" {{ $condition->operator == 'contains' ? 'selected' : '' }}>Contains</option>
                                                        <option value="greater_than" {{ $condition->operator == 'greater_than' ? 'selected' : '' }}>Greater than</option>
                                                        <option value="less_than" {{ $condition->operator == 'less_than' ? 'selected' : '' }}>Less than</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="conditions[{{ $index }}][value]" class="form-control" 
                                                           value="{{ $condition->value }}" placeholder="Value">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-sm btn-danger remove-condition">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-condition">
                                    <i class="fas fa-plus"></i> Add Condition
                                </button>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Field
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
        
        // Add new condition
        const addConditionBtn = document.getElementById('add-condition');
        const conditionsList = document.getElementById('conditions-list');
        
        if (addConditionBtn) {
            addConditionBtn.addEventListener('click', function() {
                const index = document.querySelectorAll('.condition-row').length;
                const newCondition = document.createElement('div');
                newCondition.className = 'condition-row mb-3 border-bottom pb-3';
                newCondition.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            <select name="conditions[${index}][field_id]" class="form-select">
                                <option value="">Select field</option>
                                @foreach($form->fields as $formField)
                                    @if($formField->id != $field->id)
                                        <option value="{{ $formField->id }}">{{ $formField->label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="conditions[${index}][operator]" class="form-select">
                                <option value="equals">Equals</option>
                                <option value="not_equals">Not equals</option>
                                <option value="contains">Contains</option>
                                <option value="greater_than">Greater than</option>
                                <option value="less_than">Less than</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="conditions[${index}][value]" class="form-control" placeholder="Value">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-danger remove-condition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                conditionsList.appendChild(newCondition);
                
                // Attach event listener to the new remove button
                const removeBtn = newCondition.querySelector('.remove-condition');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        newCondition.remove();
                    });
                }
            });
        }
        
        // Remove condition
        const removeConditionBtns = document.querySelectorAll('.remove-condition');
        removeConditionBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const conditionRow = this.closest('.condition-row');
                if (conditionRow) {
                    conditionRow.remove();
                }
            });
        });

        // Load field type specific options
        const fieldTypeSelect = document.getElementById('field_type_id');
        const fieldTypeSettings = document.getElementById('field-type-settings');
        
        // Add option button functionality
        const addOptionBtn = document.getElementById('add-option');
        if (addOptionBtn) {
            addOptionBtn.addEventListener('click', function() {
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
        }
        
        // Remove option button functionality
        const removeOptionBtns = document.querySelectorAll('.remove-option');
        removeOptionBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const optionRow = this.closest('.option-row');
                if (optionRow) {
                    optionRow.remove();
                }
            });
        });
        
        // Field type change handler
        if (fieldTypeSelect) {
            fieldTypeSelect.addEventListener('change', function() {
                const fieldTypeId = this.value;
                
                if (fieldTypeId) {
                    // You would fetch field-specific settings via AJAX here
                    // This is a simplified example
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
        }
    });
</script>
@endsection
@endsection 