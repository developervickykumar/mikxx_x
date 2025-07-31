@foreach($field->children as $option)
    <div class="form-check">
        <input type="radio" class="form-check-input" name="{{ $fieldName }}" value="{{ $option->name }}" id="{{ $fieldName }}_{{ $loop->index }}">
        <label class="form-check-label" for="{{ $fieldName }}_{{ $loop->index }}">{{ $option->name }}</label>
    </div>
@endforeach