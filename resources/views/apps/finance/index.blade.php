@extends('partials.Layouts.master')

@section('title', 'Beranda Finanza - Pencatat Keuangan | BGPortal')
@section('title-sub', 'Finanza')
@section('pagetitle', 'Beranda Keuangan')

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

        .avatar-wallet {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            flex-shrink: 0;
        }

        .scan-dropzone {
            border: 2px dashed #CBD5E1;
            border-radius: 16px;
            background-color: #F8FAFC;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .scan-dropzone:hover {
            border-color: #f06548;
            background-color: #FFF5F3;
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

        /* Mobile Fixed Bottom Navigation Bar (With Center Raised Action Button) */
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

            <!-- Clean Top App Header -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">Beranda Keuangan</h4>
                    <p class="text-muted fs-12 mb-0 d-none d-sm-block">Kelola saldo, dompet, dan mutasi keuangan Anda</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-primary rounded-pill btn-sm px-3 py-1.5 btn-nowrap fw-semibold shadow-sm fs-12" data-bs-toggle="modal" data-bs-target="#scanReceiptModal">
                        <i class="bi bi-camera me-1"></i> Scan Struk AI
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill btn-sm px-3 py-1.5 btn-nowrap fw-semibold shadow-sm fs-12" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                        <i class="bi bi-plus-lg me-1"></i> Catat
                    </button>
                </div>
            </div>

            <!-- 1. Master Total Saldo Card (Fabkin Template Primary Accent) -->
            <div class="card bg-primary text-white rounded-4 border-0 shadow-sm p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fs-13 opacity-75 fw-semibold"><i class="bi bi-wallet2 me-1"></i> Total Saldo Keuangan</span>
                    <span class="badge bg-white text-primary fw-bold fs-11 px-3 py-1 rounded-pill">Aktif</span>
                </div>
                <h2 class="fw-bold mb-3 text-white fs-32">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h2>

                <div class="row g-2 pt-3 border-top border-white border-opacity-25">
                    <div class="col-6">
                        <div class="fs-12 opacity-75 mb-1"><i class="bi bi-arrow-down-left-circle me-1"></i> Pemasukan Bulan Ini</div>
                        <div class="fw-bold fs-16 text-white">+Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="fs-12 opacity-75 mb-1"><i class="bi bi-arrow-up-right-circle me-1"></i> Pengeluaran Bulan Ini</div>
                        <div class="fw-bold fs-16 text-white">-Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- 2. Rekening & Dompet Section (With Full CRUD + Transfer Feature) -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h5 class="fw-bold mb-0 text-dark fs-16">Rekening & Dompet</h5>
                <div class="d-flex align-items-center gap-2">
                    @if ($wallets->count() >= 2)
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 btn-nowrap fw-semibold fs-12" data-bs-toggle="modal" data-bs-target="#transferModal">
                            <i class="bi bi-arrow-left-right me-1"></i> Transfer
                        </button>
                    @endif
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 btn-nowrap fw-semibold fs-12" data-bs-toggle="modal" data-bs-target="#addWalletModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>
            </div>

            <div class="row g-3 mb-4">
                @forelse ($wallets as $w)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card border shadow-sm rounded-4 h-100 p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-wallet 
                                        {{ $w->type === 'cash' ? 'bg-success-subtle text-success' : ($w->type === 'bank' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info') }}">
                                        <i class="bi {{ $w->type === 'cash' ? 'bi-cash-stack' : ($w->type === 'bank' ? 'bi-bank' : 'bi-wallet2') }} fs-5"></i>
                                    </div>
                                    <span class="badge {{ $w->type === 'cash' ? 'bg-success-subtle text-success' : ($w->type === 'bank' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info') }} fs-11 text-uppercase fw-bold">
                                        {{ $w->type }}
                                    </span>
                                </div>

                                <!-- Actions Dropdown for Edit & Delete -->
                                <div class="dropdown">
                                    <button class="btn btn-light action-dot-btn text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                        <li>
                                            <button type="button" class="dropdown-item fs-13" data-bs-toggle="modal" data-bs-target="#editWalletModal{{ $w->id }}">
                                                <i class="bi bi-pencil me-2 text-primary"></i> Edit Rekening
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('apps.finance.wallets.destroy', $w->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus dompet {{ $w->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item fs-13 text-danger">
                                                    <i class="bi bi-trash me-2"></i> Hapus Rekening
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="text-muted fs-13 text-truncate mb-1">{{ $w->name }}</div>
                            <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($w->balance, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <!-- Modal Edit Wallet -->
                    <div class="modal fade" id="editWalletModal{{ $w->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <form action="{{ route('apps.finance.wallets.update', $w->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Rekening / Dompet</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Rekening / Dompet <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control rounded-3" value="{{ $w->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tipe <span class="text-danger">*</span></label>
                                            <select name="type" class="form-select rounded-3" required>
                                                <option value="cash" {{ $w->type === 'cash' ? 'selected' : '' }}>💵 Tunai / Kas</option>
                                                <option value="bank" {{ $w->type === 'bank' ? 'selected' : '' }}>🏦 Rekening Bank</option>
                                                <option value="ewallet" {{ $w->type === 'ewallet' ? 'selected' : '' }}>📱 E-Wallet (GoPay, OVO, ShopeePay)</option>
                                                <option value="investment" {{ $w->type === 'investment' ? 'selected' : '' }}>📈 Investasi / Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Saldo (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" name="balance" class="form-control rounded-3" value="{{ $w->balance }}" min="0" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border shadow-sm rounded-4 p-4 text-center text-muted">
                            Belum ada rekening/dompet. Klik <strong>+ Tambah</strong> untuk membuat.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- 3. Mutasi Transaksi Terbaru -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h5 class="fw-bold mb-0 text-dark fs-16">Mutasi Transaksi Terbaru</h5>
                <a href="{{ route('apps.finance.reports') }}" class="fs-12 text-primary fw-semibold text-decoration-none btn-nowrap">Lihat Laporan Lengkap &rarr;</a>
            </div>

            <div class="mb-5">
                @forelse ($recentTransactions as $t)
                    <div class="card border shadow-sm rounded-4 p-3 mb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h6 class="fw-bold mb-0 text-dark fs-14">{{ $t->contributor_name ?? 'Transaksi' }}</h6>
                                    <span class="badge {{ $t->type === 'expense' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} fs-11">
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

                                <form action="{{ route('apps.finance.transactions.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="confirmDelete(event, this, 'Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-muted p-0 fs-5" title="Hapus">&times;</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card border shadow-sm rounded-4 p-4 text-center text-muted">
                        Belum ada transaksi tercatat.
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- Mobile Fixed Bottom Navigation Bar (With Center Action Button) -->
    <div class="finanza-mobile-bottom-nav">
        <a href="{{ route('apps.finance.index') }}" class="nav-item-link active">
            <i class="bi bi-house-door-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('apps.finance.reports') }}" class="nav-item-link">
            <i class="bi bi-bar-chart"></i>
            <span>Laporan</span>
        </a>

        <!-- Center Raised Action Button (+ / Scan Struk) -->
        <a href="#" class="center-action-btn" data-bs-toggle="modal" data-bs-target="#scanReceiptModal" title="Scan Struk / Catat">
            <i class="bi bi-plus-lg"></i>
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

    <!-- Modal Transfer Antar Rekening -->
    <div class="modal fade" id="transferModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.wallets.transfer') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold"><i class="bi bi-arrow-left-right text-primary me-1"></i> Transfer Antar Rekening</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dari Rekening / Dompet <span class="text-danger">*</span></label>
                            <select name="from_wallet_id" class="form-select rounded-3" required>
                                @foreach ($wallets as $w)
                                    <option value="{{ $w->id }}">{{ $w->name }} (Saldo: Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ke Rekening / Dompet Tujuan <span class="text-danger">*</span></label>
                            <select name="to_wallet_id" class="form-select rounded-3" required>
                                @foreach ($wallets as $idx => $w)
                                    <option value="{{ $w->id }}" {{ $idx === 1 ? 'selected' : '' }}>{{ $w->name }} (Saldo: Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal Transfer Rp <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control rounded-3" placeholder="Contoh: 200000" min="1000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Transfer <span class="text-danger">*</span></label>
                            <input type="date" name="transaction_date" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan</label>
                            <input type="text" name="description" class="form-control rounded-3" placeholder="Contoh: Topup GoPay dari BCA">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Proses Transfer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Catat Transaksi Manual -->
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
                            <select name="type" id="trxType" class="form-select rounded-3" required onchange="toggleTransactionTarget()">
                                <option value="income" selected>📈 Pemasukan (Income)</option>
                                <option value="expense">📉 Pengeluaran (Expense)</option>
                                <option value="savings">💰 Tabungan / Target Anggaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Dompet / Rekening</label>
                            <select name="wallet_id" id="trxWallet" class="form-select rounded-3">
                                @foreach ($wallets as $w)
                                    <option value="{{ $w->id }}">{{ $w->name }} (Saldo: Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="budgetSelectDiv" style="display: none;">
                            <label class="form-label fw-semibold">Masuk ke Target Anggaran</label>
                            <select name="budget_id" class="form-select rounded-3">
                                @foreach ($budgets as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Transaksi / Sumber <span class="text-danger">*</span></label>
                            <input type="text" name="contributor_name" id="trxName" class="form-control rounded-3" placeholder="Contoh: Gaji, Belanja Supermarket, Freelance" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal Rp <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="trxAmount" class="form-control rounded-3" placeholder="Contoh: 500000" min="1000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" name="transaction_date" id="trxDate" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan / Keterangan</label>
                            <input type="text" name="description" id="trxDesc" class="form-control rounded-3" placeholder="Contoh: Pembelian bulanan">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal AI Scan Struk Vision -->
    <div class="modal fade" id="scanReceiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-camera me-1 text-primary"></i> Scan Struk Belanja (AI Vision)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted fs-13 mb-3">Foto atau upload gambar struk belanjaan Anda. AI akan otomatis membaca nominal, tanggal, dan rincian barang.</p>

                    <!-- Dropzone -->
                    <div class="scan-dropzone mb-3" onclick="document.getElementById('receiptImageInput').click();">
                        <input type="file" id="receiptImageInput" accept="image/*" class="d-none" onchange="handleReceiptFile(this)">
                        <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-2 d-block"></i>
                        <span class="fw-semibold text-dark d-block">Klik untuk ambil foto / upload struk</span>
                        <span class="text-muted fs-12">Format JPG, PNG (Maks 5MB)</span>
                    </div>

                    <!-- Loading State -->
                    <div id="scanLoading" class="text-center p-3 d-none">
                        <div class="spinner-border text-primary mb-2" role="status"></div>
                        <p class="fw-semibold text-dark mb-0 fs-13">AI sedang membaca struk Anda...</p>
                    </div>

                    <!-- Scan Result Form -->
                    <div id="scanResultArea" class="d-none">
                        <div class="alert alert-success border-0 rounded-3 p-2 fs-12 mb-3">
                            <i class="bi bi-check-circle-fill me-1"></i> Struk berhasil dianalisis oleh AI! Silakan periksa & simpan.
                        </div>
                        <form action="{{ route('apps.finance.transactions.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="expense">
                            <div class="mb-2">
                                <label class="form-label fs-12 fw-semibold mb-1">Pilih Dompet Pemotongan</label>
                                <select name="wallet_id" class="form-select form-select-sm rounded-3">
                                    @foreach ($wallets as $w)
                                        <option value="{{ $w->id }}">{{ $w->name }} (Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fs-12 fw-semibold mb-1">Nama Toko / Pengeluaran</label>
                                <input type="text" name="contributor_name" id="aiStoreName" class="form-control form-control-sm rounded-3" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fs-12 fw-semibold mb-1">Total Pengeluaran Rp</label>
                                <input type="number" name="amount" id="aiAmount" class="form-control form-control-sm rounded-3" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fs-12 fw-semibold mb-1">Tanggal</label>
                                <input type="date" name="transaction_date" id="aiDate" class="form-control form-control-sm rounded-3" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fs-12 fw-semibold mb-1">Rincian Barang</label>
                                <textarea name="description" id="aiDesc" class="form-control form-control-sm rounded-3" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">
                                Simpan Transaksi dari Struk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Wallet Baru -->
    <div class="modal fade" id="addWalletModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.wallets.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">+ Tambah Rekening / Dompet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Rekening / Dompet <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: BCA Utama, Kas Tunai, GoPay" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tipe <span class="text-danger">*</span></label>
                            <select name="type" class="form-select rounded-3" required>
                                <option value="cash">💵 Tunai / Kas</option>
                                <option value="bank" selected>🏦 Rekening Bank</option>
                                <option value="ewallet">📱 E-Wallet (GoPay, OVO, ShopeePay)</option>
                                <option value="investment">📈 Investasi / Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Saldo Awal Rp <span class="text-danger">*</span></label>
                            <input type="number" name="balance" class="form-control rounded-3" placeholder="Contoh: 1000000" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Tambah Rekening</button>
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
        // SweetAlert Flash Notifications
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
            event.preventDefault();
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

        function toggleTransactionTarget() {
            const type = document.getElementById('trxType').value;
            const budgetDiv = document.getElementById('budgetSelectDiv');
            if (type === 'savings') {
                budgetDiv.style.display = 'block';
            } else {
                budgetDiv.style.display = 'none';
            }
        }

        function handleReceiptFile(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const formData = new FormData();
                formData.append('receipt_image', file);
                formData.append('_token', '{{ csrf_token() }}');

                document.getElementById('scanLoading').classList.remove('d-none');
                document.getElementById('scanResultArea').classList.add('d-none');

                fetch('{{ route("apps.finance.analyzeReceipt") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('scanLoading').classList.add('d-none');
                    if (data.status === 'success' && data.data) {
                        const d = data.data;
                        document.getElementById('aiAmount').value = d.amount || '';
                        document.getElementById('aiDate').value = d.date || '{{ date("Y-m-d") }}';
                        
                        let storeName = 'Belanja';
                        let desc = d.description || '';
                        if (desc.includes('\n')) {
                            const lines = desc.split('\n');
                            storeName = lines[0].replace(/^- /,'').trim();
                        } else if (d.category) {
                            storeName = d.category;
                        }
                        document.getElementById('aiStoreName').value = storeName;
                        document.getElementById('aiDesc').value = desc;

                        document.getElementById('scanResultArea').classList.remove('d-none');

                        Swal.fire({
                            icon: 'success',
                            title: 'Struk Berhasil Dibaca!',
                            text: 'Total: Rp ' + parseInt(d.amount).toLocaleString('id-ID'),
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Gagal Membaca Struk',
                            text: data.message || 'Silakan masukkan rincian secara manual.',
                            confirmButtonColor: '#f06548'
                        });
                    }
                })
                .catch(err => {
                    document.getElementById('scanLoading').classList.add('d-none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Koneksi Gagal',
                        text: 'Gagal menghubungi server untuk analisis struk.',
                        confirmButtonColor: '#f06548'
                    });
                });
            }
        }
    </script>
@endsection
