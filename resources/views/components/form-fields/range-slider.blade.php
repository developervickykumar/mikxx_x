@props(['field', 'disabled' => false])

<div class="range-slider-container">
    <div class="d-flex">
        <input 
            type="range"
            id="field-{{ $field->id }}"
            name="field[{{ $field->id }}]"
            class="form-range {{ $field->input_class }}"
            value="{{ old('field.' . $field->id, $field->default_value) }}"
            min="{{ isset($field->config['min']) ? $field->config['min'] : 0 }}"
            max="{{ isset($field->config['max']) ? $field->config['max'] : 100 }}"
            step="{{ isset($field->config['step']) ? $field->config['step'] : 1 }}"
            @if($disabled) disabled @endif
            @if($field->required) required @endif
            {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
            data-field-name="{{ $field->name }}"
            data-field-id="{{ $field->id }}"
            @if($field->conditions->count() > 0) data-has-conditions="true" @endif
            oninput="updateRangeValue('{{ $field->id }}')"
        >
        <output for="field-{{ $field->id }}" id="range-value-{{ $field->id }}" class="ms-2">
            {{ old('field.' . $field->id, $field->default_value) }}
        </output>
    </div>
    
    @if(isset($field->config['show_min_max']) && $field->config['show_min_max'])
        <div class="d-flex justify-content-between mt-1">
            <small>{{ isset($field->config['min']) ? $field->config['min'] : 0 }}</small>
            <small>{{ isset($field->config['max']) ? $field->config['max'] : 100 }}</small>
        </div>
    @endif
</div>

<script>
function updateRangeValue(fieldId) {
    const range = document.getElementById(`field-${fieldId}`);
    const output = document.getElementById(`range-value-${fieldId}`);
    output.textContent = range.value;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRangeValue('{{ $field->id }}');
});
</script>

<style>
.form-range {
    width: 100%;
}

.form-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d6efd;
    cursor: pointer;
}

.form-range::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d6efd;
    cursor: pointer;
}
</style> 