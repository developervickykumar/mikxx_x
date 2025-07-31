@props(['field', 'disabled' => false])

<div class="text-editor-container">
    <textarea 
        id="field-{{ $field->id }}"
        name="field[{{ $field->id }}]"
        class="form-control {{ $field->input_class }}"
        @if($disabled) disabled @endif
        @if($field->required) required @endif
        data-field-name="{{ $field->name }}"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
        rows="{{ $field->config['rows'] ?? 10 }}"
    >{{ old('field.' . $field->id, $field->default_value) }}</textarea>
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    tinymce.init({
        selector: '#field-{{ $field->id }}',
        height: {{ $field->config['height'] ?? 400 }},
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
        @if($disabled)
        readonly: true,
        @endif
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
});
</script> 