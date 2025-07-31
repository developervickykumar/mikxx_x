<div class="row">
    @foreach($fields as $index => $field)
        @if($index % 4 == 0 && $index > 0)
            </div><div class="row">
        @endif

        <div class="col-md-3">
            <div class="form-group">
                <label for="field-{{ $field->id }}">{{ $field->label }}</label>

                @if($field->type === 'select')
                    <select name="field[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control">
                        @foreach($field->options as $option)
                            <option value="{{ $option['name'] }}">{{ $option['name'] }}</option>
                        @endforeach
                    </select>

                @elseif($field->type === 'radio')
                    @foreach($field->options as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="field[{{ $field->id }}]"
                                   id="field-{{ $field->id }}-{{ $loop->index }}" value="{{ $option['name'] }}">
                            <label class="form-check-label"
                                   for="field-{{ $field->id }}-{{ $loop->index }}">{{ $option['name'] }}</label>
                        </div>
                    @endforeach

                @elseif($field->type === 'text')
                    <input type="text" name="field[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control"
                           placeholder="Enter {{ $field->label }}">

                @elseif($field->type === 'number')
                    <input type="number" name="field[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control"
                           placeholder="Enter {{ $field->label }}">
                @endif
            </div>
        </div>
    @endforeach
</div>
