<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm px-3">
    <!-- Only for mobile -->
    <button class="btn btn-transparent text-success fw-bold d-lg-none me-2" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#sidebar" aria-controls="sidebar">
        <i class="bi bi-chevron-double-right fs-5"></i>
    </button>

    <!-- Desktop Only -->
    <button class="btn btn-transparent text-success fw-bold d-none d-lg-inline me-2" id="desktopSidebarToggle">
        <i class="bi bi-chevron-double-left fs-5"></i>
    </button>

    <div class="ms-auto d-flex align-items-center">
        <span class="me-3">Hi, {{ Auth::user()->username }}</span>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username) }}" class="rounded-circle"
            width="32" height="32" alt="User" />
    </div>
</nav>
