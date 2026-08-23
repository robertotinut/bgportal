<aside class="pe-app-sidebar" id="sidebar">
    <div class="pe-app-sidebar-logo px-6 d-flex align-items-center position-relative">
        <!--begin::Brand Image-->
        <a href="{{ route('dashboard') }}" class="fs-18 fw-semibold">
            <img height="30" class="pe-app-sidebar-logo-default" alt="BGPortal Logo" src="{{ asset('assets/images/logo-dark.png') }}">
            <img height="30" class="pe-app-sidebar-logo-light d-none" alt="BGPortal Logo" src="{{ asset('assets/images/logo-light.png') }}">
            <img height="30" class="pe-app-sidebar-logo-minimize d-none" alt="BGPortal Logo" src="{{ asset('assets/images/logo-md.png') }}">
            <img height="30" class="pe-app-sidebar-logo-minimize-light d-none" alt="BGPortal Logo" src="{{ asset('assets/images/logo-md-light.png') }}">
        </a>
        <!--end::Brand Image-->
    </div> 
    <nav class="pe-app-sidebar-menu nav nav-pills" data-simplebar id="sidebar-simplebar">
        <ul class="pe-main-menu list-unstyled">

            <!-- 1. Central Portal -->
            <li class="pe-menu-title">
                <span class="pe-menu-title-text text-uppercase">PORTAL CENTRAL</span>
            </li>

            <li class="pe-slide">
                <a href="{{ route('dashboard') }}" class="pe-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill pe-nav-icon text-primary"></i>
                    <span class="pe-nav-content">Semua Aplikasi</span>
                </a>
            </li>

            <!-- 2. Finanza Keuangan (Hanya jika user punya akses) -->
            @if (Auth::check() && Auth::user()->canAccessApp('finance'))
                <li class="pe-menu-title mt-2">
                    <span class="pe-menu-title-text text-uppercase">FINANZA KEGIATAN KAS</span>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.finance.index') }}" class="pe-nav-link {{ request()->routeIs('apps.finance.index') ? 'active' : '' }}">
                        <i class="bi bi-house-door pe-nav-icon text-indigo"></i>
                        <span class="pe-nav-content">Beranda Keuangan</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.finance.bills') }}" class="pe-nav-link {{ request()->routeIs('apps.finance.bills') ? 'active' : '' }}">
                        <i class="bi bi-receipt pe-nav-icon text-indigo"></i>
                        <span class="pe-nav-content">Tagihan & Langganan</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.finance.reports') }}" class="pe-nav-link {{ request()->routeIs('apps.finance.reports') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart-fill pe-nav-icon text-indigo"></i>
                        <span class="pe-nav-content">Laporan & Mutasi</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.finance.budgets') }}" class="pe-nav-link {{ request()->routeIs('apps.finance.budgets') ? 'active' : '' }}">
                        <i class="bi bi-pie-chart-fill pe-nav-icon text-indigo"></i>
                        <span class="pe-nav-content">Anggaran & Tabungan</span>
                    </a>
                </li>
            @endif

            <!-- 3. Administrasi Portal (Khusus Admin) -->
            @if (Auth::check() && Auth::user()->isAdmin())
                <li class="pe-menu-title mt-2">
                    <span class="pe-menu-title-text text-uppercase">ADMINISTRASI PORTAL</span>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('admin.apps.index') }}" class="pe-nav-link {{ request()->routeIs('admin.apps.*') ? 'active' : '' }}">
                        <i class="bi bi-app-indicator pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Kelola Aplikasi</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('admin.app-access.index') }}" class="pe-nav-link {{ request()->routeIs('admin.app-access.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Hak Akses Pengguna</span>
                    </a>
                </li>
            @endif

            <!-- 4. Pengaturan Akun -->
            <li class="pe-menu-title mt-2">
                <span class="pe-menu-title-text text-uppercase">PENGATURAN AKUN</span>
            </li>

            <li class="pe-slide">
                <a href="{{ route('profile.index') }}" class="pe-nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                    <i class="bi bi-person-fill pe-nav-icon text-success"></i>
                    <span class="pe-nav-content">Profil Saya</span>
                </a>
            </li>

            <li class="pe-slide">
                <a href="{{ route('profile.subscription') }}" class="pe-nav-link {{ request()->routeIs('profile.subscription') ? 'active' : '' }}">
                    <i class="bi bi-credit-card pe-nav-icon text-success"></i>
                    <span class="pe-nav-content">Status Akun & Paket</span>
                </a>
            </li>

            <li class="pe-slide">
                <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">
                    @csrf
                    <a href="#" class="pe-nav-link text-danger" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                        <i class="bi bi-box-arrow-right pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Keluar (Sign Out)</span>
                    </a>
                </form>
            </li>

        </ul>
    </nav>
</aside>
