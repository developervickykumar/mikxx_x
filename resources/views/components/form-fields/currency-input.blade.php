@props(['field', 'disabled' => false])

<div class="currency-input-container">
    <div class="input-group">
        <span class="input-group-text" id="currency-symbol-{{ $field->id }}">
            {{ $field->config['currency_symbol'] ?? '$' }}
        </span>
        <input 
            type="text"
            id="field-{{ $field->id }}"
            name="field[{{ $field->id }}]"
            class="form-control {{ $field->input_class }}"
            placeholder="{{ $field->placeholder ?? '0.00' }}"
            @if(old('field.' . $field->id, $field->default_value))
                value="{{ old('field.' . $field->id, $field->default_value) }}"
            @endif
            @if($disabled) disabled @endif
            @if($field->required) required @endif
            @if(isset($field->config['min'])) data-min="{{ $field->config['min'] }}" @endif
            @if(isset($field->config['max'])) data-max="{{ $field->config['max'] }}" @endif
            {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
            data-field-name="{{ $field->name }}"
            data-field-id="{{ $field->id }}"
            @if($field->conditions->count() > 0) data-has-conditions="true" @endif
            oninput="formatCurrency(this)"
            onblur="validateCurrencyValue(this)"
        >
        @if(isset($field->config['show_currency_code']) && $field->config['show_currency_code'])
            <span class="input-group-text">
                {{ $field->config['currency_code'] ?? 'USD' }}
            </span>
        @endif
    </div>
    
    @if($field->help_text)
        <small class="form-text text-muted mt-1">{{ $field->help_text }}</small>
    @endif
</div>

<script>
function formatCurrency(input) {
    // Get input value and remove non-digit characters except decimal point
    let value = input.value.replace(/[^\d.]/g, '');
    
    // Handle decimal places
    const decimalPlaces = {{ $field->config['decimal_places'] ?? 2 }};
    const decimalSeparator = '{{ $field->config['decimal_separator'] ?? '.' }}';
    const thousandsSeparator = '{{ $field->config['thousands_separator'] ?? ',' }}';
    
    // Split the value into whole and decimal parts
    let parts = value.split('.');
    let wholePart = parts[0];
    let decimalPart = parts.length > 1 ? parts[1] : '';
    
    // Limit decimal places
    if (decimalPart.length > decimalPlaces) {
        decimalPart = decimalPart.substring(0, decimalPlaces);
    }
    
    // Add thousands separators to whole part
    if (wholePart.length > 3) {
        wholePart = wholePart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator);
    }
    
    // Combine whole and decimal parts
    if (decimalPart.length > 0) {
        input.value = wholePart + decimalSeparator + decimalPart;
    } else if (value.includes('.')) {
        input.value = wholePart + decimalSeparator;
    } else {
        input.value = wholePart;
    }
}

function validateCurrencyValue(input) {
    // Format on blur to ensure proper formatting
    formatCurrency(input);
    
    // Parse the formatted value to get the numeric value
    const numericValue = parseFloat(input.value.replace(/[^\d.]/g, ''));
    
    // Check if the value is within the specified range
    const min = parseFloat(input.dataset.min);
    const max = parseFloat(input.dataset.max);
    
    if (!isNaN(min) && numericValue < min) {
        input.value = min.toFixed({{ $field->config['decimal_places'] ?? 2 }});
        formatCurrency(input);
    } else if (!isNaN(max) && numericValue > max) {
        input.value = max.toFixed({{ $field->config['decimal_places'] ?? 2 }});
        formatCurrency(input);
    }
    
    // If the field is empty and required, set custom validity message
    if (input.required && input.value.trim() === '') {
        input.setCustomValidity('Please enter a valid amount');
    } else {
        input.setCustomValidity('');
    }
}

// Format currency on page load
document.addEventListener('DOMContentLoaded', function() {
    const currencyInput = document.getElementById('field-{{ $field->id }}');
    if (currencyInput.value) {
        formatCurrency(currencyInput);
    }
});
</script> 