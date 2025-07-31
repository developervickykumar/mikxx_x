@props(['permission', 'context' => []])

@if($this->hasPermission())
    {{ $slot }}
@endif 