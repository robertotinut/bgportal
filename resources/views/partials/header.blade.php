<!-- Begin Header -->
<header class="app-header" id="appHeader">
    <div class="container-fluid w-100">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Left Header -->
            <div class="d-inline-flex align-items-center gap-3">
                <a href="{{ route('dashboard') }}" class="fs-18 fw-semibold d-flex align-items-center">
                    <img height="30" class="header-sidebar-logo-default" alt="BGPortal Logo" src="{{ asset('assets/images/logo-dark.png') }}">
                </a>

                <button type="button" class="vertical-toggle btn btn-light-light text-muted icon-btn fs-5 rounded-pill" id="toggleSidebar">
                    <i class="bi bi-list header-icon"></i>
                </button>

                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 fw-semibold d-none d-sm-inline-flex align-items-center gap-1.5 fs-12">
                    <i class="bi bi-grid-fill"></i> Central Hub
                </a>
            </div>

            <!-- Right Header -->
            <div class="flex-shrink-0 d-flex align-items-center gap-2">
                <!-- Dark/Light Mode -->
                <div class="dark-mode-btn" id="toggleMode">
                    <button class="btn header-btn active" id="lightModeBtn" title="Mode Terang">
                        <i class="bi bi-brightness-high"></i>
                    </button>
                    <button class="btn header-btn" id="darkModeBtn" title="Mode Gelap">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                </div>

                <!-- User Profile Dropdown -->
                <div class="dropdown pe-dropdown-mega">
                    <button class="header-profile-btn btn gap-2 text-start p-1.5 rounded-pill border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="avatar-xs rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center fw-bold fs-13" style="width: 32px; height: 32px;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </span>
                        <div class="d-none d-lg-block pe-2">
                            <span class="d-block mb-0 fs-13 fw-semibold text-dark">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                            <span class="d-block mb-0 fs-11 text-muted">{{ Auth::user()->isAdmin() ? 'Administrator' : 'Member' }}</span>
                        </div>
                        <i class="bi bi-chevron-down fs-11 text-muted d-none d-lg-inline"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end header-dropdown-menu p-3 rounded-4 shadow border-0" style="min-width: 240px;">
                        <div class="border-bottom pb-2 mb-2 d-flex align-items-center gap-2">
                            <div class="avatar-md rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <h6 class="mb-0 fs-14 fw-bold text-dark text-truncate">{{ Auth::user()->name ?? 'Pengguna' }}</h6>
                                <p class="mb-0 fs-11 text-muted text-truncate">{{ Auth::user()->email ?? 'user@bgportal.com' }}</p>
                                <span class="badge {{ Auth::user()->isAdmin() ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }} fs-10 px-2 py-0.5 rounded-pill mt-1">
                                    {{ Auth::user()->isAdmin() ? 'Administrator' : 'Member' }}
                                </span>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-1 border-bottom pb-1">
                            <li>
                                <a class="dropdown-item py-2 rounded-2 fs-13" href="{{ route('profile.index') }}">
                                    <i class="bi bi-person me-2 text-primary"></i> Profil & Pengaturan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 rounded-2 fs-13" href="{{ route('profile.subscription') }}">
                                    <i class="bi bi-credit-card me-2 text-success"></i> Status Akun & Langganan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 rounded-2 fs-13" href="{{ route('dashboard') }}">
                                    <i class="bi bi-grid me-2 text-info"></i> Kembali ke Central Hub
                                </a>
                            </li>
                        </ul>

                        <ul class="list-unstyled mb-0 pt-1">
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 rounded-2 fs-13 text-danger border-0 bg-transparent w-100 text-start">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar (Sign Out)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END Header -->