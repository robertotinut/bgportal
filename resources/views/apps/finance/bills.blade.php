@extends('partials.Layouts.master')

@section('title', 'Tagihan & Langganan Rutin | BGPortal')
@section('title-sub', 'Finanza')
@section('pagetitle', 'Tagihan & Langganan')

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

        .avatar-bill {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
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
                    <h4 class="fw-bold mb-0 text-dark">Tagihan & Langganan</h4>
                    <p class="text-muted fs-12 mb-0 d-none d-sm-block">Kelola dan bayar tagihan bulanan tepat waktu</p>
                </div>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 btn-nowrap fw-semibold fs-12 shadow-sm" data-bs-toggle="modal" data-bs-target="#addBillModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Tagihan
                </button>
            </div>

            <!-- 1. Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-4">
                    <div class="card border shadow-sm rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 text-muted fw-semibold">Belum Dibayar</span>
                            <div class="avatar-xs rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;">
                                <i class="bi bi-clock-history fs-12"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-danger mb-0 fs-18">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</h4>
                        <div class="fs-11 text-muted mt-1">{{ $unpaidBills->count() }} tagihan menanti</div>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div class="card border shadow-sm rounded-4 p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 text-muted fw-semibold">Sudah Lunas</span>
                            <div class="avatar-xs rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;">
                                <i class="bi bi-check-circle-fill fs-12"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-success mb-0 fs-18">Rp {{ number_format($totalPaid, 0, ',', '.') }}</h4>
                        <div class="fs-11 text-muted mt-1">{{ $paidBills->count() }} tagihan terbayar</div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card border shadow-sm rounded-4 p-3 h-100 bg-primary text-white border-0">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fs-12 opacity-75 fw-semibold">Total Tagihan Rutin</span>
                            <i class="bi bi-receipt fs-16"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-0 fs-18">Rp {{ number_format($totalUnpaid + $totalPaid, 0, ',', '.') }}</h4>
                        <div class="fs-11 opacity-75 mt-1">{{ $bills->count() }} total daftar langganan</div>
                    </div>
                </div>
            </div>

            <!-- 2. Tagihan Belum Dibayar (Unpaid List) -->
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <h5 class="fw-bold mb-0 text-dark fs-16">
                    <i class="bi bi-exclamation-circle-fill text-danger me-1"></i> Tagihan Belum Dibayar ({{ $unpaidBills->count() }})
                </h5>
            </div>

            <div class="row g-3 mb-4">
                @forelse ($unpaidBills as $bill)
                    <div class="col-12 col-md-6">
                        <div class="card border shadow-sm rounded-4 p-3 h-100 position-relative">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-bill 
                                        @if(stripos($bill->category, 'Listrik') !== false) bg-warning-subtle text-warning
                                        @elseif(stripos($bill->category, 'Internet') !== false) bg-info-subtle text-info
                                        @elseif(stripos($bill->category, 'Asuransi') !== false) bg-success-subtle text-success
                                        @else bg-primary-subtle text-primary @endif">
                                        <i class="bi 
                                            @if(stripos($bill->category, 'Listrik') !== false) bi-lightning-charge-fill
                                            @elseif(stripos($bill->category, 'Internet') !== false) bi-wifi
                                            @elseif(stripos($bill->category, 'Asuransi') !== false) bi-shield-check
                                            @else bi-receipt @endif fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0 fs-15">{{ $bill->name }}</h6>
                                        <div class="fs-12 text-muted mt-0.5">
                                            <i class="bi bi-calendar-event me-1"></i> Jatuh tempo tgl <strong>{{ $bill->due_day }}</strong> setiap bulan
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-light action-dot-btn text-muted" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3">
                                        <li>
                                            <button type="button" class="dropdown-item fs-13" data-bs-toggle="modal" data-bs-target="#editBillModal{{ $bill->id }}">
                                                <i class="bi bi-pencil me-2 text-primary"></i> Edit Tagihan
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('apps.finance.bills.destroy', $bill->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus tagihan {{ $bill->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item fs-13 text-danger">
                                                    <i class="bi bi-trash me-2"></i> Hapus Tagihan
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-2">
                                <div>
                                    <span class="fs-11 text-muted d-block">Nominal Tagihan</span>
                                    <span class="fw-bold text-danger fs-16">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 py-1.5 fw-semibold fs-12" data-bs-toggle="modal" data-bs-target="#payBillModal{{ $bill->id }}">
                                    <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Bayar Tagihan -->
                    <div class="modal fade" id="payBillModal{{ $bill->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <form action="{{ route('apps.finance.bills.pay', $bill->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Konfirmasi Pembayaran Tagihan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 text-center">
                                        <div class="avatar-lg rounded-circle bg-primary-subtle text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                                            <i class="bi bi-receipt fs-2"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">{{ $bill->name }}</h5>
                                        <h3 class="fw-bold text-danger mb-3">Rp {{ number_format($bill->amount, 0, ',', '.') }}</h3>

                                        <div class="text-start mb-3">
                                            <label class="form-label fw-semibold fs-13">Pilih Rekening / Dompet Pemotong <span class="text-danger">*</span></label>
                                            <select name="wallet_id" class="form-select rounded-3" required>
                                                @foreach ($wallets as $w)
                                                    <option value="{{ $w->id }}">{{ $w->name }} (Saldo: Rp {{ number_format($w->balance, 0, ',', '.') }})</option>
                                                @endforeach
                                            </select>
                                            <div class="fs-11 text-muted mt-1">
                                                <i class="bi bi-info-circle me-1"></i> Saldo dompet akan otomatis terpotong dan tercatat di mutasi pengeluaran.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Konfirmasi & Bayar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Tagihan -->
                    <div class="modal fade" id="editBillModal{{ $bill->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <form action="{{ route('apps.finance.bills.update', $bill->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold">Edit Tagihan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Tagihan <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control rounded-3" value="{{ $bill->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                            <select name="category" class="form-select rounded-3" required>
                                                <option value="Listrik" {{ $bill->category == 'Listrik' ? 'selected' : '' }}>⚡ Listrik PLN</option>
                                                <option value="Internet" {{ $bill->category == 'Internet' ? 'selected' : '' }}>🌐 Internet & WiFi</option>
                                                <option value="Air" {{ $bill->category == 'Air' ? 'selected' : '' }}>💧 Air PDAM</option>
                                                <option value="Asuransi" {{ $bill->category == 'Asuransi' ? 'selected' : '' }}>🏥 BPJS & Asuransi</option>
                                                <option value="Sewa" {{ $bill->category == 'Sewa' ? 'selected' : '' }}>🏠 Sewa Rumah / Kos</option>
                                                <option value="Cicilan" {{ $bill->category == 'Cicilan' ? 'selected' : '' }}>💳 Cicilan & Hutang</option>
                                                <option value="Hiburan" {{ $bill->category == 'Hiburan' ? 'selected' : '' }}>🎬 Langganan Streaming</option>
                                                <option value="Lainnya" {{ $bill->category == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nominal Tagihan Rp <span class="text-danger">*</span></label>
                                            <input type="text" name="amount" class="form-control rounded-3 rupiah-input" value="{{ number_format($bill->amount, 0, ',', '.') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal Jatuh Tempo (Setiap Bulan) <span class="text-danger">*</span></label>
                                            <input type="number" name="due_day" class="form-control rounded-3" value="{{ $bill->due_day }}" min="1" max="31" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status Pembayaran</label>
                                            <select name="status" class="form-select rounded-3">
                                                <option value="unpaid" {{ $bill->status == 'unpaid' ? 'selected' : '' }}>❌ Belum Dibayar</option>
                                                <option value="paid" {{ $bill->status == 'paid' ? 'selected' : '' }}>✅ Sudah Lunas</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Catatan</label>
                                            <input type="text" name="notes" class="form-control rounded-3" value="{{ $bill->notes }}">
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
                            <i class="bi bi-check-circle-fill fs-1 text-success mb-2 d-block"></i>
                            Hebat! Semua tagihan bulan ini sudah lunas atau belum ada tagihan terdaftar.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- 3. Tagihan Sudah Lunas (Paid List) -->
            @if ($paidBills->count() > 0)
                <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                    <h5 class="fw-bold mb-0 text-dark fs-16">
                        <i class="bi bi-check-circle-fill text-success me-1"></i> Riwayat Tagihan Lunas ({{ $paidBills->count() }})
                    </h5>
                </div>

                <div class="row g-3 mb-5">
                    @foreach ($paidBills as $bill)
                        <div class="col-12 col-md-6">
                            <div class="card border shadow-sm rounded-4 p-3 bg-light bg-opacity-50">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-bill bg-success-subtle text-success">
                                            <i class="bi bi-check-lg fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-14">{{ $bill->name }}</h6>
                                            <div class="fs-12 text-muted">
                                                Lunas 
                                                @if ($bill->last_paid_at)
                                                    pada {{ $bill->last_paid_at->format('j M Y') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <span class="badge bg-success-subtle text-success fs-11 fw-bold">LUNAS</span>
                                        <div class="fw-bold text-dark fs-14 mt-1">Rp {{ number_format($bill->amount, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <!-- Modal Tambah Tagihan Baru -->
    <div class="modal fade" id="addBillModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form action="{{ route('apps.finance.bills.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">+ Tambah Tagihan / Langganan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Tagihan / Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: Netflix Premium, Listrik PLN" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="category" class="form-select rounded-3" required>
                                <option value="Listrik">⚡ Listrik PLN</option>
                                <option value="Internet" selected>🌐 Internet & WiFi</option>
                                <option value="Air">💧 Air PDAM</option>
                                <option value="Asuransi">🏥 BPJS & Asuransi</option>
                                <option value="Sewa">🏠 Sewa Rumah / Kos</option>
                                <option value="Cicilan">💳 Cicilan & Hutang</option>
                                <option value="Hiburan">🎬 Langganan Streaming</option>
                                <option value="Lainnya">📦 Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal Tagihan Rp <span class="text-danger">*</span></label>
                            <input type="text" name="amount" class="form-control rounded-3 rupiah-input" placeholder="Contoh: 350.000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Jatuh Tempo (Setiap Bulan) <span class="text-danger">*</span></label>
                            <input type="number" name="due_day" class="form-control rounded-3" placeholder="Contoh: 15 (setiap tgl 15)" min="1" max="31" value="15" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan</label>
                            <input type="text" name="notes" class="form-control rounded-3" placeholder="Contoh: ID Pelanggan: 12345678">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Tagihan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Fixed Bottom Navigation Bar (With Center Action Button) -->
    <div class="finanza-mobile-bottom-nav">
        <a href="{{ route('apps.finance.index') }}" class="nav-item-link">
            <i class="bi bi-house-door"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('apps.finance.bills') }}" class="nav-item-link active">
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
        <a href="{{ route('apps.finance.reports') }}" class="nav-item-link">
            <i class="bi bi-bar-chart"></i>
            <span>Laporan</span>
        </a>
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
