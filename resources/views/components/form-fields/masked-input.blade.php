@props(['field', 'disabled' => false])

<div class="masked-input-container">
    @php
        $maskType = $field->config['mask_type'] ?? 'custom';
        $mask = $field->config['mask'] ?? '';
        $placeholder = $field->placeholder ?? '';
        
        // Set default masks based on type
        if ($maskType === 'phone') {
            $mask = $field->config['mask'] ?? '(999) 999-9999';
            $placeholder = $field->placeholder ?? '(___) ___-____';
        } elseif ($maskType === 'date') {
            $mask = $field->config['mask'] ?? '99/99/9999';
            $placeholder = $field->placeholder ?? '__/__/____';
        } elseif ($maskType === 'time') {
            $mask = $field->config['mask'] ?? '99:99';
            $placeholder = $field->placeholder ?? '__:__';
        } elseif ($maskType === 'credit_card') {
            $mask = $field->config['mask'] ?? '9999 9999 9999 9999';
            $placeholder = $field->placeholder ?? '____ ____ ____ ____';
        } elseif ($maskType === 'ssn') {
            $mask = $field->config['mask'] ?? '999-99-9999';
            $placeholder = $field->placeholder ?? '___-__-____';
        } elseif ($maskType === 'zip') {
            $mask = $field->config['mask'] ?? '99999-9999';
            $placeholder = $field->placeholder ?? '_____-____';
        }
    @endphp
    
    <input 
        type="text"
        id="field-{{ $field->id }}"
        name="field[{{ $field->id }}]"
        class="form-control {{ $field->input_class }}"
        placeholder="{{ $placeholder }}"
        value="{{ old('field.' . $field->id, $field->default_value) }}"
        @if($disabled) disabled @endif
        @if($field->required) required @endif
        {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
        data-field-name="{{ $field->name }}"
        data-field-id="{{ $field->id }}"
        data-mask-type="{{ $maskType }}"
        data-mask="{{ $mask }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    
    @if($field->help_text)
        <small class="form-text text-muted mt-1">{{ $field->help_text }}</small>
    @endif
</div>

<script src="https://unpkg.com/imask@6.6.1/dist/imask.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initMaskedInput('{{ $field->id }}');
});

function initMaskedInput(fieldId) {
    const inputElement = document.getElementById(`field-${fieldId}`);
    if (!inputElement) return;
    
    const maskType = inputElement.dataset.maskType;
    const customMask = inputElement.dataset.mask;
    
    let maskOptions = {};
    
    switch (maskType) {
        case 'phone':
            maskOptions = {
                mask: customMask || '(000) 000-0000'
            };
            break;
            
        case 'date':
            maskOptions = {
                mask: customMask || '00/00/0000',
                blocks: {
                    mm: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 12
                    },
                    dd: {
                        mask: IMask.MaskedRange,
                        from: 1,
                        to: 31
                    },
                    yyyy: {
                        mask: IMask.MaskedRange,
                        from: 1900,
                        to: 2099
                    }
                }
            };
            break;
            
        case 'time':
            maskOptions = {
                mask: customMask || '00:00',
                blocks: {
                    HH: {
                        mask: IMask.MaskedRange,
                        from: 0,
                        to: 23
                    },
                    MM: {
                        mask: IMask.MaskedRange,
                        from: 0,
                        to: 59
                    }
                }
            };
            break;
            
        case 'credit_card':
            maskOptions = {
                mask: customMask || '0000 0000 0000 0000',
                dispatch: function(appended, dynamicMasked) {
                    const number = (dynamicMasked.value + appended).replace(/\D/g, '');
                    
                    // Detect card type and adjust mask
                    if (number.startsWith('34') || number.startsWith('37')) {
                        return { mask: '0000 000000 00000' }; // American Express
                    } else if (number.startsWith('6')) {
                        return { mask: '0000 0000 0000 0000' }; // Discover/JCB
                    } else if (number.startsWith('5')) {
                        return { mask: '0000 0000 0000 0000' }; // Mastercard
                    } else if (number.startsWith('4')) {
                        return { mask: '0000 0000 0000 0000' }; // Visa
                    }
                    
                    return { mask: '0000 0000 0000 0000' };
                }
            };
            break;
            
        case 'ssn':
            maskOptions = {
                mask: customMask || '000-00-0000'
            };
            break;
            
        case 'zip':
            maskOptions = {
                mask: customMask || '00000-0000'
            };
            break;
            
        case 'currency':
            maskOptions = {
                mask: Number,
                scale: 2,
                signed: false,
                thousandsSeparator: ',',
                padFractionalZeros: true,
                normalizeZeros: true,
                radix: '.',
                mapToRadix: ['.', ',']
            };
            break;
            
        case 'percentage':
            maskOptions = {
                mask: Number,
                scale: 2,
                signed: false,
                min: 0,
                max: 100,
                suffix: '%'
            };
            break;
            
        case 'custom':
        default:
            if (customMask) {
                maskOptions = {
                    mask: customMask
                };
            } else {
                // No mask defined
                return;
            }
    }
    
    // Initialize the mask
    const mask = IMask(inputElement, maskOptions);
    
    // Store the mask instance for potential later use
    window[`mask_${fieldId}`] = mask;
    
    // Update form value before submission
    const form = inputElement.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            inputElement.value = mask.unmaskedValue;
        });
    }
}
</script> 