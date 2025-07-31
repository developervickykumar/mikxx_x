<select class="form-select" name="{{ $fieldName }}[]" multiple>
    @foreach($field->children as $option)
        <option value="{{ $option->name }}" {{ in_array($option->name, $selectedValues) ? "selected" : "" }}>{{ $option->name }}</option>
    @endforeach
</select>