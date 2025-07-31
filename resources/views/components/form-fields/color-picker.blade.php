@props(['field', 'disabled' => false])

<div class="color-picker-container">
    <div class="input-group">
        <input 
            type="color"
            id="field-{{ $field->id }}"
            name="field[{{ $field->id }}]"
            class="form-control form-control-color {{ $field->input_class }}"
            value="{{ old('field.' . $field->id, $field->default_value ?? '#000000') }}"
            @if($disabled) disabled @endif
            @if($field->required) required @endif
            {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
            data-field-name="{{ $field->name }}"
            data-field-id="{{ $field->id }}"
            @if($field->conditions->count() > 0) data-has-conditions="true" @endif
        >
        <input 
            type="text" 
            id="color-hex-{{ $field->id }}" 
            class="form-control"
            value="{{ old('field.' . $field->id, $field->default_value ?? '#000000') }}"
            @if($disabled) disabled @endif
            oninput="updateColorPicker('{{ $field->id }}')"
        >
    </div>
</div>

<script>
function updateColorPicker(fieldId) {
    const colorPicker = document.getElementById(`field-${fieldId}`);
    const hexInput = document.getElementById(`color-hex-${fieldId}`);
    
    // Update color picker when hex input changes
    colorPicker.value = hexInput.value;
    
    // Update hex input when color picker changes
    colorPicker.addEventListener('input', function() {
        hexInput.value = this.value;
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateColorPicker('{{ $field->id }}');
});
</script>

<style>
.form-control-color {
    width: 3rem;
    height: 38px;
}
</style> 