@props(['field', 'disabled' => false])

<div class="otp-field-container">
    <div class="otp-inputs d-flex justify-content-center" id="otp-container-{{ $field->id }}">
        @php
            $digit_count = $field->config['digit_count'] ?? 6;
            $old_value = old('field.' . $field->id, $field->default_value);
            $old_value_array = $old_value ? str_split($old_value) : [];
        @endphp
        
        <input type="hidden" 
            id="field-{{ $field->id }}" 
            name="field[{{ $field->id }}]" 
            value="{{ $old_value }}"
            @if($field->required) required @endif
            data-field-name="{{ $field->name }}"
            data-field-id="{{ $field->id }}"
            @if($field->conditions->count() > 0) data-has-conditions="true" @endif
        >
        
        @for($i = 0; $i < $digit_count; $i++)
            <input 
                type="text"
                class="otp-digit form-control text-center mx-1"
                id="otp-digit-{{ $field->id }}-{{ $i }}"
                maxlength="1"
                pattern="[0-9]"
                inputmode="numeric"
                value="{{ isset($old_value_array[$i]) ? $old_value_array[$i] : '' }}"
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                onkeyup="handleOtpInput(event, '{{ $field->id }}', {{ $i }}, {{ $digit_count }})"
                onfocus="this.select()"
            >
        @endfor
    </div>
    
    @if($field->help_text)
        <small class="form-text text-muted text-center d-block mt-2">{{ $field->help_text }}</small>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus first input when page loads
    setTimeout(() => {
        const firstDigit = document.getElementById('otp-digit-{{ $field->id }}-0');
        if (firstDigit && !{{ $disabled ? 'true' : 'false' }}) {
            firstDigit.focus();
        }
    }, 100);
});

function handleOtpInput(event, fieldId, index, digitCount) {
    const input = event.target;
    const key = event.key;
    const value = input.value;
    
    // Only allow numbers
    if (value && !/^[0-9]$/.test(value)) {
        input.value = '';
        return;
    }
    
    // Move to next input if a digit was entered
    if (value && index < digitCount - 1) {
        const nextInput = document.getElementById(`otp-digit-${fieldId}-${index + 1}`);
        if (nextInput) {
            nextInput.focus();
        }
    }
    
    // Handle backspace
    if (key === 'Backspace' && !value && index > 0) {
        const prevInput = document.getElementById(`otp-digit-${fieldId}-${index - 1}`);
        if (prevInput) {
            prevInput.focus();
            // Optionally clear the previous input
            // prevInput.value = '';
        }
    }
    
    // Update the hidden input with all values
    updateOtpHiddenField(fieldId, digitCount);
}

function updateOtpHiddenField(fieldId, digitCount) {
    const hiddenInput = document.getElementById(`field-${fieldId}`);
    let otpValue = '';
    
    for (let i = 0; i < digitCount; i++) {
        const digitInput = document.getElementById(`otp-digit-${fieldId}-${i}`);
        otpValue += digitInput.value || '';
    }
    
    hiddenInput.value = otpValue;
}
</script>

<style>
.otp-digit {
    width: 45px;
    height: 45px;
    font-size: 1.2rem;
    font-weight: bold;
}
.otp-field-container {
    margin-bottom: 1rem;
}
</style> 