@php
    $fieldName = Str::slug($field->name, '_');
    $fieldType = $field->functionality ?? 'Optional';
    $viewPath = 'components.inputs.' . Str::slug($fieldType, '-');
    $conditions = $field->conditions ?? [];
    $allFields = $field->table->fields ?? [];
    $settings = $field->settings ?? [];
    $placeholder = $field->placeholder ?? $field->name;
@endphp



<div class="col-md-12 form-group" 
    @if($conditions)
        data-conditions="{{ json_encode($conditions) }}"
    @endif>
    <div class="d-flex justify-content-between align-items-center">
        <!-- <label for="{{ $fieldName }}" class="form-label">{{ $field->name }}</label> -->
        <!-- <-manager :field="$field" :conditions="$conditions" :allFields="$allFields" /> -->
    </div>

    @if(view()->exists($viewPath))
        @include($viewPath, [
            'field' => $field,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue ?? '',
            'fieldValueArray' => $fieldValueArray ?? [],
            'selectedValues' => $selectedValues ?? [],
            'allowUserOptions' => $allowUserOptions ?? false,
            'suggestions' => $suggestions ?? [],
            'user' => $user ?? null,
            'settings' => $settings,
            'user' => $user ?? null
        ])
    @else
        <input type="text" class="form-control" name="{{ $fieldName }}" value="{{ $fieldValue ?? '' }}">
    @endif
</div>

@push('scripts')
    <script src="{{ asset('js/form-conditions.js') }}"></script>
@endpush
