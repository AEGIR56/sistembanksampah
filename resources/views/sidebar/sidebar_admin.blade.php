<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <!-- Toggle Button -->
        <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebar" aria-controls="sidebar">
            <i class="bi bi-list"></i>
        </button>

    </div>
    <div class="offcanvas-body d-flex flex-column">
        <!-- Logo -->
        <div class="mb-4 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 60px;">
        </div>

        <hr>
        <h6 class="text-muted text-uppercase small fw-bold">Menu</h6>

        <a href="{{ route('admin.dashboard') }}" class="nav-link text-dark mb-2">
            @include('icons.dashboard') Dashboard
        </a>
        <a href="{{ route('admin.scheduleManagement') }}" class="nav-link text-dark mb-2">
            @include('icons.truck-box') Jadwal & Penjemputan
        </a>
        <a href="{{ route('admin.dataLogs') }}" class="nav-link text-dark mb-2">
            @include('icons.transaction') Log Data
        </a>
        <a href="{{ route('admin.pointShopManagement') }}" class="nav-link text-dark mb-2">
            @include('icons.shopping-cart') Toko Poin
        </a>
        <a href="{{ route('admin.accounts.index') }}" class="nav-link text-dark mb-2">
            @include('icons.profile') Kelola Akun
        </a>

        <hr>
        <h6 class="text-muted text-uppercase small fw-bold">Profile</h6>

        <a href="{{ route('logout') }}" class="nav-link text-danger mb-2"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            @include('icons.logout') Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

        <div class="mt-auto pt-4 border-top small">
            <div class="fw-bold">{{ Auth::user()->username }}</div>
            <div class="text-muted">{{ Auth::user()->email }}</div>
        </div>
    </div>
</div>
