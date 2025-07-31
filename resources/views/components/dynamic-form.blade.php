@props(['form'])

<form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data" id="dynamic-form-{{ $form->id }}">
    @csrf
    
    @php
        $fieldsBySection = $form->getFieldsBySection();
    @endphp

    <div class="dynamic-form-container">
        @if(!empty($fieldsBySection['default']) && count($fieldsBySection['default']) > 0)
            <div class="form-section">
                <div class="row">
                    @foreach($fieldsBySection['default'] as $field)
                        @if($field->is_visible)
                            <div class="col-md-{{ $field->width ?? 12 }}">
                                <div class="form-group mb-3 {{ $field->wrapper_class }}">
                                    @if($field->label && !in_array($field->component_name, ['hidden-field', 'divider', 'heading']))
                                        <label for="field-{{ $field->id }}">
                                            {{ $field->label }}
                                            @if($field->required)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                    @endif

                                    @if($field->description)
                                        <p class="form-text text-muted">{{ $field->description }}</p>
                                    @endif

                                    @include("components.form-fields.{$field->component_name}", [
                                        'field' => $field,
                                        'disabled' => !$field->is_enabled
                                    ])

                                    @if($field->help_text)
                                        <div class="form-text text-muted mt-1">{{ $field->help_text }}</div>
                                    @endif

                                    @error("field.{$field->id}")
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @foreach($fieldsBySection as $sectionName => $sectionFields)
            @if($sectionName !== 'default' && count($sectionFields) > 0)
                <div class="form-section mb-4">
                    <h3 class="section-title mb-3">{{ $sectionName }}</h3>
                    <div class="row">
                        @foreach($sectionFields as $field)
                            @if($field->is_visible)
                                <div class="col-md-{{ $field->width ?? 12 }}">
                                    <div class="form-group mb-3 {{ $field->wrapper_class }}">
                                        @if($field->label && !in_array($field->component_name, ['hidden-field', 'divider', 'heading']))
                                            <label for="field-{{ $field->id }}">
                                                {{ $field->label }}
                                                @if($field->required)
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                        @endif

                                        @if($field->description)
                                            <p class="form-text text-muted">{{ $field->description }}</p>
                                        @endif

                                        @include("components.form-fields.{$field->component_name}", [
                                            'field' => $field,
                                            'disabled' => !$field->is_enabled
                                        ])

                                        @if($field->help_text)
                                            <div class="form-text text-muted mt-1">{{ $field->help_text }}</div>
                                        @endif

                                        @error("field.{$field->id}")
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        <div class="form-actions mt-4">
            <button type="submit" class="btn btn-primary">{{ $form->submit_button_text ?? 'Submit' }}</button>
            @if($form->cancel_button_text)
                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ $form->cancel_button_text }}</a>
            @endif
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('dynamic-form-{{ $form->id }}');
    
    // Handle condition logic
    const evaluateConditions = function(fieldId, fieldValue) {
        fetch('{{ route("form-conditions.evaluate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                form_field_id: fieldId,
                value: fieldValue
            })
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                const targetEl = document.querySelector(`[data-field-name="${item.target_field}"]`);
                if (targetEl) {
                    const targetWrap = targetEl.closest('.form-group');
                    
                    switch (item.condition_type) {
                        case 'show':
                            targetWrap.style.display = item.condition_met ? 'block' : 'none';
                            break;
                        case 'hide':
                            targetWrap.style.display = item.condition_met ? 'none' : 'block';
                            break;
                        case 'enable':
                            targetEl.disabled = !item.condition_met;
                            break;
                        case 'disable':
                            targetEl.disabled = item.condition_met;
                            break;
                        case 'require':
                            if (item.condition_met) {
                                targetEl.setAttribute('required', 'required');
                                const label = targetWrap.querySelector('label');
                                if (label && !label.querySelector('.text-danger')) {
                                    label.innerHTML += ' <span class="text-danger">*</span>';
                                }
                            } else {
                                targetEl.removeAttribute('required');
                                const label = targetWrap.querySelector('label');
                                if (label) {
                                    label.innerHTML = label.innerHTML.replace(' <span class="text-danger">*</span>', '');
                                }
                            }
                            break;
                    }
                }
            });
        });
    };
    
    // Listen for changes on fields that have conditions
    form.querySelectorAll('[data-has-conditions="true"]').forEach(field => {
        field.addEventListener('change', function() {
            evaluateConditions(this.dataset.fieldId, this.value);
        });
        
        // Initial evaluation
        if (field.value) {
            evaluateConditions(field.dataset.fieldId, field.value);
        }
    });
});
</script> 