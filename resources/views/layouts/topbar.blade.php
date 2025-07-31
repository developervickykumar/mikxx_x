<style>
.page-title-box {
    display: none !important;
}

.navbar-header {
    display: flex;
    justify-content: start;
    align-items: center;
}
</style>

<header id="page-topbar">
    <div class="navbar-header">

        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('profile') }}" class="logo logo-dark">
                    <span class="logo-sm ">
                        <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" class="rounded-circle" alt=""
                            height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" class="rounded-circle" alt=""
                            height="40"> <span class="logo-txt rounded-circle"></span>
                        <span class="text-muted">{{ Auth::check() ? Auth::user()->username : 'Guest' }}</span>
                    </span>
                </a>

                <a href="{{ route('post.index') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('build/images/dellywood-logo.webp') }}" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('build/images/dellywood-logo.webp') }}" alt="" height="24"> <span
                            class="logo-txt">Dellywood</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <!-- <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form> -->
        </div>

        <a href="{{ route('post.index') }}" class="logo">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/dellywood-logo.webp') }}" alt="" height="24">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/dellywood-logo.webp') }}" alt="" height="24"> <span
                    class="logo-txt">Mikxx</span>
            </span>
        </a>

        <div class="d-flex ms-auto">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item" id="page-header-search-dropdown" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i data-feather="search" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Search Result">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none">
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    @switch(Session::get('lang'))
                    @case('ru')
                    <img src="{{ URL::asset('build/images/flags/russia.jpg') }}" alt="Header Language" height="16">
                    @break
                    @case('it')
                    <img src="{{ URL::asset('build/images/flags/italy.jpg') }}" alt="Header Language" height="16">
                    @break
                    @case('de')
                    <img src="{{ URL::asset('build/images/flags/germany.jpg') }}" alt="Header Language" height="16">
                    @break
                    @case('es')
                    <img src="{{ URL::asset('build/images/flags/spain.jpg') }}" alt="Header Language" height="16">
                    @break
                    @default
                    <img src="{{ URL::asset('build/images/flags/us.jpg') }}" alt="Header Language" height="16">
                    @endswitch
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <a href="{{ url('index/en') }}" class="dropdown-item notify-item language" data-lang="eng">
                        <img src="{{ URL::asset('build/images/flags/us.jpg') }}" alt="user-image" class="me-1"
                            height="12"> <span class="align-middle">English</span>
                    </a>
                    <!-- item-->
                    <a href="{{ url('index/es') }}" class="dropdown-item notify-item language" data-lang="sp">
                        <img src="{{ URL::asset('build/images/flags/spain.jpg') }}" alt="user-image" class="me-1"
                            height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/de') }}" class="dropdown-item notify-item language" data-lang="gr">
                        <img src="{{ URL::asset('build/images/flags/germany.jpg') }}" alt="user-image" class="me-1"
                            height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/it') }}" class="dropdown-item notify-item language" data-lang="it">
                        <img src="{{ URL::asset('build/images/flags/italy.jpg') }}" alt="user-image" class="me-1"
                            height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/ru') }}" class="dropdown-item notify-item language" data-lang="ru">
                        <img src="{{ URL::asset('build/images/flags/russia.jpg') }}" alt="user-image" class="me-1"
                            height="12"> <span class="align-middle">Russian</span>
                    </a>

                </div>
            </div>

            <!--<span class="btn btn-trans align-content-center">-->
            <!--    <a href="{{ route('post.index') }}" class="text-secondary">-->
            <!--        <i class="dripicons-home fs-5 icon-choice" style="font-size: 20px; !important;"></i>-->
            <!--    </a>-->
            <!--</span>-->
            
              <span class="btn btn-trans align-content-center position-relative">
                <a href="{{route('cart.view')}}" class="text-secondary">
                    <i class="mdi mdi-cart-outline fs-4 " style="font-size: 20px !important;"></i>
                </a>

                <span style="top:10px; left:35px"
                    class="position-absolute translate-middle badge rounded-pill bg-danger">
                    {{32 }}
                </span>

            </span>

            <!-- Notification Icon with Badge -->
            <span class="btn btn-trans align-content-center position-relative">
                <a href="" class="text-secondary">
<i class="dripicons-wallet icon-choice" data-icon-class="dripicons-wallet" data-keywords=""></i>                </a>

                <span style="top:10px; left:35px"
                    class="position-absolute translate-middle badge rounded-pill bg-danger">
                    {{3 }}
                </span>

            </span>
            
            <span class="btn btn-trans align-content-center position-relative">
                <a href="" class="text-secondary">
                    <i class="mdi mdi-bell-outline fs-4" style="font-size: 20px !important;"></i>
                </a>

                <span style="top:10px; left:35px"
                    class="position-absolute translate-middle badge rounded-pill bg-danger">
                    {{32 }}
                </span>

            </span>

            <!-- Chat Icon with Badge -->
            <span class="btn btn-trans align-content-center position-relative">
                <a href="" class="text-secondary">
                    <i class="bx bx-message-rounded fs-4 icon-choice" style="font-size: 20px !important;"></i>
                </a>

                <span style="top:10px; left:35px"
                    class="position-absolute translate-middle badge rounded-pill bg-primary">
                    {{ 2}}
                </span>

            </span>




            @php
            if(Auth::check()){
            $user = auth()->user();
            $defaultLabel = 'User Profile';

            if ($user->is_admin) {
            $defaultLabel = 'Admin Dashboard';
            } elseif (request()->routeIs('business.profile')) {
            $defaultLabel = 'Business Profile';
            } elseif (request()->routeIs('profile')) {
            $defaultLabel = 'User Profile';
            }
            }
            @endphp

            <!--<div class="dropdown d-inline-block">-->
            <!--    <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true"-->
            <!--        aria-expanded="false">-->
            <!--        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>-->
            <!--        <span class="ms-2">{{ $defaultLabel ?? 'User Profile' }}</span>-->
            <!--    </button>-->

            <!--    <div class="dropdown-menu dropdown-menu-end">-->
            <!--        <div class="space-x-4">-->
            <!--            <a href="{{ route('profile') }}"-->
            <!--                class="d-block ps-1 inline-flex items-center py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ request()->routeIs('profile') ? 'bg-gray-100' : '' }}">-->
            <!--                <i class="fas fa-user mr-2"></i> User Profile-->
            <!--            </a>-->

            <!--            <a href="{{ route('business.profile') }}"-->
            <!--                class="d-block ps-1 inline-flex items-center py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ request()->routeIs('business.profile') ? 'bg-gray-100' : '' }}">-->
            <!--                <i class="fas fa-building mr-2"></i> Business Profile-->
            <!--            </a>-->
            <!--            @if(Auth::check() && $user->is_admin)-->
            <!--            <a href="{{ route('admin.dashboard') }}"-->
            <!--                class="d-block ps-1 inline-flex items-center py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : '' }}">-->
            <!--                <i class="fas fa-shield-alt mr-2"></i> Admin Dashboard-->
            <!--            </a>-->
            <!--            @endif-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->





            <!--<div class="dropdown d-inline-block">-->
            <!--    <button type="button" class="btn header-item topbar-light bg-light-subtle border-start border-end"-->
            <!--        id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--        @if(isset($candidate) && $candidate)-->
            <!--        <img class="rounded-circle header-profile-user text-capitalize"-->
            <!--            src="{{ $candidate->profile_pic ? Storage::url('build/images/candidates/' . $candidate->profile_pic) : URL::asset('build/images/users/avatar-1.jpg') }}"-->
            <!--            alt="Header Avatar">-->
            <!--        @else-->
            <!--        <img class="rounded-circle header-profile-user text-capitalize"-->
            <!--            src="{{ URL::asset('build/images/users/avatar-1.jpg') }}" alt="Default Avatar">-->
            <!--        @endif-->
            <!--        <span class="d-none d-xl-inline-block ms-1 fw-medium">-->
            <!--            {{ Auth::check() ? Auth::user()->username : 'Guest' }}-->
            <!--        </span>-->
            <!--        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>-->
            <!--    </button>-->


            <!--    <div class="dropdown-menu dropdown-menu-end">-->
                    <!-- item-->
            <!--        <a class="dropdown-item" href="{{ route('profile') }}"><i-->
            <!--                class="mdi mdi-face-man font-size-16 align-middle me-1"></i> Profile</a>-->
                    <!-- <a class="dropdown-item" href="auth-lock-screen"><i
            <!--                class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock screen</a> -->
            <!--        <div class="dropdown-divider"></div>-->
            <!--        <a class="dropdown-item text-danger" href="javascript:void();"-->
            <!--            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i-->
            <!--                class="mdi mdi-logout font-size-16 align-middle me-1"></i> <span key="t-logout">Log-->
            <!--                Out</span></a>-->
            <!--        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">-->
            <!--            @csrf-->
            <!--        </form>-->


            <!--        <div class="dropdown d-none d-sm-block">-->
            <!--            <button type="button" class="btn" id="mode-setting-btn">-->
            <!--                <i data-feather="moon" class="icon-lg layout-mode-dark"></i>-->
            <!--                <span class="d-none d-xl-inline-block ms-1 fw-medium">Day / Night Mode</span>-->
            <!--                <i data-feather="sun" class="icon-lg layout-mode-light"></i>-->
            <!--            </button>-->
            <!--        </div>-->

            <!--        <div class="dropdown d-block">-->
            <!--            <a href="{{ route('tab-form-management') }}">-->

            <!--                <i data-feather="settings" class="icon-lg"></i>-->
            <!--                <span class="d-none d-xl-inline-block ms-1 fw-medium">Tabs Settings</span>-->
            <!--            </a>-->
            <!--        </div>-->

            <!--    </div>-->
            <!--</div>-->

        </div>
    </div>
</header>

@if( isset($upcomingEvents) && $upcomingEvents->isNotEmpty())

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="notifications">
                <h5>Upcoming Events:</h5>
                <ul>
                    @foreach($upcomingEvents as $event)
                    <li>
                        <strong>{{ $event->name }}</strong><br>
                        Date:
                        {{ \Carbon\Carbon::parse($event->date . ' ' . $event->time)->format('l, F j, Y h:i A') }}<br>
                        Location: {{ $event->venue ? $event->venue : 'Online' }}<br>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endif