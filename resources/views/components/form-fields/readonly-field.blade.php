@props(['field', 'disabled' => false])

<input 
    type="text"
    id="field-{{ $field->id }}"
    name="field[{{ $field->id }}]"
    class="form-control readonly {{ $field->input_class }}"
    value="{{ old('field.' . $field->id, $field->default_value) }}"
    readonly
    data-field-name="{{ $field->name }}"
    data-field-id="{{ $field->id }}"
    @if($field->conditions->count() > 0) data-has-conditions="true" @endif
>

<style>
.readonly {
    background-color: #f8f9fa;
    cursor: not-allowed;
}
</style> 