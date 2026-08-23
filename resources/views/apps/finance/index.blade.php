@extends('partials.Layouts.master')

@section('title', 'Finanza - Anggaran & Catatan Keuangan | BGPortal')
@section('title-sub', 'Finanza')
@section('pagetitle', 'Anggaran & Tabungan')

@section('content')
    <style>
        /* Mobile-first Finanza Clean Theme */
        .finanza-container {
            background-color: #F8F5F0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding-bottom: 90px !important;
        }

        /* Complete Removal of Master Topbar, Breadcrumbs & Sidebars for Mobile/Tablet Finanza */
        nav[aria-label="breadcrumb"],
        div.d-flex.align-items-center.mt-2.mb-2 {
            display: none !important;
        }

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
            }
        }

        .card-cream {
            background-color: #FFFFFF;
            border-radius: 24px;
            border: 1px solid #EFEAE3;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .card-terracotta {
            background: linear-gradient(135deg, #A45834 0%, #8C4325 100%);
            color: #FFFFFF;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 10px 25px rgba(140, 67, 37, 0.25);
        }

        .nav-pill-cream {
            background-color: #EFEAE3;
            border-radius: 30px;
            padding: 5px;
            display: inline-flex;
            width: auto;
            max-width: 100%;
            overflow-x: auto;
        }

        .nav-pill-cream .nav-link {
            border-radius: 25px;
            color: #78716C;
            font-weight: 600;
            padding: 8px 18px;
            font-size: 14px;
            white-space: nowrap;
        }

        .nav-pill-cream .nav-link.active {
            background-color: #FFFFFF;
            color: #1C1917;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .btn-terracotta {
            background-color: #A45834;
            color: #FFFFFF;
            border-radius: 25px;
            font-weight: 600;
            padding: 8px 22px;
            border: none;
        }

        .btn-terracotta:hover {
            background-color: #8C4325;
            color: #FFFFFF;
        }

        .btn-glass-target {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 600;
        }

        .metric-subcard {
            background-color: #FFFFFF;
            border-radius: 16px;
            padding: 14px 16px;
            color: #1C1917;
        }

        .history-item {
            background-color: #FFFFFF;
            border-radius: 20px;
            padding: 16px 20px;
            margin-bottom: 12px;
            border: 1px solid #F3EFEA;
        }

        .text-income-green {
            color: #16A34A;
            font-weight: 700;
        }

        .btn-action-edit {
            color: #A45834;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
            margin-right: 12px;
        }

        .btn-action-delete {
            color: #A8A29E;
            font-size: 16px;
            background: none;
            border: none;
            padding: 0;
        }

        /* Mobile Fixed Bottom Navigation Bar (Matching Screenshot) */
        .finanza-mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: #FFFFFF;
            border-top: 1px solid #EFEAE3;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 0 10px;
        }

        .finanza-mobile-bottom-nav .nav-item-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #A8A29E;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            flex: 1;
        }

        .finanza-mobile-bottom-nav .nav-item-link.active {
            color: #8C4325;
            font-weight: 700;
        }

        .finanza-mobile-bottom-nav .nav-item-link i {
            font-size: 20px;
            margin-bottom: 2px;
        }
    </style>

    <div class="finanza-container p-3 p-md-4">
        <div class="container-fluid max-w-700px mx-auto px-0 px-md-3">

            <!-- Mobile App Top Bar with Back to Central Button -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Central</span>
                </a>
                <h5 class="fw-bold mb-0 text-dark">Anggaran</h5>
                <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#editTargetModal">
                    <i class="bi bi-three-dots"></i>
                </button>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3 border-0 rounded-4 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- 1. Top Donut Summary Card (Matching Screenshot) -->
            <div class="card-cream p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Donut Progress SVG -->
                        <div class="position-relative d-inline-flex align-items-center justify-content-center flex-shrink-0">
                            <svg width="75" height="75" viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg" stroke="#EFEAE3" stroke-width="4" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="circle" stroke="#8C4325" stroke-linecap="round" stroke-dasharray="{{ $percentage }}, 100" stroke-width="4" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
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

            <!-- 2. Navigation Category / Budget Tabs (Matching Screenshot) -->
            <div class="d-flex justify-content-center mb-4 overflow-hidden">
                <ul class="nav nav-pill-cream">
                    @foreach ($budgets as $b)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeBudget->id === $b->id ? 'active' : '' }}" href="{{ route('apps.finance.index', ['budget_id' => $b->id]) }}">
                                {{ $b->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- 3. Terracotta Target Card (Matching Screenshot) -->
            <div class="card-terracotta mb-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <div class="fs-13 opacity-75 mb-1">Dana terkumpul</div>
                        <h2 class="fw-bold mb-0 text-white fs-28">Rp{{ number_format($activeBudget->collected_amount, 0, ',', '.') }}</h2>
                    </div>
                    <button type="button" class="btn btn-glass-target" data-bs-toggle="modal" data-bs-target="#editTargetModal">
                        Atur target
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
                        <div class="metric-subcard">
                            <div class="fs-12 text-muted mb-1">Masih dibutuhkan</div>
                            <div class="fw-bold fs-15 text-dark">Rp {{ number_format($remainingAmount / 1000000, 1) }}jt</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="metric-subcard">
                            <div class="fs-12 text-muted mb-1">Saran per bulan</div>
                            <div class="fw-bold fs-15 text-dark">Rp {{ number_format($monthlySuggestion / 1000000, 1) }}jt</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Riwayat Tabungan Section (Matching Screenshot) -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h5 class="fw-bold mb-0 text-dark">Riwayat tabungan</h5>
                <button type="button" class="btn btn-terracotta shadow-sm" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                    + Catat
                </button>
            </div>

            <!-- Transaction List -->
            <div class="mb-5">
                @forelse ($transactions as $t)
                    <div class="history-item d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-1 text-dark fs-15">{{ $t->contributor_name ?? 'Tabungan' }}</h6>
                            <div class="fs-12 text-muted">
                                {{ $t->transaction_date ? $t->transaction_date->format('j M Y') : '' }} 
                                @if ($t->description)
                                    <span class="ms-1">• {{ $t->description }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <span class="text-income-green fs-14 me-3">+Rp {{ $t->amount >= 1000000 ? number_format($t->amount / 1000000, 1) . 'jt' : number_format($t->amount / 1000, 0) . 'rb' }}</span>
                            
                            <!-- Edit Button -->
                            <button type="button" class="btn-action-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id }}">Edit</button>

                            <!-- Delete Form -->
                            <form action="{{ route('apps.finance.transactions.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pencatatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-delete" title="Hapus">&times;</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Edit Transaction -->
                    <div class="modal fade" id="editModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <form action="{{ route('apps.finance.transactions.update', $t->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Catatan Tabungan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama / Kontributor <span class="text-danger">*</span></label>
                                            <input type="text" name="contributor_name" class="form-control rounded-3" value="{{ $t->contributor_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nominal (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" class="form-control rounded-3" value="{{ $t->amount }}" min="1000" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" name="transaction_date" class="form-control rounded-3" value="{{ $t->transaction_date ? $t->transaction_date->format('Y-m-d') : date('Y-m-d') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Catatan / Keterangan</label>
                                            <input type="text" name="description" class="form-control rounded-3" value="{{ $t->description }}" placeholder="Misal: Gaji, Freelance, Bonus">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-terracotta rounded-pill px-4">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="card-cream p-5 text-center text-muted">
                        <i class="bi bi-wallet2 fs-1 text-secondary mb-2 d-block"></i>
                        Belum ada riwayat tabungan yang dicatat pada target ini.
                        <div class="mt-2">
                            <button type="button" class="btn btn-terracotta btn-sm" data-bs-toggle="modal" data-bs-target="#addTransactionModal">+ Tambah Catatan Tabungan</button>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Mobile Fixed Bottom Navigation Bar (Matching Screenshot: Beranda, Checklist, Anggaran, Profil) -->
    <div class="finanza-mobile-bottom-nav d-flex d-md-none">
        <a href="{{ route('dashboard') }}" class="nav-item-link">
            <i class="bi bi-house-door"></i>
            <span>Beranda</span>
        </a>
        <a href="#" class="nav-item-link" onclick="alert('Fitur Checklist/Catatan Keuangan segera hadir!'); return false;">
            <i class="bi bi-sliders"></i>
            <span>Checklist</span>
        </a>
        <a href="{{ route('apps.finance.index') }}" class="nav-item-link active">
            <i class="bi bi-wallet2"></i>
            <span>Anggaran</span>
        </a>
        <a href="{{ route('dashboard') }}" class="nav-item-link">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <!-- Modal Catat Tabungan Baru -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.transactions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="budget_id" value="{{ $activeBudget->id }}">

                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold" id="addTransactionModalLabel">+ Catat Tabungan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama / Kontributor <span class="text-danger">*</span></label>
                            <input type="text" name="contributor_name" class="form-control rounded-3" placeholder="Contoh: Jessica atau Rudy" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal Tabungan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control rounded-3" placeholder="Contoh: 500000" min="1000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="transaction_date" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan / Keterangan</label>
                            <input type="text" name="description" class="form-control rounded-3" placeholder="Contoh: Gaji, Freelance, Bonus">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-terracotta rounded-pill px-4">Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Atur Target Anggaran -->
    <div class="modal fade" id="editTargetModal" tabindex="-1" aria-labelledby="editTargetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.target.update', $activeBudget->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold" id="editTargetModalLabel">Atur Target Anggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Target Anggaran <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" value="{{ $activeBudget->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Target Rp <span class="text-danger">*</span></label>
                            <input type="number" name="target_amount" class="form-control rounded-3" value="{{ $activeBudget->target_amount }}" min="100000" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-terracotta rounded-pill px-4">Simpan Target</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
