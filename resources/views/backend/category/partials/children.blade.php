@foreach($children as $child)
@php
$label = data_get($child->label_json, 'label');
$circleLetter = match($label) {
'Page' => 'P',
'Form' => 'F',
'Video' => 'V',
'Link' => 'L',
default => Str::limit($child->name, 1, '')
};

$isPublished = !empty($child->code);
$badgeClass = $isPublished ? 'bg-primary' : 'bg-secondary';

@endphp
<a href="{{ route('module.view', ['parentId' => $child->id]) }}" class="circle-badge {{ $badgeClass }}"
    title="{{ $child->name }} - {{ $label ?? 'N/A' }}" data-status="{{ !empty($child->code) ? 'publish' : 'pending' }}"
    data-sector="">
    {{ $circleLetter }}
</a>

@endforeach

<style>
.circle-badge {
    width: 16px;
    height: 16px;
    background-color: #17a2b8;
    color: white;
    font-size: 10px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.circle-badge:hover {
    background-color: #138496;
    text-decoration: none;
}

.accordion-button span {
    font-weight: 500;
}

.card-body {
    min-height: 60px;
}

.filter-badge {
    cursor: pointer;
}

.filter-badge:hover {
    opacity: 0.8;
}
</style>