@props(['page'])

@php
$business = request()->route('business');
$isAccessible = $business && in_array($page, auth()->user()->getAccessibleBusinessPages($business)->toArray());
@endphp

@if($isAccessible)
    {{ $slot }}
@endif 