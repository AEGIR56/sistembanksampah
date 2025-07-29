<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWOB | Admin Panel</title>

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    @stack('styles')
</head>

<body class="d-flex flex-column" data-bs-theme="light">
    <div class="wrapper d-flex w-100 min-vh-100">
        <!-- Sidebar -->
        <x-sidebar-admin />

        <!-- Main Content -->
        <div class="main flex-grow-1 bg-light text-dark">
            <!-- Topbar -->
            <x-navbar-top />

            <main class="content">
                <div class="container-fluid p-4">
                    @yield('content')
                    @stack('scripts')
                </div>
            </main>
            <footer class="footer mt-auto bg-light text-white py-3 shadow-lg">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-12 col-md-6 text-start">
                            <p class="mb-0 small">
                                <span class="fw-semibold text-success">AWOB Admin Panel</span> &copy;
                                {{ date('Y') }}. All rights reserved.
                            </p>
                        </div>
                        <div class="col-12 col-md-6 text-end">
                            <ul class="list-inline mb-0 small">
                                @if (!empty($sidebarSetting?->footer_links))
                                    @foreach ($sidebarSetting->footer_links as $label => $url)
                                        <li class="list-inline-item me-2">
                                            <a href="{{ $url }}" target="_blank"
                                                class="text-success text-decoration-none">{{ $label }}</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-inline-item me-2"><a href="#"
                                            class="text-success text-decoration-none">Support</a></li>
                                    <li class="list-inline-item me-2"><a href="#"
                                            class="text-success text-decoration-none">Help Center</a></li>
                                    <li class="list-inline-item me-2"><a href="#"
                                            class="text-success text-decoration-none">Privacy</a></li>
                                    <li class="list-inline-item me-2"><a href="#"
                                            class="text-success text-decoration-none">Terms</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    {{-- Sidebar Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const wrapper = document.querySelector('.wrapper');
            const toggleCollapseBtn = document.getElementById('desktopSidebarToggle');
            const offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(sidebar);

            function setToggleIcon(isCollapsed) {
                const icon = toggleCollapseBtn.querySelector('i');
                if (!icon) return;
                icon.classList.replace(
                    isCollapsed ? 'bi-chevron-double-left' : 'bi-chevron-double-right',
                    isCollapsed ? 'bi-chevron-double-right' : 'bi-chevron-double-left'
                );
            }

            // ✅ Restore sidebar state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                wrapper.classList.add('sidebar-collapsed');
                setToggleIcon(true);
            }

            // ✅ Toggle collapse (desktop)
            toggleCollapseBtn?.addEventListener('click', () => {
                const collapsed = sidebar.classList.toggle('collapsed');
                wrapper.classList.toggle('sidebar-collapsed');
                setToggleIcon(collapsed);
                localStorage.setItem('sidebarCollapsed', collapsed);
            });

            // ✅ Auto-close sidebar on link click (mobile)
            sidebar.querySelectorAll('a.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 430) {
                        offcanvasInstance.hide();
                    }
                });
            });
        });
    </script>

</body>


</html>
