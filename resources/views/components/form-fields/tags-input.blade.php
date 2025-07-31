@props(['field', 'disabled' => false])

<div class="tags-input-container">
    <div class="tags-input-wrapper" id="tags-wrapper-{{ $field->id }}">
        <div class="tags-container d-flex flex-wrap" id="tags-container-{{ $field->id }}">
            @php
                $tags = [];
                $default_tags = old('field.' . $field->id, $field->default_value);
                
                if (is_string($default_tags)) {
                    $delimiter = $field->config['delimiter'] ?? ',';
                    $tags = array_filter(explode($delimiter, $default_tags));
                } elseif (is_array($default_tags)) {
                    $tags = $default_tags;
                }
            @endphp
            
            @foreach($tags as $tag)
                <div class="tag-item d-inline-flex align-items-center me-2 mb-2 px-2 py-1 bg-light rounded">
                    <span>{{ $tag }}</span>
                    @if(!$disabled)
                    <button type="button" class="btn-close btn-close-sm ms-2" onclick="removeTag('{{ $field->id }}', '{{ $tag }}')"></button>
                    @endif
                </div>
            @endforeach
        </div>
        
        @if(!$disabled)
        <div class="input-container position-relative">
            <input 
                type="text"
                id="tag-input-{{ $field->id }}"
                class="form-control mt-2 {{ $field->input_class }}"
                placeholder="{{ $field->placeholder ?? 'Add tag...' }}"
                @if($disabled) disabled @endif
                autocomplete="off"
                @if(isset($field->config['max_tags']) && count($tags) >= $field->config['max_tags']) disabled @endif
            >
            
            @if(isset($field->config['suggestions']) && count($field->config['suggestions']) > 0)
            <div class="suggestions-container position-absolute w-100 d-none" id="suggestions-{{ $field->id }}">
                <ul class="list-group">
                    @foreach($field->config['suggestions'] as $suggestion)
                        <li class="list-group-item suggestion-item" 
                            onclick="addTagFromSuggestion('{{ $field->id }}', '{{ is_array($suggestion) ? ($suggestion['value'] ?? $suggestion['label']) : $suggestion }}')">
                            {{ is_array($suggestion) ? $suggestion['label'] : $suggestion }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        @endif
        
        <input 
            type="hidden"
            id="field-{{ $field->id }}"
            name="field[{{ $field->id }}]"
            value="{{ is_array($default_tags) ? implode($field->config['delimiter'] ?? ',', $default_tags) : $default_tags }}"
            @if($field->required) required @endif
            data-field-name="{{ $field->name }}"
            data-field-id="{{ $field->id }}"
            @if($field->conditions->count() > 0) data-has-conditions="true" @endif
        >
    </div>
    
    @if($field->help_text)
        <small class="form-text text-muted mt-1">{{ $field->help_text }}</small>
    @endif
    
    @if(isset($field->config['max_tags']))
        <small class="form-text text-muted">
            Maximum {{ $field->config['max_tags'] }} {{ Str::plural('tag', $field->config['max_tags']) }}
        </small>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initTagsInput('{{ $field->id }}');
});

function initTagsInput(fieldId) {
    const inputField = document.getElementById(`tag-input-${fieldId}`);
    const suggestionsContainer = document.getElementById(`suggestions-${fieldId}`);
    const hiddenInput = document.getElementById(`field-${fieldId}`);
    
    if (!inputField) return;
    
    // Handle input events
    inputField.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag(fieldId, this.value.trim());
        } else if (e.key === 'Backspace' && this.value === '') {
            // Remove the last tag when pressing backspace on empty input
            const tagsContainer = document.getElementById(`tags-container-${fieldId}`);
            const tags = tagsContainer.querySelectorAll('.tag-item');
            
            if (tags.length > 0) {
                const lastTag = tags[tags.length - 1];
                const tagText = lastTag.querySelector('span').textContent;
                removeTag(fieldId, tagText);
            }
        }
    });
    
    // Show suggestions on focus
    inputField.addEventListener('focus', function() {
        if (suggestionsContainer) {
            filterSuggestions(fieldId, this.value);
            suggestionsContainer.classList.remove('d-none');
        }
    });
    
    // Hide suggestions on blur (delayed to allow clicking on suggestions)
    inputField.addEventListener('blur', function() {
        if (suggestionsContainer) {
            setTimeout(() => {
                suggestionsContainer.classList.add('d-none');
            }, 200);
        }
    });
    
    // Filter suggestions on input
    inputField.addEventListener('input', function() {
        if (suggestionsContainer) {
            filterSuggestions(fieldId, this.value);
        }
    });
}

function addTag(fieldId, tagText) {
    if (!tagText) return;
    
    const tagsContainer = document.getElementById(`tags-container-${fieldId}`);
    const inputField = document.getElementById(`tag-input-${fieldId}`);
    const hiddenInput = document.getElementById(`field-${fieldId}`);
    
    // Get current tags
    const currentTags = getCurrentTags(fieldId);
    
    // Check if tag already exists
    if (currentTags.includes(tagText)) {
        inputField.value = '';
        return;
    }
    
    // Check max tags limit
    const maxTags = {{ $field->config['max_tags'] ?? 'null' }};
    if (maxTags !== null && currentTags.length >= maxTags) {
        inputField.value = '';
        return;
    }
    
    // Create new tag element
    const tagElement = document.createElement('div');
    tagElement.className = 'tag-item d-inline-flex align-items-center me-2 mb-2 px-2 py-1 bg-light rounded';
    tagElement.innerHTML = `
        <span>${tagText}</span>
        <button type="button" class="btn-close btn-close-sm ms-2" onclick="removeTag('${fieldId}', '${tagText}')"></button>
    `;
    
    // Add tag to container
    tagsContainer.appendChild(tagElement);
    
    // Update hidden input
    currentTags.push(tagText);
    updateHiddenInput(fieldId, currentTags);
    
    // Clear input field
    inputField.value = '';
    
    // Disable input if max tags reached
    if (maxTags !== null && currentTags.length >= maxTags) {
        inputField.disabled = true;
    }
}

function addTagFromSuggestion(fieldId, tagText) {
    addTag(fieldId, tagText);
    document.getElementById(`tag-input-${fieldId}`).focus();
}

function removeTag(fieldId, tagText) {
    const tagsContainer = document.getElementById(`tags-container-${fieldId}`);
    const inputField = document.getElementById(`tag-input-${fieldId}`);
    
    // Remove tag element
    const tagElements = tagsContainer.querySelectorAll('.tag-item');
    tagElements.forEach(el => {
        if (el.querySelector('span').textContent === tagText) {
            el.remove();
        }
    });
    
    // Update hidden input
    const currentTags = getCurrentTags(fieldId);
    const updatedTags = currentTags.filter(tag => tag !== tagText);
    updateHiddenInput(fieldId, updatedTags);
    
    // Enable input if it was disabled due to max tags
    const maxTags = {{ $field->config['max_tags'] ?? 'null' }};
    if (maxTags !== null && updatedTags.length < maxTags) {
        inputField.disabled = false;
    }
}

function getCurrentTags(fieldId) {
    const tagsContainer = document.getElementById(`tags-container-${fieldId}`);
    const tagElements = tagsContainer.querySelectorAll('.tag-item');
    const tags = [];
    
    tagElements.forEach(el => {
        tags.push(el.querySelector('span').textContent);
    });
    
    return tags;
}

function updateHiddenInput(fieldId, tags) {
    const hiddenInput = document.getElementById(`field-${fieldId}`);
    const delimiter = '{{ $field->config['delimiter'] ?? ',' }}';
    hiddenInput.value = tags.join(delimiter);
}

function filterSuggestions(fieldId, query) {
    const suggestionsContainer = document.getElementById(`suggestions-${fieldId}`);
    if (!suggestionsContainer) return;
    
    const suggestionItems = suggestionsContainer.querySelectorAll('.suggestion-item');
    const currentTags = getCurrentTags(fieldId);
    let hasVisibleSuggestions = false;
    
    suggestionItems.forEach(item => {
        const text = item.textContent.trim().toLowerCase();
        const isMatch = text.includes(query.toLowerCase());
        const isAlreadySelected = currentTags.includes(text);
        
        if (isMatch && !isAlreadySelected) {
            item.style.display = 'block';
            hasVisibleSuggestions = true;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show/hide suggestions container based on matches
    if (hasVisibleSuggestions) {
        suggestionsContainer.classList.remove('d-none');
    } else {
        suggestionsContainer.classList.add('d-none');
    }
}
</script>

<style>
.tags-input-container {
    margin-bottom: 1rem;
}

.tag-item {
    background-color: #e9ecef;
    border-radius: 3px;
}

.btn-close-sm {
    font-size: 0.7rem;
    padding: 0.25rem;
}

.suggestions-container {
    z-index: 1000;
    max-height: 200px;
    overflow-y: auto;
    background: white;
    border: 1px solid #ced4da;
    border-radius: 0 0 4px 4px;
}

.suggestion-item {
    cursor: pointer;
    padding: 0.5rem 1rem;
}

.suggestion-item:hover {
    background-color: #f8f9fa;
}
</style> 