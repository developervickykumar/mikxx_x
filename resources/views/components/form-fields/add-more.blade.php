@props(['field', 'disabled' => false])

<div class="add-more-container">
    <div class="add-more-items" id="add-more-{{ $field->id }}">
        @php
            $values = old('field.' . $field->id, $field->default_value);
            $values = is_array($values) ? $values : [];
            $template = $field->config['template'] ?? 'text';
            $min_entries = $field->config['min_entries'] ?? 1;
            $max_entries = $field->config['max_entries'] ?? null;
            $button_text = $field->config['button_text'] ?? 'Add Item';
            
            // Ensure we have at least the minimum number of entries
            if (count($values) < $min_entries) {
                $values = array_pad($values, $min_entries, '');
            }
        @endphp
        
        @foreach($values as $index => $value)
            <div class="add-more-item mb-2" data-index="{{ $index }}">
                <div class="input-group">
                    @if($template === 'text')
                        <input 
                            type="text"
                            name="field[{{ $field->id }}][]"
                            class="form-control"
                            value="{{ $value }}"
                            @if($disabled) disabled @endif
                            @if($field->required && $index == 0) required @endif
                            placeholder="{{ $field->placeholder ?? '' }}"
                        >
                    @elseif($template === 'textarea')
                        <textarea 
                            name="field[{{ $field->id }}][]"
                            class="form-control"
                            @if($disabled) disabled @endif
                            @if($field->required && $index == 0) required @endif
                            placeholder="{{ $field->placeholder ?? '' }}"
                            rows="2"
                        >{{ $value }}</textarea>
                    @elseif($template === 'key_value')
                        <input 
                            type="text"
                            name="field[{{ $field->id }}][{{ $index }}][key]"
                            class="form-control"
                            value="{{ is_array($value) ? ($value['key'] ?? '') : '' }}"
                            @if($disabled) disabled @endif
                            @if($field->required && $index == 0) required @endif
                            placeholder="{{ $field->config['key_placeholder'] ?? 'Key' }}"
                        >
                        <input 
                            type="text"
                            name="field[{{ $field->id }}][{{ $index }}][value]"
                            class="form-control"
                            value="{{ is_array($value) ? ($value['value'] ?? '') : '' }}"
                            @if($disabled) disabled @endif
                            @if($field->required && $index == 0) required @endif
                            placeholder="{{ $field->config['value_placeholder'] ?? 'Value' }}"
                        >
                    @endif
                    
                    @if(!$disabled && (!isset($max_entries) || count($values) > $min_entries))
                        <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this, '{{ $field->id }}')">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @if(!$disabled && (!isset($max_entries) || count($values) < $max_entries))
        <button type="button" class="btn btn-secondary mt-2" onclick="addItem('{{ $field->id }}', '{{ $template }}')">
            {{ $button_text }}
        </button>
    @endif
    
    @if(isset($max_entries))
        <small class="form-text text-muted">
            Maximum {{ $max_entries }} {{ Str::plural('item', $max_entries) }}
        </small>
    @endif
</div>

<script>
// Template for new items based on the template type
const templates = {
    text: function(fieldId, index) {
        return `
            <div class="add-more-item mb-2" data-index="${index}">
                <div class="input-group">
                    <input 
                        type="text"
                        name="field[${fieldId}][]"
                        class="form-control"
                        placeholder="{{ $field->placeholder ?? '' }}"
                    >
                    <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this, '${fieldId}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
    },
    textarea: function(fieldId, index) {
        return `
            <div class="add-more-item mb-2" data-index="${index}">
                <div class="input-group">
                    <textarea 
                        name="field[${fieldId}][]"
                        class="form-control"
                        placeholder="{{ $field->placeholder ?? '' }}"
                        rows="2"
                    ></textarea>
                    <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this, '${fieldId}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
    },
    key_value: function(fieldId, index) {
        return `
            <div class="add-more-item mb-2" data-index="${index}">
                <div class="input-group">
                    <input 
                        type="text"
                        name="field[${fieldId}][${index}][key]"
                        class="form-control"
                        placeholder="{{ $field->config['key_placeholder'] ?? 'Key' }}"
                    >
                    <input 
                        type="text"
                        name="field[${fieldId}][${index}][value]"
                        class="form-control"
                        placeholder="{{ $field->config['value_placeholder'] ?? 'Value' }}"
                    >
                    <button type="button" class="btn btn-danger remove-item" onclick="removeItem(this, '${fieldId}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
    }
};

function addItem(fieldId, template) {
    const container = document.getElementById(`add-more-${fieldId}`);
    const items = container.querySelectorAll('.add-more-item');
    const max_entries = {{ $max_entries ?? 'null' }};
    
    // Check if we've reached the maximum number of entries
    if (max_entries !== null && items.length >= max_entries) {
        return;
    }
    
    const index = items.length;
    const templateFn = templates[template] || templates.text;
    
    // Add new item using the specified template
    container.insertAdjacentHTML('beforeend', templateFn(fieldId, index));
    
    // If we've reached the maximum, hide the add button
    if (max_entries !== null && items.length + 1 >= max_entries) {
        const addButton = container.nextElementSibling;
        if (addButton) {
            addButton.style.display = 'none';
        }
    }
}

function removeItem(button, fieldId) {
    const item = button.closest('.add-more-item');
    const container = document.getElementById(`add-more-${fieldId}`);
    const items = container.querySelectorAll('.add-more-item');
    const min_entries = {{ $min_entries ?? 1 }};
    const max_entries = {{ $max_entries ?? 'null' }};
    
    // Check if we have more than the minimum number of entries
    if (items.length > min_entries) {
        item.remove();
        
        // If we're below the maximum again, show the add button
        if (max_entries !== null && items.length <= max_entries) {
            const addButton = container.nextElementSibling;
            if (addButton) {
                addButton.style.display = 'inline-block';
            }
        }
        
        // Reindex all items for key_value templates
        if ('{{ $template }}' === 'key_value') {
            const remainingItems = container.querySelectorAll('.add-more-item');
            remainingItems.forEach((item, index) => {
                const keyInput = item.querySelector('input[name*="[key]"]');
                const valueInput = item.querySelector('input[name*="[value]"]');
                
                if (keyInput) {
                    keyInput.name = `field[${fieldId}][${index}][key]`;
                }
                
                if (valueInput) {
                    valueInput.name = `field[${fieldId}][${index}][value]`;
                }
                
                item.dataset.index = index;
            });
        }
    }
}
</script> 