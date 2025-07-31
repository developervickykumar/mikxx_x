@props(['field', 'disabled' => false])

<input 
    type="tel"
    id="field-{{ $field->id }}"
    name="field[{{ $field->id }}]"
    class="form-control {{ $field->input_class }}"
    placeholder="{{ $field->placeholder ?? '+1 (___) ___-____' }}"
    value="{{ old('field.' . $field->id, $field->default_value) }}"
    @if($disabled) disabled @endif
    @if($field->required) required @endif
    pattern="{{ isset($field->config['pattern']) ? $field->config['pattern'] : '[0-9+\(\)\- ]{10,15}' }}"
    {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
    data-field-name="{{ $field->name }}"
    data-field-id="{{ $field->id }}"
    @if($field->conditions->count() > 0) data-has-conditions="true" @endif
> 