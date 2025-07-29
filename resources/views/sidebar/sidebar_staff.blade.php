<aside class="sidebar">
    <nav>
        {{-- Logo --}}
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <hr>

        <div class="menu-title">Menu</div>

        <a href="{{ route('staff.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
            <span class="icon">@include('icons.dashboard')</span>
            <span class="link-text">Dashboard</span>
        </a>

        <a href="{{ route('staff.pickups') }}"
           class="sidebar-link {{ request()->routeIs('staff.pickups') ? 'active' : '' }}">
            <span class="icon">@include('icons.truck-box')</span>
            <span class="link-text">Jadwal & Jemput</span>
        </a>

        <hr>

        <div class="menu-title">Akun</div>

        <a href="{{ route('logout') }}" class="sidebar-link"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="icon">@include('icons.logout')</span>
            <span class="link-text">Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        {{-- Profile Info --}}
        <div class="profile-info">
            <div>
                <div class="profile-name">{{ Auth::user()->username }}</div>
                <div class="profile-email">{{ Auth::user()->email }}</div>
            </div>
        </div>

    </nav>
</aside>
