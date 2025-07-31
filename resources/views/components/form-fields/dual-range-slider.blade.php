@props(['field', 'disabled' => false])

<div class="dual-range-slider-container">
    @php
        $min = $field->config['min'] ?? 0;
        $max = $field->config['max'] ?? 100;
        $step = $field->config['step'] ?? 1;
        
        $min_value = old('field.' . $field->id . '.min', $field->default_value['min'] ?? $min);
        $max_value = old('field.' . $field->id . '.max', $field->default_value['max'] ?? $max);
        
        $prefix = $field->config['prefix'] ?? '';
        $suffix = $field->config['suffix'] ?? '';
    @endphp
    
    <div class="range-slider-controls">
        <div class="range-slider-values mb-2 d-flex justify-content-between">
            <span>
                <span id="display-min-{{ $field->id }}">{{ $prefix . $min_value . $suffix }}</span>
            </span>
            <span>
                <span id="display-max-{{ $field->id }}">{{ $prefix . $max_value . $suffix }}</span>
            </span>
        </div>
        
        <div class="dual-slider position-relative" id="slider-container-{{ $field->id }}">
            <div class="slider-track" id="slider-track-{{ $field->id }}"></div>
            <input 
                type="range"
                id="min-range-{{ $field->id }}"
                class="range-slider-input min-range"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
                value="{{ $min_value }}"
                @if($disabled) disabled @endif
                oninput="updateDualSlider('{{ $field->id }}')"
            >
            <input 
                type="range"
                id="max-range-{{ $field->id }}"
                class="range-slider-input max-range"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
                value="{{ $max_value }}"
                @if($disabled) disabled @endif
                oninput="updateDualSlider('{{ $field->id }}')"
            >
        </div>
        
        @if(isset($field->config['show_min_max']) && $field->config['show_min_max'])
        <div class="range-slider-min-max d-flex justify-content-between mt-1">
            <small>{{ $prefix . $min . $suffix }}</small>
            <small>{{ $prefix . $max . $suffix }}</small>
        </div>
        @endif
    </div>
    
    <!-- Hidden inputs to store the actual values -->
    <input 
        type="hidden"
        id="field-{{ $field->id }}-min"
        name="field[{{ $field->id }}][min]"
        value="{{ $min_value }}"
        @if($field->required) required @endif
        data-field-name="{{ $field->name }}-min"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    <input 
        type="hidden"
        id="field-{{ $field->id }}-max"
        name="field[{{ $field->id }}][max]"
        value="{{ $max_value }}"
        @if($field->required) required @endif
        data-field-name="{{ $field->name }}-max"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    
    @if($field->help_text)
        <small class="form-text text-muted mt-2">{{ $field->help_text }}</small>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initDualSlider('{{ $field->id }}');
});

function initDualSlider(fieldId) {
    const minRange = document.getElementById(`min-range-${fieldId}`);
    const maxRange = document.getElementById(`max-range-${fieldId}`);
    const track = document.getElementById(`slider-track-${fieldId}`);
    
    // Set initial track positions
    updateSliderTrack(fieldId);
    
    // Ensure min doesn't exceed max and max doesn't go below min
    minRange.addEventListener('input', function() {
        if (parseInt(minRange.value) > parseInt(maxRange.value)) {
            minRange.value = maxRange.value;
        }
    });
    
    maxRange.addEventListener('input', function() {
        if (parseInt(maxRange.value) < parseInt(minRange.value)) {
            maxRange.value = minRange.value;
        }
    });
}

function updateDualSlider(fieldId) {
    const minRange = document.getElementById(`min-range-${fieldId}`);
    const maxRange = document.getElementById(`max-range-${fieldId}`);
    const minDisplay = document.getElementById(`display-min-${fieldId}`);
    const maxDisplay = document.getElementById(`display-max-${fieldId}`);
    const hiddenMinInput = document.getElementById(`field-${fieldId}-min`);
    const hiddenMaxInput = document.getElementById(`field-${fieldId}-max`);
    
    const prefix = '{{ $field->config['prefix'] ?? '' }}';
    const suffix = '{{ $field->config['suffix'] ?? '' }}';
    
    // Update displays
    minDisplay.textContent = prefix + minRange.value + suffix;
    maxDisplay.textContent = prefix + maxRange.value + suffix;
    
    // Update hidden inputs
    hiddenMinInput.value = minRange.value;
    hiddenMaxInput.value = maxRange.value;
    
    // Update track position
    updateSliderTrack(fieldId);
}

function updateSliderTrack(fieldId) {
    const minRange = document.getElementById(`min-range-${fieldId}`);
    const maxRange = document.getElementById(`max-range-${fieldId}`);
    const track = document.getElementById(`slider-track-${fieldId}`);
    
    if (!track) return;
    
    const min = parseInt(minRange.min);
    const max = parseInt(minRange.max);
    const minVal = parseInt(minRange.value);
    const maxVal = parseInt(maxRange.value);
    
    // Calculate percentage positions for the colored track
    const minPercent = ((minVal - min) / (max - min)) * 100;
    const maxPercent = ((maxVal - min) / (max - min)) * 100;
    
    track.style.left = minPercent + '%';
    track.style.width = (maxPercent - minPercent) + '%';
}
</script>

<style>
.dual-range-slider-container {
    padding: 10px 0;
    margin-bottom: 1rem;
}

.dual-slider {
    height: 5px;
    margin: 20px 0;
}

.slider-track {
    position: absolute;
    top: 0;
    bottom: 0;
    background: #0d6efd;
    border-radius: 3px;
    pointer-events: none;
}

.range-slider-input {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 5px;
    background: #ddd;
    position: absolute;
    margin: 0;
    border-radius: 3px;
}

.range-slider-input::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d6efd;
    cursor: pointer;
    z-index: 10;
    position: relative;
}

.range-slider-input::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d6efd;
    cursor: pointer;
    z-index: 10;
    position: relative;
}

/* Ensure thumbs are always visible */
.min-range::-webkit-slider-thumb {
    z-index: 3;
}
.max-range::-webkit-slider-thumb {
    z-index: 4;
}
.min-range::-moz-range-thumb {
    z-index: 3;
}
.max-range::-moz-range-thumb {
    z-index: 4;
}

/* Make the ranges transparent but keep the thumbs visible */
.range-slider-input {
    background: transparent;
}
</style> 