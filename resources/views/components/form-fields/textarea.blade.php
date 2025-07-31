@props(['field', 'disabled' => false])

<textarea 
    id="field-{{ $field->id }}"
    name="field[{{ $field->id }}]"
    class="form-control {{ $field->input_class }}"
    placeholder="{{ $field->placeholder }}"
    @if($disabled) disabled @endif
    @if($field->required) required @endif
    @if(isset($field->config['rows'])) rows="{{ $field->config['rows'] }}" @else rows="4" @endif
    @if(isset($field->config['cols'])) cols="{{ $field->config['cols'] }}" @endif
    {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
    data-field-name="{{ $field->name }}"
    data-field-id="{{ $field->id }}"
    @if($field->conditions->count() > 0) data-has-conditions="true" @endif
>{{ old('field.' . $field->id, $field->default_value) }}</textarea> 