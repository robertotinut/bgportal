<aside class="pe-app-sidebar" id="sidebar">
    <div class="pe-app-sidebar-logo px-6 d-flex align-items-center position-relative">
        <!--begin::Brand Image-->
        <a href="{{ route('dashboard') }}" class="fs-18 fw-semibold">
            <img height="30" class="pe-app-sidebar-logo-default d-none" alt="Logo" src="{{ asset('assets/images/logo-dark.png') }}">
            <img height="30" class="pe-app-sidebar-logo-light d-none" alt="Logo" src="{{ asset('assets/images/logo-light.png') }}">
            <img height="30" class="pe-app-sidebar-logo-minimize d-none" alt="Logo" src="{{ asset('assets/images/logo-md.png') }}">
            <img height="30" class="pe-app-sidebar-logo-minimize-light d-none" alt="Logo" src="{{ asset('assets/images/logo-md-light.png') }}">
            <!-- FabKin -->
        </a>
        <!--end::Brand Image-->
    </div> 
    <nav class="pe-app-sidebar-menu nav nav-pills" data-simplebar id="sidebar-simplebar">
        <ul class="pe-main-menu list-unstyled">
            @if (request()->is('apps/pos*'))
                <!-- POS Specific Contextual Sidebar -->
                <li class="pe-menu-title px-4 py-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali ke Central</span>
                    </a>
                </li>

                <li class="pe-menu-title text-primary fw-bold mt-2">
                    <i class="bi bi-shop me-1"></i> Point of Sale (POS)
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pos.index') }}" class="pe-nav-link {{ request()->routeIs('apps.pos.index') ? 'active' : '' }}">
                        <i class="bi bi-cart3 pe-nav-icon text-primary"></i>
                        <span class="pe-nav-content">Kasir / Transaksi</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pos.reports') }}" class="pe-nav-link {{ request()->routeIs('apps.pos.reports') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart-line pe-nav-icon text-success"></i>
                        <span class="pe-nav-content">Laporan Penjualan</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pos.products') }}" class="pe-nav-link {{ request()->routeIs('apps.pos.products') ? 'active' : '' }}">
                        <i class="bi bi-box-seam pe-nav-icon text-warning"></i>
                        <span class="pe-nav-content">Manajemen Produk</span>
                    </a>
                </li>
            @elseif (request()->is('apps/pinterest-affiliate*'))
                <!-- Pinterest Affiliate Specific Contextual Sidebar -->
                <li class="pe-menu-title px-4 py-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali ke Central</span>
                    </a>
                </li>

                <li class="pe-menu-title text-danger fw-bold mt-2">
                    <i class="bi bi-pinterest me-1"></i> Pinterest Affiliate
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pinterest.index') }}" class="pe-nav-link {{ request()->routeIs('apps.pinterest.index') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Dashboard Otomasi</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pinterest.links') }}" class="pe-nav-link {{ request()->routeIs('apps.pinterest.links') ? 'active' : '' }}">
                        <i class="bi bi-link-45deg pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Link Affiliate & Queue</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pinterest.accounts') }}" class="pe-nav-link {{ request()->routeIs('apps.pinterest.accounts') ? 'active' : '' }}">
                        <i class="bi bi-person-badge pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Akun Pinterest</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pinterest.settings') }}" class="pe-nav-link {{ request()->routeIs('apps.pinterest.settings') ? 'active' : '' }}">
                        <i class="bi bi-sliders pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Pengaturan Otomasi</span>
                    </a>
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.pinterest.logs') }}" class="pe-nav-link {{ request()->routeIs('apps.pinterest.logs') ? 'active' : '' }}">
                        <i class="bi bi-journal-text pe-nav-icon text-danger"></i>
                        <span class="pe-nav-content">Log & Riwayat Posting</span>
                    </a>
                </li>
            @elseif (request()->is('apps/finance*'))
                <!-- Finanza Specific Contextual Sidebar -->
                <li class="pe-menu-title px-4 py-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali ke Central</span>
                    </a>
                </li>

                <li class="pe-menu-title text-warning fw-bold mt-2">
                    <i class="bi bi-wallet2 me-1"></i> Finanza Keuangan
                </li>

                <li class="pe-slide">
                    <a href="{{ route('apps.finance.index') }}" class="pe-nav-link {{ request()->routeIs('apps.finance.index') ? 'active' : '' }}">
                        <i class="bi bi-pie-chart-fill pe-nav-icon text-warning"></i>
                        <span class="pe-nav-content">Anggaran & Tabungan</span>
                    </a>
                </li>
            @else
                <!-- Central Hub Sidebar -->
                <li class="pe-slide">
                    <a href="{{ route('dashboard') }}" class="pe-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 pe-nav-icon text-primary"></i>
                        <span class="pe-nav-content">Central Dashboard</span>
                    </a>
                </li>

                @if (Auth::check() && Auth::user()->isAdmin())
                    <li class="pe-menu-title">
                        Pengaturan Admin
                    </li>
                    <li class="pe-slide">
                        <a href="{{ route('admin.apps.index') }}" class="pe-nav-link {{ request()->routeIs('admin.apps.*') ? 'active' : '' }}">
                            <i class="bi bi-grid-fill pe-nav-icon"></i>
                            <span class="pe-nav-content">Manajemen Aplikasi</span>
                        </a>
                    </li>
                    <li class="pe-slide">
                        <a href="{{ route('admin.app-access.index') }}" class="pe-nav-link {{ request()->routeIs('admin.app-access.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock-fill pe-nav-icon"></i>
                            <span class="pe-nav-content">Hak Akses User</span>
                        </a>
                    </li>
                @endif

                <li class="pe-menu-title">
                    Aplikasi Central
                </li>
                @if (Auth::check())
                    @forelse (Auth::user()->accessibleApps() as $app)
                        <li class="pe-slide">
                            <a href="{{ $app->url }}" class="pe-nav-link">
                                <i class="{{ $app->icon ?? 'bi bi-app-indicator' }} pe-nav-icon"></i>
                                <span class="pe-nav-content">{{ $app->name }}</span>
                                <i class="bi bi-arrow-right-short ms-auto fs-16 opacity-50"></i>
                            </a>
                        </li>
                    @empty
                        <li class="pe-slide px-4 py-2 text-muted fs-12">Tidak ada aplikasi.</li>
                    @endforelse
                @endif
            @endif
            <li class="pe-slide pe-has-sub">
                <a href="#collapseEcommerce" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseEcommerce">
                    <i class="bi bi-cart4 pe-nav-icon"></i>
                    <span class="pe-nav-content">E-Commerce</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseEcommerce">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">E-Commerce</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-products" class="pe-nav-link">
                            Products
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-products-details" class="pe-nav-link">
                            Product Details
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-products-list" class="pe-nav-link">
                            Product List
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-add-products" class="pe-nav-link">
                            Add Product
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-order-details" class="pe-nav-link">
                            Order Details
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-order" class="pe-nav-link">
                            Orders
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-cart" class="pe-nav-link">
                            Cart
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-checkout" class="pe-nav-link">
                            Checkout
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-ecommerce-wishlist" class="pe-nav-link">
                            Wishlist
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseAcademy" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseAcademy">
                    <i class="bi bi-mortarboard pe-nav-icon"></i>
                    <span class="pe-nav-content">Academy</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseAcademy">
                    <li class="pe-slide pe-has-sub">
                        <a href="#collapseCourses" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseCourses">
                            <span class="pe-nav-sub-content">Courses</span>
                            <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                        </a>
                        <ul class="pe-slide-menu collapse" id="collapseCourses">
                            <li class="pe-slide-item">
                                <a href="apps-academy-courses" class="pe-nav-link">All Courses</a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="apps-academy-courses-category" class="pe-nav-link">Courses Category</a>
                            </li>
                        </ul>
                    </li>
                    <li class="pe-slide pe-has-sub">
                        <a href="#collapseUsers" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseUsers">
                            <span class="pe-nav-sub-content">User</span>
                            <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                        </a>
                        <ul class="pe-slide-menu collapse" id="collapseUsers">
                            <li class="pe-slide-item">
                                <a href="apps-academy-user-instructor" class="pe-nav-link">Instructor</a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="apps-academy-user-student" class="pe-nav-link">Students</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            
            <li class="pe-slide pe-has-sub">
                <a href="#collapseCMS" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseCMS">
                    <i class="bi bi-book pe-nav-icon"></i>
                    <span class="pe-nav-content">CMS</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseCMS">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">CMS</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-cms-content" class="pe-nav-link">
                            Content
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-cms-add-content" class="pe-nav-link">
                           Add Content
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-cms-menus" class="pe-nav-link">
                            Menus
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-cms-blog" class="pe-nav-link">
                            Blog
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseLogistics" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseLogistics">
                    <i class="bi bi-truck pe-nav-icon"></i>
                    <span class="pe-nav-content">Logistics</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseLogistics">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Logistics</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-logistic-list" class="pe-nav-link">
                            List
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-logistic-overview" class="pe-nav-link">
                            Overview
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-logistic-create" class="pe-nav-link">
                            Create Project
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseCRM" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseCRM">
                    <i class="bi bi-binoculars pe-nav-icon"></i>
                    <span class="pe-nav-content">CRM</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseCRM">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">CRM</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-crm-contact" class="pe-nav-link">
                            Contact
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-crm-lead" class="pe-nav-link">
                            Lead
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-crm-deal" class="pe-nav-link">
                            Deal
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseProjects" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseProjects">
                    <i class="bi bi-cast pe-nav-icon"></i>
                    <span class="pe-nav-content">Projects</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseProjects">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Projects</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-project-list" class="pe-nav-link">
                            List
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-project-overview" class="pe-nav-link">
                            Overview
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-project-create" class="pe-nav-link">
                            Create Project
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseInvoices" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseInvoices">
                    <i class="bi bi-receipt pe-nav-icon"></i>
                    <span class="pe-nav-content">Invoices</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseInvoices">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Invoices</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-invoice-list" class="pe-nav-link">
                            List
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-invoice-detail" class="pe-nav-link">
                            Details
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="apps-invoice-create" class="pe-nav-link">
                            Create invoice
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-menu-title">
                Pages
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapsePages" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapsePages">
                    <i class="bi bi-airplane pe-nav-icon"></i>
                    <span class="pe-nav-content">Pages</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapsePages">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Pages</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-starter" class="pe-nav-link">
                            Blank Page
                        </a>
                    </li>
                    <li class="pe-slide pe-has-sub">
                        <a href="#collapseProfile" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseProfile">
                            <span class="pe-nav-sub-content">Profile</span>
                            <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                        </a>
                        <ul class="pe-slide-menu collapse" id="collapseProfile">
                            <li class="slide pe-nav-content1">
                                <a href="javascript:void(0)">Profile</a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="pages-profile" class="pe-nav-link">
                                    Simple Page
                                </a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="pages-profile-setting" class="pe-nav-link">
                                    Settings
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="pe-slide pe-has-sub">
                        <a href="#collapseBlogs" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseBlogs">
                            <span class="pe-nav-sub-content">Blogs</span>
                            <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                        </a>
                        <ul class="pe-slide-menu collapse" id="collapseBlogs">
                            <li class="slide pe-nav-content1">
                                <a href="javascript:void(0)">Blog</a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="pages-blog-list" class="pe-nav-link">
                                    Blog List
                                </a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="pages-blog-details" class="pe-nav-link">
                                    Blog Details
                                </a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="pages-blog-create" class="pe-nav-link">
                                    Create Blog
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-timeline" class="pe-nav-link">
                            Timeline
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-faqs" class="pe-nav-link">
                            FAQs
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-billing-subscription" class="pe-nav-link">
                            Billing & Subscription
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-pricing" class="pe-nav-link">
                            Pricing
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-gallery" class="pe-nav-link">
                            Gallery
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-sitemap" class="pe-nav-link">
                            Sitemap
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-search-result" class="pe-nav-link">
                            Search Results
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-privacy-policy" class="pe-nav-link">
                            Privacy Policy
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="pages-terms-conditions" class="pe-nav-link">
                            Terms & Conditions
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseAuth" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseAuth">
                    <i class="bi bi-person pe-nav-icon"></i>
                    <span class="pe-nav-content">Authentication</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseAuth">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Authentication</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-signin" class="pe-nav-link">
                            Sign in
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-signup" class="pe-nav-link">
                            Sign Up
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-create-password" class="pe-nav-link">
                            Create Password
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-reset-password" class="pe-nav-link">
                            Reset Password
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-two-step-verify" class="pe-nav-link">
                            Two Step Verification
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-lockscreen" class="pe-nav-link">
                            Lock Screen
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="coming-soon" class="pe-nav-link">
                            Coming Soon
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="under-maintenance" class="pe-nav-link">
                            Under Maintenance
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseError" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseError">
                    <i class="bi bi-bug pe-nav-icon"></i>
                    <span class="pe-nav-content">Error</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseError">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Error</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-401" class="pe-nav-link">
                            401
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-404" class="pe-nav-link">
                            404
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-500" class="pe-nav-link">
                            500
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="auth-offline" class="pe-nav-link">
                            offline page
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseBaseUI" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseBaseUI">
                    <i class="bi bi-feather2 pe-nav-icon"></i>
                    <span class="pe-nav-content">Base UI</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseBaseUI">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Base UI</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-accordions" class="pe-nav-link">Accordions</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-alerts" class="pe-nav-link">Alert</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-avatars" class="pe-nav-link">Avatar</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-badges" class="pe-nav-link">Badge</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-breadcrumbs" class="pe-nav-link">Breadcrumb</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-buttons" class="pe-nav-link">Buttons</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-button-group" class="pe-nav-link">Button Group</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-card" class="pe-nav-link">Cards</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-cookie" class="pe-nav-link">Cookie</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-carousel" class="pe-nav-link">Carousel</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-dropdowns" class="pe-nav-link">Dropdown</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-images-figures" class="pe-nav-link">Images & Figures</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-links" class="pe-nav-link">Links</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-list" class="pe-nav-link">List Group</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-tabs" class="pe-nav-link">Nav & Tabs</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-pagination" class="pe-nav-link">Pagination</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-popover" class="pe-nav-link">Popovers</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-progress" class="pe-nav-link">Progress</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-spinner" class="pe-nav-link">Spinners</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-separator" class="pe-nav-link">Separator</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-modal" class="pe-nav-link">Modal</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-offcanvas" class="pe-nav-link">Off Canvas</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-placeholders" class="pe-nav-link">Placeholders</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-toast" class="pe-nav-link">Toasts</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-tooltips" class="pe-nav-link">Tooltips</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-typography" class="pe-nav-link">Typography</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-utilities" class="pe-nav-link">Utilities</a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseAdvancedUI" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseAdvancedUI">
                    <i class="bi bi-feather pe-nav-icon"></i>
                    <span class="pe-nav-content">Advanced UI</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseAdvancedUI">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Advanced UI</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-block" class="pe-nav-link">Block</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-countup" class="pe-nav-link">Count Up</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-draggable-cards" class="pe-nav-link">Draggable Cards</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-media-player" class="pe-nav-link">Media Player</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-ratings" class="pe-nav-link">Rating</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-ribbons" class="pe-nav-link">Ribbons</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-scrollspy" class="pe-nav-link">Scroll Spy</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-sortable-js" class="pe-nav-link">Sortable JS</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-sweetalert2" class="pe-nav-link">Sweet Alert</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-advance-swiper" class="pe-nav-link">Swiper JS</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-tour" class="pe-nav-link">Tour</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-treeview" class="pe-nav-link">Tree View</a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseFroms" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseFroms">
                    <i class="bi bi-input-cursor-text pe-nav-icon"></i>
                    <span class="pe-nav-content">Forms</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseFroms">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Forms</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-elements" class="pe-nav-link">
                            Input
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-checkboxs-radios" class="pe-nav-link">
                            Checkbox & Radios
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-input-group" class="pe-nav-link">
                            Inout Group
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-select" class="pe-nav-link">
                            Form Select
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-range" class="pe-nav-link">
                            Range Slider
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-input-masks" class="pe-nav-link">
                            Input Masks
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-file-uploads" class="pe-nav-link">
                            File Uploads
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-date-picker" class="pe-nav-link">
                            Date,Time Picker
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-floating-labels" class="pe-nav-link">Floating Label</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-layout" class="pe-nav-link">Form Layout</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-editor" class="pe-nav-link">Editor</a>
                    </li>
                    <li class="pe-slide-item"> 
                        <a href="ui-form-validation" class="pe-nav-link">Form Validation</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-wizards" class="pe-nav-link">Form Wizards</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-form-advanced" class="pe-nav-link">Form Advanced</a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseTables" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseTables">
                    <i class="bi bi-table pe-nav-icon"></i>
                    <span class="pe-nav-content">Tables</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseTables">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Tables</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-tables-basic" class="pe-nav-link">
                            Basic Tables
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-tables-listjs" class="pe-nav-link">
                            List JS Table
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-tables-gridjs" class="pe-nav-link">
                            Grid JS Table
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="ui-tables-datatables" class="pe-nav-link">
                            Datatables
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseCharts" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseCharts">
                    <i class="bi bi-bar-chart pe-nav-icon"></i>
                    <span class="pe-nav-content">Charts</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseCharts">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Charts</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="chart-apex-line" class="pe-nav-link">
                            Apex Charts
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="chart-js-chart" class="pe-nav-link">
                            Chartjs Charts
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="echart-chart" class="pe-nav-link">
                            Echart Charts
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-menu-title">
                Icons & Maps
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseIcons" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseIcons">
                    <i class="bi bi-recycle pe-nav-icon"></i>
                    <span class="pe-nav-content">Icons</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseIcons">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Icons</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="icons-remix" class="pe-nav-link">
                            Remix Icons
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="icons-bootstrap" class="pe-nav-link">
                            Bootstrap Icons
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseMaps" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseMaps">
                    <i class="bi bi-map pe-nav-icon"></i>
                    <span class="pe-nav-content">Maps</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseMaps">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Maps</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="maps-google" class="pe-nav-link">
                            Google Maps
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="maps-leaflet" class="pe-nav-link">
                            Leaflet Maps
                        </a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="maps-vector" class="pe-nav-link">
                            Vector Maps
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pe-menu-title">
                Other
            </li>
            <li class="pe-slide pe-has-sub">
                <a href="#collapseMenuLavels" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseMenuLavels">
                    <i class="bi bi-diagram-3 pe-nav-icon"></i>
                    <span class="pe-nav-content">Menu levels</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseMenuLavels">
                    <li class="slide pe-nav-content1">
                        <a href="javascript:void(0)">Menu levels</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="javascript:void(0)" class="pe-nav-link">
                            Level 1.1
                        </a>
                    </li>
                    <li class="pe-slide pe-has-sub">
                        <a href="#collapseMenuLavels2" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseMenuLavels2">
                            <span class="pe-nav-sub-content">Level 1.2</span>
                            <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                        </a>
                        <ul class="pe-slide-menu collapse" id="collapseMenuLavels2">
                            <li class="slide pe-nav-content1">
                                <a href="javascript:void(0)">Level 1.2</a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="javascript:void(0)" class="pe-nav-link">
                                    Level 2.1
                                </a>
                            </li>
                            <li class="pe-slide-item">
                                <a href="javascript:void(0)" class="pe-nav-link">
                                    Level 2.2
                                </a>
                            </li>
                            <li class="pe-slide pe-has-sub">
                                <a href="#collapseMenuLavels3" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseMenuLavels3">
                                    <span class="pe-nav-sub-content">Level 2.3</span>
                                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                                </a>
                                <ul class="pe-slide-menu collapse" id="collapseMenuLavels3">
                                    <li class="slide pe-nav-content1">
                                        <a href="javascript:void(0)">Level 2.3</a>
                                    </li>
                                    <li class="pe-slide-item">
                                        <a href="javascript:void(0)" class="pe-nav-link">
                                            Level 3.1
                                        </a>
                                    </li>
                                    <li class="pe-slide-item">
                                        <a href="javascript:void(0)" class="pe-nav-link">
                                            Level 3.2
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
