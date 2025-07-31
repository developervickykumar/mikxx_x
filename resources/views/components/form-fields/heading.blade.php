@props(['field', 'disabled' => false])

@php
    $level = isset($field->config['level']) ? (int)$field->config['level'] : 3;
    // Ensure level is between 1 and 6
    $level = max(1, min(6, $level));
@endphp

<div class="heading-field {{ $field->input_class }}">
    @if($level === 1)
        <h1>{{ $field->label }}</h1>
    @elseif($level === 2)
        <h2>{{ $field->label }}</h2>
    @elseif($level === 3)
        <h3>{{ $field->label }}</h3>
    @elseif($level === 4)
        <h4>{{ $field->label }}</h4>
    @elseif($level === 5)
        <h5>{{ $field->label }}</h5>
    @elseif($level === 6)
        <h6>{{ $field->label }}</h6>
    @endif
    
    @if($field->description)
        <p class="heading-description">{{ $field->description }}</p>
    @endif
</div>

<style>
.heading-field {
    margin: 1.5rem 0 1rem;
}
.heading-field h1, .heading-field h2, .heading-field h3, 
.heading-field h4, .heading-field h5, .heading-field h6 {
    margin-bottom: 0.5rem;
}
.heading-description {
    color: #6c757d;
}
</style> 