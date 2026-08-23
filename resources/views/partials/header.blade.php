<!-- Begin Header -->
<header class="app-header" id="appHeader">
    <div class="container-fluid w-100">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <div class="d-inline-flex align-items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="fs-18 fw-semibold">
                        <img height="30" class="header-sidebar-logo-default d-none" alt="BGPortal Logo" src="{{ asset('assets/images/logo-dark.png') }}">
                        <img height="30" class="header-sidebar-logo-light d-none" alt="BGPortal Logo" src="{{ asset('assets/images/logo-light.png') }}">
                        <img height="30" class="header-sidebar-logo-small d-none" alt="BGPortal Logo" src="{{ asset('assets/images/logo-md.png') }}">
                        <img height="30" class="header-sidebar-logo-small-light d-none" alt="BGPortal Logo" src="{{ asset('assets/images/logo-md-light.png') }}">
                    </a>
                    <button type="button" class="vertical-toggle btn btn-light-light text-muted icon-btn fs-5 rounded-pill" id="toggleSidebar">
                        <i class="bi bi-arrow-bar-left header-icon"></i>
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 fw-semibold d-none d-sm-inline-flex align-items-center gap-1.5 fs-12">
                        <i class="bi bi-grid-fill"></i> Central Hub
                    </a>
                </div>
            </div>

            <div class="flex-shrink-0 d-flex align-items-center gap-2">
                <div class="dark-mode-btn" id="toggleMode">
                    <button class="btn header-btn active" id="lightModeBtn" title="Mode Terang">
                        <i class="bi bi-brightness-high"></i>
                    </button>
                    <button class="btn header-btn" id="darkModeBtn" title="Mode Gelap">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                </div>

                <div class="dropdown pe-dropdown-mega">
                    <button class="header-profile-btn btn gap-1 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="header-btn btn position-relative">
                            <img src="{{ asset('assets/images/avatar/avatar-10.jpg') }}" alt="Avatar Image" class="img-fluid rounded-circle">
                            <span class="position-absolute translate-middle badge border border-light rounded-circle bg-success"><span class="visually-hidden">online</span></span>
                        </span>
                        <div class="d-none d-lg-block pe-2">
                            <span class="d-block mb-0 fs-13 fw-semibold">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                            <span class="d-block mb-0 fs-12 text-muted">{{ Auth::user()->isAdmin() ? 'Administrator' : 'Member' }}</span>
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-mega-sm header-dropdown-menu p-3 rounded-4 shadow border-0" style="min-width: 240px;">
                        <div class="border-bottom pb-2 mb-2 d-flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/avatar/avatar-10.jpg') }}" alt="Avatar Image" class="avatar-md rounded-circle">
                            <div class="overflow-hidden">
                                <h6 class="mb-0 fs-14 fw-bold text-dark text-truncate">{{ Auth::user()->name ?? 'Pengguna' }}</h6>
                                <p class="mb-0 fs-12 text-muted text-truncate">{{ Auth::user()->email ?? 'user@bgportal.com' }}</p>
                                <span class="badge {{ Auth::user()->isAdmin() ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }} fs-10 px-2 py-0.5 rounded-pill mt-1">
                                    {{ Auth::user()->isAdmin() ? 'Administrator' : 'Member' }}
                                </span>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-1 border-bottom pb-1">
                            <li>
                                <a class="dropdown-item py-2 rounded-2 fs-13" href="{{ route('profile.index') }}">
                                    <i class="bi bi-person me-2 text-primary"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 rounded-2 fs-13" href="{{ route('profile.subscription') }}">
                                    <i class="bi bi-credit-card me-2 text-success"></i> Status Akun & Paket
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
                                <form method="POST" action="{{ route('logout') }}" id="header-logout-form">
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