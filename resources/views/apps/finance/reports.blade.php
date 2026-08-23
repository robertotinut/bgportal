@extends('partials.Layouts.master')

@section('title', 'Laporan Keuangan & Mutasi | BGPortal')
@section('title-sub', 'Finanza')
@section('pagetitle', 'Laporan Keuangan')

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

        /* Mobile Fixed Bottom Navigation Bar (With Center Action Button) */
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

            <!-- Clean Top Header -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Laporan & Analitik Keuangan</h4>
                    <p class="text-muted fs-12 mb-0 d-none d-sm-block">Analisis performa cashflow dan riwayat mutasi transaksi</p>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1.5 btn-nowrap fw-semibold fs-12" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Cetak / PDF
                </button>
            </div>

            <!-- Month & Filter Selector Form -->
            <div class="card border shadow-sm rounded-4 p-3 mb-4">
                <form method="GET" action="{{ route('apps.finance.reports') }}" class="row g-2 align-items-center">
                    <div class="col-6 col-md-4">
                        <label class="form-label fs-11 fw-bold text-muted mb-1">PILIH BULAN</label>
                        <input type="month" name="month" class="form-control form-control-sm rounded-3" value="{{ $selectedMonth }}" onchange="this.form.submit()">
                    </div>
                    <div class="col-6 col-md-4">
                        <label class="form-label fs-11 fw-bold text-muted mb-1">DOMPET / REKENING</label>
                        <select name="wallet_id" class="form-select form-select-sm rounded-3" onchange="this.form.submit()">
                            <option value="">Semua Dompet</option>
                            @foreach ($wallets as $w)
                                <option value="{{ $w->id }}" {{ $selectedWalletId == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label fs-11 fw-bold text-muted mb-1">JENIS TRANSAKSI</label>
                        <select name="type" class="form-select form-select-sm rounded-3" onchange="this.form.submit()">
                            <option value="">Semua Jenis (Pemasukan & Pengeluaran)</option>
                            <option value="income" {{ $selectedType == 'income' ? 'selected' : '' }}>Pemasukan Saja</option>
                            <option value="expense" {{ $selectedType == 'expense' ? 'selected' : '' }}>Pengeluaran Saja</option>
                            <option value="savings" {{ $selectedType == 'savings' ? 'selected' : '' }}>Tabungan Saja</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- 1. Key Metric Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card border shadow-sm rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 text-muted fw-semibold">Pemasukan</span>
                            <div class="avatar-xs rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;">
                                <i class="bi bi-arrow-down-left fs-12"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-success mb-0 fs-18">+Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card border shadow-sm rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 text-muted fw-semibold">Pengeluaran</span>
                            <div class="avatar-xs rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;">
                                <i class="bi bi-arrow-up-right fs-12"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-danger mb-0 fs-18">-Rp {{ number_format($totalExpense, 0, ',', '.') }}</h4>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card border shadow-sm rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 text-muted fw-semibold">Net Cashflow</span>
                            <div class="avatar-xs rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;">
                                <i class="bi bi-cash-stack fs-12"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold {{ $netCashflow >= 0 ? 'text-primary' : 'text-danger' }} mb-0 fs-18">
                            {{ $netCashflow >= 0 ? '+' : '' }}Rp {{ number_format($netCashflow, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card border shadow-sm rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 text-muted fw-semibold">Tabungan / Target</span>
                            <div class="avatar-xs rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;">
                                <i class="bi bi-wallet2 fs-12"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark mb-0 fs-18">Rp {{ number_format($totalSavings, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- 2. Visual Perbandingan Rasio & Distribusi Kategori (Clean & Elegant) -->
            <div class="row g-3 mb-4">
                <!-- Rasio Arus Kas -->
                <div class="col-12 col-md-6">
                    <div class="card border shadow-sm rounded-4 p-4 h-100">
                        <h6 class="fw-bold text-dark mb-3">Rasio Pemasukan vs Pengeluaran</h6>
                        @php
                            $grandTotal = $totalIncome + $totalExpense;
                            $incomeRatio = $grandTotal > 0 ? round(($totalIncome / $grandTotal) * 100) : 50;
                            $expenseRatio = $grandTotal > 0 ? round(($totalExpense / $grandTotal) * 100) : 50;
                        @endphp

                        <div class="progress rounded-pill mb-3" style="height: 14px;">
                            <div class="progress-bar bg-success rounded-start-pill" role="progressbar" style="width: {{ $incomeRatio }}%" title="Pemasukan {{ $incomeRatio }}%"></div>
                            <div class="progress-bar bg-danger rounded-end-pill" role="progressbar" style="width: {{ $expenseRatio }}%" title="Pengeluaran {{ $expenseRatio }}%"></div>
                        </div>

                        <div class="d-flex justify-content-between fs-13">
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-circle-fill text-success fs-10"></i>
                                <span class="text-muted">Pemasukan:</span>
                                <strong class="text-success">{{ $incomeRatio }}%</strong>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-circle-fill text-danger fs-10"></i>
                                <span class="text-muted">Pengeluaran:</span>
                                <strong class="text-danger">{{ $expenseRatio }}%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Kategori Pengeluaran -->
                <div class="col-12 col-md-6">
                    <div class="card border shadow-sm rounded-4 p-4 h-100">
                        <h6 class="fw-bold text-dark mb-3">Distribusi Kategori Pengeluaran</h6>
                        @if ($expenseCategories->count() > 0)
                            <div class="d-flex flex-column gap-2">
                                @foreach ($expenseCategories as $cat)
                                    <div>
                                        <div class="d-flex justify-content-between fs-12 mb-1">
                                            <span class="fw-semibold text-dark">{{ $cat['category'] }} ({{ $cat['count'] }}x)</span>
                                            <span class="fw-bold text-danger">Rp {{ number_format($cat['amount'], 0, ',', '.') }} ({{ $cat['percentage'] }}%)</span>
                                        </div>
                                        <div class="progress rounded-pill" style="height: 6px;">
                                            <div class="progress-bar bg-danger rounded-pill" style="width: {{ $cat['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted fs-13 py-3">
                                <i class="bi bi-info-circle me-1"></i> Belum ada pengeluaran pada bulan ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 3. Rincian Mutasi Transaksi -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h5 class="fw-bold mb-0 text-dark fs-16">Rincian Mutasi Transaksi ({{ $transactions->count() }})</h5>
            </div>

            <div class="mb-5">
                @forelse ($transactions as $t)
                    <div class="card border shadow-sm rounded-4 p-3 mb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-dark fs-14">{{ $t->contributor_name ?? 'Transaksi' }}</h6>
                                    <span class="badge {{ $t->type === 'expense' ? 'bg-danger-subtle text-danger' : ($t->type === 'income' ? 'bg-success-subtle text-success' : 'bg-info-subtle text-info') }} fs-11">
                                        {{ $t->type === 'income' ? 'Pemasukan' : ($t->type === 'expense' ? 'Pengeluaran' : 'Tabungan') }}
                                    </span>
                                </div>
                                <div class="fs-12 text-muted mt-1">
                                    {{ $t->transaction_date ? $t->transaction_date->format('j M Y') : '' }}
                                    @if ($t->wallet)
                                        <span class="ms-1">• {{ $t->wallet->name }}</span>
                                    @endif
                                    @if ($t->description)
                                        <span class="ms-1">• {{ $t->description }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                @if ($t->type === 'expense')
                                    <span class="text-danger fw-bold fs-14 me-3 btn-nowrap">-Rp {{ number_format($t->amount, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-success fw-bold fs-14 me-3 btn-nowrap">+Rp {{ number_format($t->amount, 0, ',', '.') }}</span>
                                @endif

                                <form action="{{ route('apps.finance.transactions.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event, this, 'Hapus catatan transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-muted p-0 fs-5" title="Hapus">&times;</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card border shadow-sm rounded-4 p-5 text-center text-muted">
                        <i class="bi bi-journal-x fs-1 text-secondary mb-2 d-block"></i>
                        Tidak ada catatan transaksi pada filter bulan ini.
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
        <a href="{{ route('apps.finance.bills') }}" class="nav-item-link">
            <i class="bi bi-receipt"></i>
            <span>Tagihan</span>
        </a>

        <!-- Center Raised Action Button -->
        <a href="{{ route('apps.finance.index') }}" class="center-action-btn" title="Scan Struk / Catat">
            <i class="bi bi-plus-lg"></i>
        </a>

        <a href="{{ route('apps.finance.budgets') }}" class="nav-item-link">
            <i class="bi bi-wallet2"></i>
            <span>Anggaran</span>
        </a>
        <a href="{{ route('apps.finance.reports') }}" class="nav-item-link active">
            <i class="bi bi-bar-chart-fill"></i>
            <span>Laporan</span>
        </a>
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
    </script>
@endsection
