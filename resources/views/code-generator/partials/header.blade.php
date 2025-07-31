<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Code Generator')</title>
    
    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('css/styles.css') }}" as="style">
    <link rel="preload" href="{{ asset('fonts/main-font.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('js/i18n.js') }}" as="script">
    <link rel="preload" href="{{ asset('js/analytics.js') }}" as="script">
    <link rel="preload" href="{{ asset('js/security.js') }}" as="script">
    
    <!-- Security Scripts -->
    <script src="{{ asset('js/security.js') }}"></script>
    
    <!-- Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    
    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @stack('styles')
</head>
</rewritten_file> 