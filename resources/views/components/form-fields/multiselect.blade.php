@props(['field', 'disabled' => false])

<select
    id="field-{{ $field->id }}"
    name="field[{{ $field->id }}][]"
    class="form-control {{ $field->input_class }}"
    multiple
    @if($disabled) disabled @endif
    @if($field->required) required @endif
    @if(isset($field->config['size'])) size="{{ $field->config['size'] }}" @endif
    {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
    data-field-name="{{ $field->name }}"
    data-field-id="{{ $field->id }}"
    @if($field->conditions->count() > 0) data-has-conditions="true" @endif
>
    @if($field->options)
        @foreach($field->options as $option)
            @php
                $oldValues = old('field.' . $field->id, $field->default_value);
                $isSelected = false;
                
                if (is_array($oldValues)) {
                    $isSelected = in_array($option['value'] ?? $option['label'], $oldValues);
                } else {
                    $isSelected = $oldValues == ($option['value'] ?? $option['label']);
                }
            @endphp
            <option 
                value="{{ $option['value'] ?? $option['label'] }}"
                @if($isSelected) selected @endif
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    @endif
</select>

@if(isset($field->config['select2']) && $field->config['select2'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#field-{{ $field->id }}').select2({
        placeholder: "{{ $field->placeholder }}",
        allowClear: true,
        theme: "bootstrap4"
    });
});
</script>
@endif 