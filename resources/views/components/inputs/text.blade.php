@if(empty($settings) || ($settings['enabled'] ?? true))
    <input type="text" placeholder="{{ $placeholder }}" class="form-control border-0" name="{{ $fieldName }}" value="{{ $fieldValue }}">
@endif
