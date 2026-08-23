<!-- BEGIN Sidebar -->
<aside class="pe-app-sidebar" id="sidebar">
    <div class="pe-sidebar-brand-wrapper">
        <a href="{{ route('dashboard') }}" class="pe-sidebar-brand-link">
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="BGPortal Logo" height="30" class="pe-sidebar-logo-default">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="BGPortal Logo" height="30" class="pe-sidebar-logo-light d-none">
            <img src="{{ asset('assets/images/logo-md.png') }}" alt="BGPortal Logo" height="30" class="pe-sidebar-logo-small d-none">
            <img src="{{ asset('assets/images/logo-md-light.png') }}" alt="BGPortal Logo" height="30" class="pe-sidebar-logo-small-light d-none">
        </a>
        <button type="button" class="pe-sidebar-collapse-btn btn btn-light icon-btn fs-5 rounded-pill d-none" id="collapseSidebar">
            <i class="bi bi-arrow-bar-left"></i>
        </button>
    </div>

    <div class="pe-sidebar-content" data-simplebar>
        <ul class="pe-sidebar-nav">

            <!-- 1. Central Hub -->
            <li class="pe-nav-header">
                <span class="pe-nav-header-title">PORTAL CENTRAL</span>
            </li>

            <li class="pe-slide">
                <a href="{{ route('dashboard') }}" class="pe-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill pe-nav-icon text-primary"></i>
                    <span class="pe-nav-content">Semua Aplikasi</span>
                </a>
            </li>

            <!-- 2. Finanza Keuangan -->
            <li class="pe-nav-header mt-3">
                <span class="pe-nav-header-title">FINANZA KEGIATAN KAS</span>
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

            <!-- 3. Admin Management (Only for Admin) -->
            @if (Auth::check() && Auth::user()->isAdmin())
                <li class="pe-nav-header mt-3">
                    <span class="pe-nav-header-title">ADMINISTRASI PORTAL</span>
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

            <!-- 4. User Profile & Account -->
            <li class="pe-nav-header mt-3">
                <span class="pe-nav-header-title">PENGATURAN AKUN</span>
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
    </div>
</aside>
<!-- END Sidebar -->
<div class="pe-sidebar-overlay" id="sidebarOverlay"></div>
