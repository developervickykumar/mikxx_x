@props(['field', 'disabled' => false])

<input 
    type="hidden"
    id="field-{{ $field->id }}"
    name="field[{{ $field->id }}]"
    value="{{ old('field.' . $field->id, $field->default_value) }}"
    data-field-name="{{ $field->name }}"
    data-field-id="{{ $field->id }}"
> 