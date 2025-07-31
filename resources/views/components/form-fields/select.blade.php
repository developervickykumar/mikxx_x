@props(['field', 'disabled' => false])

<select
    id="field-{{ $field->id }}"
    name="field[{{ $field->id }}]"
    class="form-control {{ $field->input_class }}"
    @if($disabled) disabled @endif
    @if($field->required) required @endif
    {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
    data-field-name="{{ $field->name }}"
    data-field-id="{{ $field->id }}"
    @if($field->conditions->count() > 0) data-has-conditions="true" @endif
>
    @if($field->placeholder)
        <option value="">{{ $field->placeholder }}</option>
    @endif
    
    @if($field->options)
        @foreach($field->options as $option)
            <option 
                value="{{ $option['value'] ?? $option['label'] }}"
                @if(old('field.' . $field->id, $field->default_value) == ($option['value'] ?? $option['label'])) selected @endif
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    @endif
</select> 