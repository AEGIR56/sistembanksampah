<aside id="sidebar" class="sidebar">
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <hr>

        <div class="menu-title">Menu</div>

        <a href="{{ route('user.dashboard') }}" class="sidebar-link">
            <span class="icon">@include('icons.dashboard')</span>
            <span class="link-text">Dashboard</span>
        </a>

        <a href="{{ route('user.schedule') }}" class="sidebar-link">
            <span class="icon">@include('icons.truck-box')</span>
            <span class="link-text">Jadwal & Jemput</span>
        </a>

        <a href="{{ route('user.transaction') }}" class="sidebar-link">
            <span class="icon">@include('icons.deposit')</span>
            <span class="link-text">Riwayat Transaksi</span>
        </a>

        <a href="{{ route('user.pointExchange') }}" class="sidebar-link">
            <span class="icon">@include('icons.shopping-cart')</span>
            <span class="link-text">Toko Tukar Poin</span>
        </a>

        <div class="menu-title">Profil</div>

        <a href="{{ route('profile') }}" class="sidebar-link">
            <span class="icon">@include('icons.profile')</span>
            <span class="link-text">Profile</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link" style="width: 100%; text-align: left;">
                <span class="icon">@include('icons.logout')</span>
                <span class="link-text">keluar</span>
            </button>
        </form>

        <div class="profile-info">
            <div>
                <div class="profile-name">{{ Auth::user()->username }}</div>
                <div class="profile-email">{{ Auth::user()->email }}</div>
            </div>
        </div>
    </nav>
</aside>
