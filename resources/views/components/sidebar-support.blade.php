@php
    $dashboardRoute = match (auth()->user()?->role) {
        'admin' => route('admin.dashboard'),
        'staff' => route('staff.dashboard'),
        'user' => route('user.dashboard'),
        default => '#',
    };
@endphp
<div id="sidebar" class="sidebar-collapsible bg-dark text-white" tabindex="-1" aria-labelledby="sidebarLabel"
    style="height: 100vh; background-color: #212529;">

    <div class="offcanvas-body d-flex flex-column bg-dark text-white p-0" style="height: 100vh; width: 100%;">
        <!-- Header & Logo -->
        <div class="p-3 text-center">
            <a href="{{ $dashboardRoute }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid logo-img"
                    style="max-height: 60px;">
            </a>
        </div>

        <!-- Menu -->
        <div class="flex-grow-1 overflow-auto pt-3 px-3">
            <h6 class="text-secondary sidebar-label">Support</h6>

            <a href="{{ url('/help-center') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->is('help-center') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                <i class="bi bi-question-circle me-1 px-2"></i>
                <span class="sidebar-label">Help Center</span>
            </a>

            <a href="{{ url('/policy') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->is('policy') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                <i class="fas fa-shield-alt me-1 px-2"></i>
                <span class="sidebar-label">Privacy Policy</span>
            </a>

            <a href="{{ url('/terms') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->is('terms') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                <i class="fas fa-file-alt m-1 px-2"></i>
                <span class="sidebar-label">Terms of Service</span>
            </a>

            <hr class="border-secondary my-3">

            <h6 class="text-secondary sidebar-label">Profile</h6>
            <a href="{{ route('logout') }}"
                class="nav-link text-danger mb-2 d-flex align-items-center px-3 py-2 rounded"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                style="transition: all 0.3s;">
                @include('icons.logout')
                <span class="ms-2 sidebar-label">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>


        <!-- Footer User Info -->
        <div class="p-3 border-top small sidebar-label">
            <div class="fw-bold">{{ Auth::user()->username }}</div>
            <div>{{ Auth::user()->email }}</div>
        </div>
    </div>

</div>
