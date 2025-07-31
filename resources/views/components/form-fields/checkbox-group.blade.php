@props(['field', 'disabled' => false])

<div class="checkbox-group">
    @if($field->options)
        @foreach($field->options as $option)
            <div class="form-check {{ isset($field->config['inline']) && $field->config['inline'] ? 'form-check-inline' : '' }}">
                <input 
                    type="checkbox"
                    id="field-{{ $field->id }}-{{ $loop->index }}"
                    name="field[{{ $field->id }}][]"
                    class="form-check-input {{ $field->input_class }}"
                    value="{{ $option['value'] ?? $option['label'] }}"
                    @php
                        $oldValues = old('field.' . $field->id, $field->default_value);
                        $isChecked = false;
                        
                        if (is_array($oldValues)) {
                            $isChecked = in_array($option['value'] ?? $option['label'], $oldValues);
                        } else {
                            $isChecked = $oldValues == ($option['value'] ?? $option['label']);
                        }
                    @endphp
                    @if($isChecked) checked @endif
                    @if($disabled) disabled @endif
                    {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
                    data-field-name="{{ $field->name }}"
                    data-field-id="{{ $field->id }}"
                    @if($field->conditions->count() > 0) data-has-conditions="true" @endif
                >
                <label class="form-check-label" for="field-{{ $field->id }}-{{ $loop->index }}">
                    {{ $option['label'] }}
                </label>
            </div>
        @endforeach
    @endif
</div> 