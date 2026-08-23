@extends('partials.Layouts.master')

@section('title', 'Beranda Finanza - Pencatat Keuangan | BGPortal')
@section('title-sub', 'Finanza')
@section('pagetitle', 'Beranda Keuangan')

@section('content')
    <style>
        /* Modern Premium Finanza UI Palette (Inspired by High-End Fintech Apps) */
        .finanza-container {
            background-color: #F8FAFC;
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Plus Jakarta Sans', 'Inter', sans-serif;
            padding-bottom: 90px !important;
            color: #0F172A;
        }

        /* Complete Removal of Master Topbar, Breadcrumbs & Sidebars for Finanza */
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

        /* Hero Balance Card - Premium Dark Midnight Obsidian Gradient */
        .card-hero-midnight {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #FFFFFF;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.15);
            position: relative;
            overflow: hidden;
        }

        .card-hero-midnight::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(255,255,255,0) 70%);
            pointer-events: none;
        }

        /* Clean White Cards */
        .card-clean {
            background-color: #FFFFFF;
            border-radius: 20px;
            border: 1px solid #F1F5F9;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-clean:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        }

        .btn-finanza-primary {
            background: linear-gradient(135deg, #4F46E5 0%, #3B82F6 100%);
            color: #FFFFFF;
            border-radius: 25px;
            font-weight: 600;
            padding: 9px 22px;
            border: none;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
        }

        .btn-finanza-primary:hover {
            background: linear-gradient(135deg, #4338CA 0%, #2563EB 100%);
            color: #FFFFFF;
        }

        .history-item {
            background-color: #FFFFFF;
            border-radius: 18px;
            padding: 16px 20px;
            margin-bottom: 12px;
            border: 1px solid #F1F5F9;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .text-income {
            color: #10B981;
            font-weight: 700;
        }

        .text-expense {
            color: #EF4444;
            font-weight: 700;
        }

        .btn-action-delete {
            color: #94A3B8;
            font-size: 16px;
            background: none;
            border: none;
            padding: 0;
            transition: color 0.2s ease;
        }
        .btn-action-delete:hover {
            color: #EF4444;
        }

        /* Bottom Floating Bar */
        .finanza-mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-top: 1px solid #F1F5F9;
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.05);
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
            color: #94A3B8;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            flex: 1;
        }

        .finanza-mobile-bottom-nav .nav-item-link.active {
            color: #4F46E5;
        }

        .finanza-mobile-bottom-nav .nav-item-link i {
            font-size: 20px;
            margin-bottom: 2px;
        }
    </style>

    <div class="finanza-container p-3 p-md-4">
        <div class="container-fluid max-w-700px mx-auto px-0 px-md-3">

            <!-- Clean App Header -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                <div>
                    <h4 class="fw-bold mb-0 text-slate-900">Beranda Keuangan</h4>
                    <span class="fs-12 text-slate-500">Halo, {{ Auth::user()->name }} 👋</span>
                </div>
                <button type="button" class="btn btn-finanza-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                    <i class="bi bi-plus-lg me-1"></i> Catat
                </button>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3 border-0 rounded-4 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Hero Balance Card (Midnight Obsidian Theme) -->
            <div class="card-hero-midnight mb-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fs-13 opacity-75 fw-semibold"><i class="bi bi-wallet2 me-1"></i> Total Saldo Keuangan</span>
                    <span class="badge bg-indigo-500 bg-opacity-25 text-white fs-11 px-3 py-1 rounded-pill border border-white border-opacity-20">Utama</span>
                </div>
                <h2 class="fw-bold mb-3 text-white fs-32">Rp{{ number_format($totalBalance, 0, ',', '.') }}</h2>

                <div class="row g-2 pt-3 border-top border-white border-opacity-15">
                    <div class="col-6">
                        <div class="fs-12 opacity-75 mb-1"><i class="bi bi-arrow-down-left-circle text-emerald-400 me-1"></i> Pemasukan Bulan Ini</div>
                        <div class="fw-bold fs-15 text-emerald-400">+Rp{{ number_format($monthlyIncome, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="fs-12 opacity-75 mb-1"><i class="bi bi-arrow-up-right-circle text-rose-400 me-1"></i> Pengeluaran Bulan Ini</div>
                        <div class="fw-bold fs-15 text-white">-Rp{{ number_format($monthlyExpense, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Wallets / Rekening Grid -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h6 class="fw-bold mb-0 text-slate-800 fs-15">Rekening & Dompet</h6>
                <span class="fs-12 text-slate-500 fw-semibold">{{ $wallets->count() }} Accounts</span>
            </div>

            <div class="row g-3 mb-4">
                @foreach ($wallets as $w)
                    <div class="col-6 col-md-4">
                        <div class="card-clean p-3 h-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-slate-100 text-slate-600 fs-10 fw-bold uppercase px-2 py-1 rounded-2">{{ strtoupper($w->type) }}</span>
                                <i class="bi bi-credit-card-2-front text-slate-400 fs-14"></i>
                            </div>
                            <div class="fw-bold text-slate-800 fs-13 text-truncate mb-1">{{ $w->name }}</div>
                            <div class="fw-bold text-slate-900 fs-15">Rp{{ number_format($w->balance, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Recent Mutasi Transactions List -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h6 class="fw-bold mb-0 text-slate-800 fs-15">Mutasi Transaksi Terbaru</h6>
                <a href="{{ route('apps.finance.budgets') }}" class="fs-12 text-indigo-600 fw-semibold text-decoration-none">Lihat Anggaran Target &rarr;</a>
            </div>

            <div class="mb-5">
                @forelse ($recentTransactions as $t)
                    <div class="history-item d-flex align-items-center justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold mb-0 text-slate-900 fs-14">{{ $t->contributor_name ?? 'Transaksi' }}</h6>
                                <span class="badge {{ $t->type === 'expense' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }} fs-11">
                                    {{ $t->type === 'income' ? 'Pemasukan' : ($t->type === 'expense' ? 'Pengeluaran' : 'Tabungan') }}
                                </span>
                            </div>
                            <div class="fs-12 text-slate-400 mt-1">
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
                                <span class="text-expense fs-14 me-3">-Rp {{ number_format($t->amount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-income fs-14 me-3">+Rp {{ number_format($t->amount, 0, ',', '.') }}</span>
                            @endif

                            <form action="{{ route('apps.finance.transactions.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-delete" title="Hapus">&times;</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="card-clean p-4 text-center text-slate-400">
                        Belum ada transaksi tercatat.
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Mobile Fixed Bottom Navigation Bar (Beranda is Active HERE!) -->
    <div class="finanza-mobile-bottom-nav">
        <a href="{{ route('apps.finance.index') }}" class="nav-item-link active">
            <i class="bi bi-house-door-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="#" class="nav-item-link" onclick="alert('Fitur Checklist/Catatan Keuangan segera hadir!'); return false;">
            <i class="bi bi-sliders"></i>
            <span>Checklist</span>
        </a>
        <a href="{{ route('apps.finance.budgets') }}" class="nav-item-link">
            <i class="bi bi-wallet2"></i>
            <span>Anggaran</span>
        </a>
        <a href="#" class="nav-item-link" data-bs-toggle="modal" data-bs-target="#profileModal">
            <i class="bi bi-person"></i>
            <span>Profil</span>
        </a>
    </div>

    <!-- Modal Catat Transaksi Baru -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.transactions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">+ Catat Transaksi Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Transaksi <span class="text-danger">*</span></label>
                            <select name="type" class="form-select rounded-3" required>
                                <option value="income" selected>📈 Pemasukan (Income)</option>
                                <option value="expense">📉 Pengeluaran (Expense)</option>
                                <option value="savings">💰 Tabungan / Target Anggaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Dompet / Rekening</label>
                            <select name="wallet_id" class="form-select rounded-3">
                                @foreach ($wallets as $w)
                                    <option value="{{ $w->id }}">{{ $w->name }} (Saldo: Rp{{ number_format($w->balance, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Transaksi / Sumber <span class="text-danger">*</span></label>
                            <input type="text" name="contributor_name" class="form-control rounded-3" placeholder="Contoh: Gaji, Belanja Supermarket, Freelance" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal Rp <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control rounded-3" placeholder="Contoh: 500000" min="1000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="transaction_date" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan / Keterangan</label>
                            <input type="text" name="description" class="form-control rounded-3" placeholder="Contoh: Pembelian bulanan">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-finanza-primary rounded-pill px-4">Simpan Transaksi</button>
                    </div>
                </form>
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
                    <div class="avatar-lg rounded-circle bg-indigo-50 text-indigo-600 mx-auto d-flex align-items-center justify-content-center mb-3 fs-1 fw-bold">
                        <i class="bi bi-person"></i>
                    </div>
                    <h5 class="fw-bold text-slate-900 mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-slate-500 fs-14 mb-4">{{ Auth::user()->email }}</p>

                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-lg w-100 rounded-pill fw-bold py-2 mb-2">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Central Hub Apps
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
