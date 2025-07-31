@props(['field', 'disabled' => false])

<div class="date-range-container">
    <div class="row">
        <div class="col-md-6">
            <label for="field-{{ $field->id }}-start">Start Date</label>
            <input 
                type="date"
                id="field-{{ $field->id }}-start"
                name="field[{{ $field->id }}][start]"
                class="form-control {{ $field->input_class }}"
                @if(isset(old('field.' . $field->id, $field->default_value)['start']))
                    value="{{ old('field.' . $field->id, $field->default_value)['start'] }}"
                @endif
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                @if(isset($field->config['min'])) min="{{ $field->config['min'] }}" @endif
                {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
                data-field-name="{{ $field->name }}-start"
                data-field-id="{{ $field->id }}"
                @if($field->conditions->count() > 0) data-has-conditions="true" @endif
                onchange="updateEndDateMin('field-{{ $field->id }}')"
            >
        </div>
        <div class="col-md-6">
            <label for="field-{{ $field->id }}-end">End Date</label>
            <input 
                type="date"
                id="field-{{ $field->id }}-end"
                name="field[{{ $field->id }}][end]"
                class="form-control {{ $field->input_class }}"
                @if(isset(old('field.' . $field->id, $field->default_value)['end']))
                    value="{{ old('field.' . $field->id, $field->default_value)['end'] }}"
                @endif
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                @if(isset($field->config['max'])) max="{{ $field->config['max'] }}" @endif
                {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
                data-field-name="{{ $field->name }}-end"
                data-field-id="{{ $field->id }}"
                @if($field->conditions->count() > 0) data-has-conditions="true" @endif
            >
        </div>
    </div>
</div>

<script>
function updateEndDateMin(fieldId) {
    const startDate = document.getElementById(`${fieldId}-start`);
    const endDate = document.getElementById(`${fieldId}-end`);
    
    if (startDate.value) {
        endDate.min = startDate.value;
        
        // If end date is before start date, reset it
        if (endDate.value && endDate.value < startDate.value) {
            endDate.value = startDate.value;
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateEndDateMin('field-{{ $field->id }}');
});
</script> 