<div class="user-menu">
    <div class="notifications">
        <button class="notification-btn" data-toggle="dropdown">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">0</span>
        </button>
        <div class="notification-dropdown">
            @include('code-generator.partials.notifications')
        </div>
    </div>
    
    <div class="user-profile">
        <button class="profile-btn" data-toggle="dropdown">
            <img src="{{ auth()->user()->avatar }}" alt="User Avatar" class="avatar">
            <span class="username">{{ auth()->user()->name }}</span>
        </button>
        <div class="profile-dropdown">
           
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div> 