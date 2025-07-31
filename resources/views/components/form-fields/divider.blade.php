@props(['field', 'disabled' => false])

<div class="divider {{ $field->input_class }}">
    <hr>
    @if($field->label)
        <div class="divider-text">{{ $field->label }}</div>
    @endif
</div>

<style>
.divider {
    position: relative;
    display: flex;
    align-items: center;
    margin: 1.5rem 0;
}

.divider hr {
    width: 100%;
    margin: 0;
}

.divider-text {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff;
    padding: 0 1rem;
    font-weight: 500;
}
</style> 