@props(['inputId', 'iconClass' => 'dripicons-photo', 'categoryId'])

<div class="icon-wrapper d-flex align-items-center gap-2">
    <i class="{{ $iconClass }} fs-4 choose-icon-btn"
       data-target-input="#{{ $inputId }}"
       data-category-id="{{ $categoryId }}"
       title="Click to change icon"></i>
    <input type="hidden" id="{{ $inputId }}" value="{{ $iconClass }}">
</div>
