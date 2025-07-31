@props(['field', 'disabled' => false])

<div class="address-field-container">
    <div class="row mb-2">
        <div class="col-12">
            <label for="field-{{ $field->id }}-street">{{ $field->config['labels']['street'] ?? 'Street Address' }}</label>
            <input 
                type="text"
                id="field-{{ $field->id }}-street"
                name="field[{{ $field->id }}][street]"
                class="form-control {{ $field->input_class }}"
                placeholder="{{ $field->config['placeholders']['street'] ?? 'Street Address' }}"
                @if(isset(old('field.' . $field->id, $field->default_value)['street']))
                    value="{{ old('field.' . $field->id, $field->default_value)['street'] }}"
                @endif
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                data-field-name="{{ $field->name }}-street"
                data-field-id="{{ $field->id }}"
                @if($field->conditions->count() > 0) data-has-conditions="true" @endif
            >
        </div>
    </div>
    
    <div class="row mb-2">
        <div class="col-md-6 mb-2 mb-md-0">
            <label for="field-{{ $field->id }}-city">{{ $field->config['labels']['city'] ?? 'City' }}</label>
            <input 
                type="text"
                id="field-{{ $field->id }}-city"
                name="field[{{ $field->id }}][city]"
                class="form-control {{ $field->input_class }}"
                placeholder="{{ $field->config['placeholders']['city'] ?? 'City' }}"
                @if(isset(old('field.' . $field->id, $field->default_value)['city']))
                    value="{{ old('field.' . $field->id, $field->default_value)['city'] }}"
                @endif
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                data-field-name="{{ $field->name }}-city"
                data-field-id="{{ $field->id }}"
            >
        </div>
        <div class="col-md-6">
            <label for="field-{{ $field->id }}-state">{{ $field->config['labels']['state'] ?? 'State/Province' }}</label>
            @if(isset($field->config['states']) && is_array($field->config['states']) && count($field->config['states']) > 0)
                <select
                    id="field-{{ $field->id }}-state"
                    name="field[{{ $field->id }}][state]"
                    class="form-control {{ $field->input_class }}"
                    @if($disabled) disabled @endif
                    @if($field->required) required @endif
                    data-field-name="{{ $field->name }}-state"
                    data-field-id="{{ $field->id }}"
                >
                    <option value="">{{ $field->config['placeholders']['state'] ?? 'Select State/Province' }}</option>
                    @foreach($field->config['states'] as $state)
                        <option 
                            value="{{ $state['value'] ?? $state['label'] }}"
                            @if(isset(old('field.' . $field->id, $field->default_value)['state']) && 
                                old('field.' . $field->id, $field->default_value)['state'] == ($state['value'] ?? $state['label'])) 
                                selected 
                            @endif
                        >
                            {{ $state['label'] }}
                        </option>
                    @endforeach
                </select>
            @else
                <input 
                    type="text"
                    id="field-{{ $field->id }}-state"
                    name="field[{{ $field->id }}][state]"
                    class="form-control {{ $field->input_class }}"
                    placeholder="{{ $field->config['placeholders']['state'] ?? 'State/Province' }}"
                    @if(isset(old('field.' . $field->id, $field->default_value)['state']))
                        value="{{ old('field.' . $field->id, $field->default_value)['state'] }}"
                    @endif
                    @if($disabled) disabled @endif
                    @if($field->required) required @endif
                    data-field-name="{{ $field->name }}-state"
                    data-field-id="{{ $field->id }}"
                >
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-2 mb-md-0">
            <label for="field-{{ $field->id }}-zip">{{ $field->config['labels']['zip'] ?? 'Postal/Zip Code' }}</label>
            <input 
                type="text"
                id="field-{{ $field->id }}-zip"
                name="field[{{ $field->id }}][zip]"
                class="form-control {{ $field->input_class }}"
                placeholder="{{ $field->config['placeholders']['zip'] ?? 'Postal/Zip Code' }}"
                @if(isset(old('field.' . $field->id, $field->default_value)['zip']))
                    value="{{ old('field.' . $field->id, $field->default_value)['zip'] }}"
                @endif
                @if($disabled) disabled @endif
                @if($field->required) required @endif
                data-field-name="{{ $field->name }}-zip"
                data-field-id="{{ $field->id }}"
            >
        </div>
        <div class="col-md-6">
            <label for="field-{{ $field->id }}-country">{{ $field->config['labels']['country'] ?? 'Country' }}</label>
            @if(isset($field->config['countries']) && is_array($field->config['countries']) && count($field->config['countries']) > 0)
                <select
                    id="field-{{ $field->id }}-country"
                    name="field[{{ $field->id }}][country]"
                    class="form-control {{ $field->input_class }}"
                    @if($disabled) disabled @endif
                    @if($field->required) required @endif
                    data-field-name="{{ $field->name }}-country"
                    data-field-id="{{ $field->id }}"
                    @if(isset($field->config['country_dependent']) && $field->config['country_dependent']) 
                        onchange="updateStateOptions('{{ $field->id }}')" 
                    @endif
                >
                    <option value="">{{ $field->config['placeholders']['country'] ?? 'Select Country' }}</option>
                    @foreach($field->config['countries'] as $country)
                        <option 
                            value="{{ $country['value'] ?? $country['label'] }}"
                            @if(isset(old('field.' . $field->id, $field->default_value)['country']) && 
                                old('field.' . $field->id, $field->default_value)['country'] == ($country['value'] ?? $country['label'])) 
                                selected 
                            @endif
                        >
                            {{ $country['label'] }}
                        </option>
                    @endforeach
                </select>
            @else
                <input 
                    type="text"
                    id="field-{{ $field->id }}-country"
                    name="field[{{ $field->id }}][country]"
                    class="form-control {{ $field->input_class }}"
                    placeholder="{{ $field->config['placeholders']['country'] ?? 'Country' }}"
                    @if(isset(old('field.' . $field->id, $field->default_value)['country']))
                        value="{{ old('field.' . $field->id, $field->default_value)['country'] }}"
                    @endif
                    @if($disabled) disabled @endif
                    @if($field->required) required @endif
                    data-field-name="{{ $field->name }}-country"
                    data-field-id="{{ $field->id }}"
                >
            @endif
        </div>
    </div>
    
    @if(isset($field->config['country_dependent']) && $field->config['country_dependent'])
    <script>
    function updateStateOptions(fieldId) {
        const countrySelect = document.getElementById(`field-${fieldId}-country`);
        const stateSelect = document.getElementById(`field-${fieldId}-state`);
        const countryStates = @json($field->config['country_states'] ?? []);
        
        if (!stateSelect || !countrySelect || !countryStates) return;
        
        const countryValue = countrySelect.value;
        const states = countryStates[countryValue] || [];
        
        // Clear all options except the first one (placeholder)
        while (stateSelect.options.length > 1) {
            stateSelect.remove(1);
        }
        
        // Add new options based on selected country
        states.forEach(state => {
            const option = document.createElement('option');
            option.value = state.value || state.label;
            option.textContent = state.label;
            stateSelect.appendChild(option);
        });
    }
    
    // Initialize states on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateStateOptions('{{ $field->id }}');
    });
    </script>
    @endif
    
    @if($field->help_text)
        <small class="form-text text-muted mt-2">{{ $field->help_text }}</small>
    @endif
</div> 