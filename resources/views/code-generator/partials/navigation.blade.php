<nav class="main-nav">
    <div class="nav-container">
        <div class="nav-brand">
            <a href="{{ route('code-generator.dashboard') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="Code Generator Logo">
            </a>
        </div>
        
        <div class="nav-menu">
            <a href="{{ route('code-generator.dashboard') }}" class="nav-item {{ request()->routeIs('code-generator.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('code-generator.template-library') }}" class="nav-item {{ request()->routeIs('code-generator.template-library') ? 'active' : '' }}">
                Template Library
            </a>
            <a href="{{ route('code-generator.analytics') }}" class="nav-item {{ request()->routeIs('code-generator.analytics') ? 'active' : '' }}">
                Analytics
            </a>
        </div>
        
        <div class="nav-actions">
            @include('code-generator.partials.user-menu')
        </div>
    </div>
</nav> 