@props(['field', 'disabled' => false])

<div class="dependent-select-container">
    @php
        $primaryOptions = $field->config['primary_options'] ?? [];
        $dependentOptions = $field->config['dependent_options'] ?? [];
        $primaryLabel = $field->config['primary_label'] ?? 'Primary';
        $dependentLabel = $field->config['dependent_label'] ?? 'Dependent';
        $primaryPlaceholder = $field->config['primary_placeholder'] ?? 'Select ' . $primaryLabel;
        $dependentPlaceholder = $field->config['dependent_placeholder'] ?? 'Select ' . $dependentLabel;
        
        $primaryValue = old('field.' . $field->id . '.primary', $field->default_value['primary'] ?? '');
        $dependentValue = old('field.' . $field->id . '.dependent', $field->default_value['dependent'] ?? '');
    @endphp
    
    <div class="row">
        <div class="col-md-6 mb-2 mb-md-0">
            <label for="field-{{ $field->id }}-primary">{{ $primaryLabel }}</label>
            <select
                id="field-{{ $field->id }}-primary"
                name="field[{{ $field->id }}][primary]"
                class="form-control {{ $field->input_class }}"
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                onchange="updateDependentOptions('{{ $field->id }}')"
                data-field-name="{{ $field->name }}-primary"
                data-field-id="{{ $field->id }}"
            >
                <option value="">{{ $primaryPlaceholder }}</option>
                @foreach($primaryOptions as $option)
                    <option 
                        value="{{ $option['value'] ?? $option['label'] }}"
                        @if($primaryValue == ($option['value'] ?? $option['label'])) selected @endif
                    >
                        {{ $option['label'] }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-6">
            <label for="field-{{ $field->id }}-dependent">{{ $dependentLabel }}</label>
            <select
                id="field-{{ $field->id }}-dependent"
                name="field[{{ $field->id }}][dependent]"
                class="form-control {{ $field->input_class }}"
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                data-field-name="{{ $field->name }}-dependent"
                data-field-id="{{ $field->id }}"
                @if($field->conditions->count() > 0) data-has-conditions="true" @endif
            >
                <option value="">{{ $dependentPlaceholder }}</option>
                @if($primaryValue && isset($dependentOptions[$primaryValue]))
                    @foreach($dependentOptions[$primaryValue] as $option)
                        <option 
                            value="{{ $option['value'] ?? $option['label'] }}"
                            @if($dependentValue == ($option['value'] ?? $option['label'])) selected @endif
                        >
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    
    @if($field->help_text)
        <small class="form-text text-muted mt-2">{{ $field->help_text }}</small>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dependent options
    updateDependentOptions('{{ $field->id }}');
});

function updateDependentOptions(fieldId) {
    const primarySelect = document.getElementById(`field-${fieldId}-primary`);
    const dependentSelect = document.getElementById(`field-${fieldId}-dependent`);
    const primaryValue = primarySelect.value;
    
    // Clear dependent select
    dependentSelect.innerHTML = '';
    
    // Add placeholder option
    const placeholderOption = document.createElement('option');
    placeholderOption.value = '';
    placeholderOption.textContent = '{{ $dependentPlaceholder }}';
    dependentSelect.appendChild(placeholderOption);
    
    // If primary value is selected, populate dependent options
    if (primaryValue) {
        const dependentOptions = @json($dependentOptions);
        const options = dependentOptions[primaryValue] || [];
        
        options.forEach(option => {
            const optionEl = document.createElement('option');
            optionEl.value = option.value || option.label;
            optionEl.textContent = option.label;
            
            // Check if this option should be selected
            const dependentValue = '{{ $dependentValue }}';
            if (dependentValue === (option.value || option.label)) {
                optionEl.selected = true;
            }
            
            dependentSelect.appendChild(optionEl);
        });
    }
    
    // Enable/disable dependent select based on primary value
    dependentSelect.disabled = !primaryValue || {{ $disabled ? 'true' : 'false' }};
}
</script> 