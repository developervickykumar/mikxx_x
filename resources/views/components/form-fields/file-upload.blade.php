@props(['field', 'disabled' => false])

<div class="file-upload-container">
    <input 
        type="file"
        id="field-{{ $field->id }}"
        name="field[{{ $field->id }}]{{ isset($field->config['multiple']) && $field->config['multiple'] ? '[]' : '' }}"
        class="form-control {{ $field->input_class }}"
        @if(isset($field->config['multiple']) && $field->config['multiple']) multiple @endif
        @if(isset($field->config['accept'])) accept="{{ $field->config['accept'] }}" @endif
        @if($disabled) disabled @endif
        @if($field->required) required @endif
        {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
        data-field-name="{{ $field->name }}"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    
    @if($field->help_text)
        <small class="form-text text-muted mt-1">{{ $field->help_text }}</small>
    @endif
    
    @if(isset($field->config['max_size']))
        <small class="form-text text-muted">Maximum file size: {{ $field->config['max_size'] }}MB</small>
    @endif
    
    @if(isset($field->config['accepted_files']))
        <small class="form-text text-muted">Accepted file types: {{ $field->config['accepted_files'] }}</small>
    @endif
    
    @if(isset($field->default_value) && $field->default_value)
        <div class="mt-2">
            <p>Current file: <a href="{{ $field->default_value }}" target="_blank">View</a></p>
        </div>
    @endif
</div> 