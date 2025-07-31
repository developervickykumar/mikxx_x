@props(['field', 'disabled' => false])

<div class="image-upload-container">
    <div class="form-group">
        <input 
            type="file"
            id="field-{{ $field->id }}"
            name="field[{{ $field->id }}]"
            class="form-control {{ $field->input_class }}"
            accept="image/*"
            @if($disabled) disabled @endif
            @if($field->required) required @endif
            {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
            data-field-name="{{ $field->name }}"
            data-field-id="{{ $field->id }}"
            @if($field->conditions->count() > 0) data-has-conditions="true" @endif
            onchange="previewImage(event, 'preview-{{ $field->id }}')"
        >
        
        @if($field->help_text)
            <small class="form-text text-muted mt-1">{{ $field->help_text }}</small>
        @endif
        
        @if(isset($field->config['max_size']))
            <small class="form-text text-muted">Maximum file size: {{ $field->config['max_size'] }}MB</small>
        @endif
    </div>
    
    <div class="mt-2 image-preview-container">
        @if(isset($field->default_value) && $field->default_value)
            <img src="{{ $field->default_value }}" alt="Current image" class="img-thumbnail mb-2" style="max-height: 200px;">
        @endif
        <div id="preview-{{ $field->id }}" class="mt-2"></div>
    </div>
</div>

<script>
function previewImage(event, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Image preview';
            img.className = 'img-thumbnail';
            img.style.maxHeight = '200px';
            preview.appendChild(img);
        }
        
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script> 