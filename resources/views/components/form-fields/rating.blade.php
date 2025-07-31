@props(['field', 'disabled' => false])

<div class="rating-container">
    <div class="star-rating">
        @php
            $max_rating = isset($field->config['max_rating']) ? $field->config['max_rating'] : 5;
            $current_value = old('field.' . $field->id, $field->default_value ?? 0);
        @endphp
        
        <input type="hidden" 
            id="field-{{ $field->id }}" 
            name="field[{{ $field->id }}]" 
            value="{{ $current_value }}"
            data-field-name="{{ $field->name }}"
            data-field-id="{{ $field->id }}"
            @if($field->conditions->count() > 0) data-has-conditions="true" @endif
        >
        
        @for($i = $max_rating; $i >= 1; $i--)
            <input type="radio" 
                id="star{{ $i }}-{{ $field->id }}" 
                name="rating-{{ $field->id }}" 
                value="{{ $i }}" 
                {{ $current_value == $i ? 'checked' : '' }}
                @if($disabled) disabled @endif
                onclick="updateRatingValue('{{ $field->id }}', {{ $i }})"
            >
            <label for="star{{ $i }}-{{ $field->id }}" title="{{ $i }} stars">
                <i class="fas fa-star"></i>
            </label>
        @endfor
    </div>
</div>

<script>
function updateRatingValue(fieldId, value) {
    document.getElementById(`field-${fieldId}`).value = value;
}
</script>

<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.star-rating input {
    display: none;
}

.star-rating label {
    color: #ddd;
    font-size: 24px;
    padding: 0 2px;
    cursor: pointer;
}

.star-rating input:checked ~ label,
.star-rating:not(:checked) label:hover,
.star-rating:not(:checked) label:hover ~ label {
    color: #ffc107;
}

.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffdb70;
}
</style> 