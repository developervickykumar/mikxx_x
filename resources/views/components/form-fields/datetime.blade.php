@props(['field', 'disabled' => false])

<input 
    type="datetime-local"
    id="field-{{ $field->id }}"
    name="field[{{ $field->id }}]"
    class="form-control {{ $field->input_class }}"
    value="{{ old('field.' . $field->id, $field->default_value) }}"
    @if($disabled) disabled @endif
    @if($field->required) required @endif
    @if(isset($field->config['min'])) min="{{ $field->config['min'] }}" @endif
    @if(isset($field->config['max'])) max="{{ $field->config['max'] }}" @endif
    {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
    data-field-name="{{ $field->name }}"
    data-field-id="{{ $field->id }}"
    @if($field->conditions->count() > 0) data-has-conditions="true" @endif
> 