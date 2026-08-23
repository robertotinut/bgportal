@extends('partials.Layouts.master')

@section('title', 'Finanza - Target Anggaran & Tabungan | BGPortal')
@section('title-sub', 'Finanza')
@section('pagetitle', 'Target Anggaran')

@section('content')
    <style>
        /* Mobile-first Finanza Clean Integration with Fabkin Master Theme */
        .finanza-container {
            min-height: 100vh;
            padding-bottom: 30px;
        }

        /* Complete Removal of Breadcrumbs on Finanza */
        nav[aria-label="breadcrumb"],
        div.d-flex.align-items-center.mt-2.mb-2 {
            display: none !important;
        }

        .btn-nowrap {
            white-space: nowrap !important;
            flex-shrink: 0;
        }

        .action-dot-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 50%;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            header.app-header,
            #appHeader,
            .app-header,
            .page-title-box,
            .pe-app-sidebar, 
            .pe-sidebar-overlay,
            footer.footer,
            .footer {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }

            .app-wrapper,
            main.app-wrapper,
            #layout-wrapper,
            .main-content {
                margin: 0 !important;
                padding-top: 0 !important;
                margin-top: 0 !important;
            }

            .container-fluid {
                padding-left: 0 !important;
                padding-right: 0 !important;
                padding-top: 0 !important;
            }

            .finanza-container {
                padding-top: 15px !important;
                padding-bottom: 90px !important;
            }

            .finanza-mobile-bottom-nav {
                display: flex !important;
            }
        }

        @media (min-width: 992px) {
            .finanza-mobile-bottom-nav {
                display: none !important;
            }
            .finanza-container {
                padding-bottom: 30px !important;
            }
        }

        .nav-pill-fabkin {
            background-color: #E9ECEF;
            border-radius: 30px;
            padding: 5px;
            display: inline-flex;
            width: auto;
            max-width: 100%;
            overflow-x: auto;
            white-space: nowrap;
        }

        .nav-pill-fabkin .nav-link {
            border-radius: 25px;
            color: #495057;
            font-weight: 600;
            padding: 8px 18px;
            font-size: 14px;
            white-space: nowrap;
        }

        .nav-pill-fabkin .nav-link.active {
            background-color: #f06548;
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(240, 101, 72, 0.25);
        }

        /* Mobile Fixed Bottom Navigation Bar */
        .finanza-mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-top: 1px solid #E5E7EB;
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.05);
            z-index: 1030;
            display: none;
            align-items: center;
            justify-content: space-around;
            padding: 0 10px;
        }

        .finanza-mobile-bottom-nav .nav-item-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #6C757D;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            flex: 1;
        }

        .finanza-mobile-bottom-nav .nav-item-link.active {
            color: #f06548;
            font-weight: 700;
        }

        .finanza-mobile-bottom-nav .nav-item-link i {
            font-size: 20px;
            margin-bottom: 2px;
        }

        .center-action-btn {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #f06548 0%, #d94f33 100%);
            color: #FFFFFF !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 18px rgba(240, 101, 72, 0.4);
            margin-top: -24px;
            border: 3px solid #FFFFFF;
            transition: transform 0.2s ease;
        }
        .center-action-btn:hover {
            transform: scale(1.08);
        }
        .center-action-btn i {
            font-size: 22px !important;
            margin-bottom: 0 !important;
        }
    </style>

    <div class="finanza-container p-2 p-md-3">
        <div class="container-fluid max-w-1000px mx-auto px-0 px-md-3">

            <!-- Clean App Header -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Target Anggaran</h4>
                    <p class="text-muted fs-12 mb-0 d-none d-sm-block">Pantau pencapaian target tabungan impian Anda</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1.5 btn-nowrap fw-semibold fs-12" data-bs-toggle="modal" data-bs-target="#newBudgetModal">
                        <i class="bi bi-plus-lg me-1"></i> Target Baru
                    </button>
                    
                    <!-- Actions Dropdown for Active Budget -->
                    <div class="dropdown">
                        <button class="btn btn-light action-dot-btn text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                            <li>
                                <button type="button" class="dropdown-item fs-13" data-bs-toggle="modal" data-bs-target="#editTargetModal">
                                    <i class="bi bi-pencil me-2 text-primary"></i> Edit Target Anggaran
                                </button>
                            </li>
                            @if ($budgets->count() > 1)
                                <li>
                                    <form action="{{ route('apps.finance.target.destroy', $activeBudget->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus target anggaran {{ $activeBudget->name }} beserta seluruh riwayatnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item fs-13 text-danger">
                                            <i class="bi bi-trash me-2"></i> Hapus Target Anggaran
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 1. Top Donut Summary Card -->
            <div class="card border shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative d-inline-flex align-items-center justify-content-center flex-shrink-0">
                            <svg width="75" height="75" viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg" stroke="#E9ECEF" stroke-width="4" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="circle" stroke="#f06548" stroke-linecap="round" stroke-dasharray="{{ $percentage }}, 100" stroke-width="4" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <span class="position-absolute fs-13 fw-bold text-dark">{{ $percentage }}%</span>
                        </div>

                        <div>
                            <h3 class="fw-bold mb-1 text-dark fs-20">
                                Rp {{ number_format($activeBudget->collected_amount, 0, ',', '.') }}
                            </h3>
                            <p class="text-muted fs-13 mb-1">
                                realisasi dari <strong>Rp {{ number_format($activeBudget->target_amount, 0, ',', '.') }}</strong>
                            </p>
                            <div class="d-flex align-items-center gap-2 fs-12 text-muted flex-wrap">
                                <span><i class="bi bi-circle-fill text-warning me-1 fs-10"></i> Est. Rp {{ number_format($activeBudget->target_amount * 0.65 / 1000000, 1) }}jt</span>
                                <span><i class="bi bi-circle-fill text-success me-1 fs-10"></i> Sisa Rp {{ number_format($remainingAmount / 1000000, 1) }}jt</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Navigation Category / Budget Tabs (Horizontal Scroll) -->
            <div class="d-flex justify-content-start mb-4 overflow-auto pb-1">
                <ul class="nav nav-pill-fabkin">
                    @foreach ($budgets as $b)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeBudget->id === $b->id ? 'active' : '' }}" href="{{ route('apps.finance.budgets', ['budget_id' => $b->id]) }}">
                                {{ $b->name }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link text-primary fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#newBudgetModal">
                            + Target Baru
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 3. Target Fabkin Primary Card -->
            <div class="card bg-primary text-white rounded-4 border-0 shadow-sm p-4 mb-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <div class="fs-13 opacity-75 mb-1">Dana terkumpul (Net)</div>
                        <h2 class="fw-bold mb-0 text-white fs-28">Rp {{ number_format($activeBudget->collected_amount, 0, ',', '.') }}</h2>
                    </div>
                    <button type="button" class="btn btn-outline-light btn-sm rounded-pill fw-semibold btn-nowrap" data-bs-toggle="modal" data-bs-target="#editTargetModal">
                        <i class="bi bi-pencil me-1"></i> Atur Target
                    </button>
                </div>

                <!-- Progress Bar -->
                <div class="mb-3">
                    <div class="progress bg-white bg-opacity-25 rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-white rounded-pill" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between fs-12 opacity-90 mt-2">
                        <span><strong>{{ $percentage }}%</strong> terkumpul</span>
                        <span>Target <strong>Rp {{ number_format($activeBudget->target_amount / 1000000, 1) }}jt</strong></span>
                    </div>
                </div>

                <!-- Two Bottom Metric Cards -->
                <div class="row g-3">
                    <div class="col-6">
                        <div class="bg-white text-dark rounded-3 p-3">
                            <div class="fs-12 text-muted mb-1">Masih dibutuhkan</div>
                            <div class="fw-bold fs-15 text-dark">Rp {{ number_format($remainingAmount / 1000000, 1) }}jt</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white text-dark rounded-3 p-3">
                            <div class="fs-12 text-muted mb-1">Saran per bulan</div>
                            <div class="fw-bold fs-15 text-dark">Rp {{ number_format($monthlySuggestion / 1000000, 1) }}jt</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Riwayat Tabungan Target Section -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h5 class="fw-bold mb-0 text-dark fs-16">Riwayat Tabungan</h5>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 py-1 btn-nowrap fw-semibold fs-12 shadow-sm" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                    <i class="bi bi-plus-lg me-1"></i> Catat
                </button>
            </div>

            <div class="mb-5">
                @forelse ($transactions as $t)
                    <div class="card border shadow-sm rounded-4 p-3 mb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark fs-14">{{ $t->contributor_name ?? 'Tabungan' }}</h6>
                                <div class="fs-12 text-muted">
                                    {{ $t->transaction_date ? $t->transaction_date->format('j M Y') : '' }} 
                                    @if ($t->description)
                                        <span class="ms-1">• {{ $t->description }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <span class="text-success fw-bold fs-14 me-3 btn-nowrap">+Rp {{ $t->amount >= 1000000 ? number_format($t->amount / 1000000, 1) . 'jt' : number_format($t->amount / 1000, 0) . 'rb' }}</span>
                                
                                <form action="{{ route('apps.finance.transactions.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event, this, 'Hapus transaksi tabungan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-muted p-0 fs-5" title="Hapus">&times;</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card border shadow-sm rounded-4 p-4 text-center text-muted">
                        <i class="bi bi-wallet2 fs-1 text-secondary mb-2 d-block"></i>
                        Belum ada riwayat tabungan pada target ini.
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addTransactionModal">+ Catat Tabungan</button>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Mobile Fixed Bottom Navigation Bar (With Center Action Button) -->
    <div class="finanza-mobile-bottom-nav">
        <a href="{{ route('apps.finance.index') }}" class="nav-item-link">
            <i class="bi bi-house-door"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('apps.finance.reports') }}" class="nav-item-link">
            <i class="bi bi-bar-chart"></i>
            <span>Laporan</span>
        </a>

        <!-- Center Raised Action Button (+ / Scan Struk) -->
        <a href="{{ route('apps.finance.index') }}" class="center-action-btn" title="Scan Struk / Catat">
            <i class="bi bi-plus-lg"></i>
        </a>

        <a href="{{ route('apps.finance.budgets') }}" class="nav-item-link active">
            <i class="bi bi-wallet2"></i>
            <span>Anggaran</span>
        </a>
        <a href="#" class="nav-item-link" data-bs-toggle="modal" data-bs-target="#profileModal">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <!-- Modal Catat Tabungan -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.transactions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="budget_id" value="{{ $activeBudget->id }}">
                    <input type="hidden" name="type" value="savings">

                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">+ Catat Tabungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama / Kontributor <span class="text-danger">*</span></label>
                            <input type="text" name="contributor_name" class="form-control rounded-3" placeholder="Contoh: Jessica, Rudy" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal Tabungan Rp <span class="text-danger">*</span></label>
                            <input type="text" name="amount" class="form-control rounded-3 rupiah-input" placeholder="Contoh: 500.000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="transaction_date" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan / Keterangan</label>
                            <input type="text" name="description" class="form-control rounded-3" placeholder="Contoh: Setoran Bulanan">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Tabungan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Target Anggaran Baru -->
    <div class="modal fade" id="newBudgetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.budgets.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">+ Tambah Target Anggaran Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Target Anggaran <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: Tabungan Rumah, Dana Darurat" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Target Rp <span class="text-danger">*</span></label>
                            <input type="text" name="target_amount" class="form-control rounded-3 rupiah-input" placeholder="Contoh: 50.000.000" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Buat Target</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit / Atur Target Active -->
    <div class="modal fade" id="editTargetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.target.update', $activeBudget->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">Edit Target Anggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Target Anggaran <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" value="{{ $activeBudget->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Target Rp <span class="text-danger">*</span></label>
                            <input type="text" name="target_amount" class="form-control rounded-3 rupiah-input" value="{{ number_format($activeBudget->target_amount, 0, ',', '.') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 d-flex justify-content-between">
                        @if ($budgets->count() > 1)
                            <button type="button" class="btn btn-outline-danger rounded-pill px-3" onclick="confirmDelete(event, document.getElementById('deleteTargetForm'), 'Hapus target anggaran ini beserta seluruh riwayatnya?')">
                                <i class="bi bi-trash me-1"></i> Hapus Target
                            </button>
                        @else
                            <div></div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Target</button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Delete Form -->
                @if ($budgets->count() > 1)
                    <form id="deleteTargetForm" action="{{ route('apps.finance.target.destroy', $activeBudget->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Profile & Kembali ke Central -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Profil Akun & Central Portal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="avatar-lg rounded-circle bg-primary-subtle text-primary mx-auto d-flex align-items-center justify-content-center mb-3 fs-1 fw-bold">
                        <i class="bi bi-person"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted fs-14 mb-4">{{ Auth::user()->email }}</p>

                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-lg w-100 rounded-pill fw-bold py-2 mb-2">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Central Hub Apps
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#f06548'
            });
        @endif

        function confirmDelete(event, form, message = 'Data yang dihapus tidak dapat dikembalikan!') {
            if (event) event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f06548',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Live Rupiah Currency Masking
        function formatRupiah(number) {
            return number.toString().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        document.querySelectorAll('.rupiah-input').forEach(function(input) {
            input.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                if (value) {
                    this.value = formatRupiah(value);
                } else {
                    this.value = '';
                }
            });
        });

        // Strip non-numeric before submit
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                form.querySelectorAll('.rupiah-input').forEach(function(input) {
                    input.value = input.value.replace(/\D/g, '');
                });
            });
        });
    </script>
@endsection
