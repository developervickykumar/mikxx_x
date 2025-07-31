@props(['field', 'disabled' => false])

<div class="password-field-wrapper">
    <input 
        type="password"
        id="field-{{ $field->id }}"
        name="field[{{ $field->id }}]"
        class="form-control {{ $field->input_class }}"
        placeholder="{{ $field->placeholder }}"
        @if($disabled) disabled @endif
        @if($field->required) required @endif
        {!! $field->attributes ? implode(' ', array_map(fn($v, $k) => "$k=\"$v\"", $field->attributes, array_keys($field->attributes))) : '' !!}
        data-field-name="{{ $field->name }}"
        data-field-id="{{ $field->id }}"
        @if($field->conditions->count() > 0) data-has-conditions="true" @endif
    >
    <button type="button" class="btn btn-outline-secondary toggle-password" 
        onclick="togglePasswordVisibility('field-{{ $field->id }}')">
        <i class="fa fa-eye"></i>
    </button>
</div>

<script>
function togglePasswordVisibility(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const toggleBtn = document.querySelector(`[onclick="togglePasswordVisibility('${fieldId}')"] i`);
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleBtn.classList.remove('fa-eye');
        toggleBtn.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        toggleBtn.classList.remove('fa-eye-slash');
        toggleBtn.classList.add('fa-eye');
    }
}
</script>

<style>
.password-field-wrapper {
    position: relative;
    display: flex;
}
.password-field-wrapper input {
    flex: 1;
}
.password-field-wrapper .toggle-password {
    position: absolute;
    right: 0;
    height: 100%;
    border: none;
    background: transparent;
}
</style> 