<div id="sidebar" class="sidebar-collapsible bg-dark text-white" tabindex="-1"
    aria-labelledby="sidebarLabel" style="height: 100vh; background-color: #212529;">

    <div class="offcanvas-body d-flex flex-column bg-dark text-white p-0" style="height: 100vh; width: 100%;">
        <!-- Header & Logo -->
        <div class="p-3 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid logo-img" style="max-height: 60px;">
        </div>

        <!-- Menu -->
        <div class="flex-grow-1 overflow-auto pt-3 px-3">
            <h6 class="text-secondary sidebar-label">Menu</h6>

            <a href="{{ route('admin.dashboard') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                @include('icons.dashboard')
                <span class="ms-2 sidebar-label">Dashboard</span>
            </a>

            <a href="{{ route('admin.scheduleManagement') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->routeIs('admin.scheduleManagement') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                @include('icons.truck-box')
                <span class="ms-2 sidebar-label">Jadwal & Penjemputan</span>
            </a>

            <a href="{{ route('admin.dataLogs') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->routeIs('admin.dataLogs') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                @include('icons.transaction')
                <span class="ms-2 sidebar-label">Log Data</span>
            </a>

            <a href="{{ route('admin.pointShopManagement') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->routeIs('admin.pointShopManagement') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                @include('icons.shopping-cart')
                <span class="ms-2 sidebar-label">Toko Poin</span>
            </a>

            <a href="{{ route('admin.accounts.index') }}"
                class="nav-link mb-2 d-flex align-items-center px-3 py-2 rounded {{ request()->routeIs('admin.accounts.*') ? 'bg-white bg-opacity-10 text-white fw-bold' : 'text-white' }}"
                style="transition: all 0.3s;">
                @include('icons.profile')
                <span class="ms-2 sidebar-label">Kelola Akun</span>
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
