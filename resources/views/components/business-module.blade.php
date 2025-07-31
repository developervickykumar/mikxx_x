@props(['module'])

@php
$business = request()->route('business');
$isAccessible = $business && in_array($module, auth()->user()->getAccessibleBusinessModules($business)->toArray());
@endphp

@if($isAccessible)
    {{ $slot }}
@endif 