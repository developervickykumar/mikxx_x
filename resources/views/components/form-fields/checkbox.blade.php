@props(['field', 'disabled' => false])

<div class="form-check">
    <input 
        type="checkbox"
        id="field-{{ $field->id }}"
        name="field[{{ $field->id }}]"
        class="form-check-input {{ $field->input_class }}"
        value="1"
        @if(old('field.' . $field->id, $field->default_value)) checked @endif
        @if($disabled) disabled @endif
        @if($field->required) required @endif
        {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
        data-field-name="{{ $field->name }}"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    <label class="form-check-label" for="field-{{ $field->id }}">
        {{ $field->label }}
        @if($field->required)<span class="text-danger">*</span>@endif
    </label>
</div>

@if($field->description)
    <div class="form-text text-muted">{{ $field->description }}</div>
@endif 