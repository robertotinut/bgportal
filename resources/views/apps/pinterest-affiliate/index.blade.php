@extends('partials.Layouts.master')

@section('title', 'Pinterest Affiliate AutoPost | BGPortal')
@section('title-sub', 'Pinterest Affiliate')
@section('pagetitle', 'Dashboard & Kontrol Otomasi')

@section('content')
    <div id="layout-wrapper">
        <!-- Notification Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Automation Control Banner -->
        <div class="card {{ $settings->is_running ? 'border-success' : 'border-secondary' }} shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-lg rounded-circle {{ $settings->is_running ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} d-flex align-items-center justify-content-center fs-2 flex-shrink-0">
                            <i class="bi {{ $settings->is_running ? 'bi-play-circle-fill' : 'bi-pause-circle-fill' }}"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h4 class="fw-bold mb-0">Status Sistem Otomasi</h4>
                                <span class="badge {{ $settings->is_running ? 'bg-success' : 'bg-secondary' }} fs-12 px-3 py-1">
                                    {{ $settings->is_running ? 'RUNNING / AKTIF' : 'PAUSED / STOP' }}
                                </span>
                            </div>
                            <p class="text-muted mb-0 mt-1">
                                Jam Mulai: <strong>{{ $settings->start_time }} WIB</strong> | 
                                Interval: <strong>Setiap {{ $settings->interval_minutes }} Menit</strong> | 
                                Filter Kategori Wajib: <span class="badge bg-danger-subtle text-danger fw-bold">{{ $settings->target_category }}</span>
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('apps.pinterest.toggle') }}" method="POST">
                        @csrf
                        @if ($settings->is_running)
                            <button type="submit" class="btn btn-outline-danger btn-lg px-4 fw-bold">
                                <i class="bi bi-stop-circle me-1"></i> STOP OTOMASI
                            </button>
                        @else
                            <button type="submit" class="btn btn-success btn-lg px-4 fw-bold">
                                <i class="bi bi-play-fill me-1"></i> JALANKAN OTOMASI
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted fw-semibold mb-1 fs-13">Akun Pinterest Aktif</p>
                            <h3 class="fw-bold mb-0 text-danger">{{ $activeAccounts }} <span class="fs-14 text-muted fw-normal">/ {{ $totalAccounts }} Total</span></h3>
                        </div>
                        <div class="avatar-md bg-danger-subtle text-danger rounded-3 d-flex align-items-center justify-content-center fs-3">
                            <i class="bi bi-pinterest"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted fw-semibold mb-1 fs-13">Antrean Link Pending</p>
                            <h3 class="fw-bold mb-0 text-primary">{{ $totalPendingLinks }}</h3>
                        </div>
                        <div class="avatar-md bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center fs-3">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted fw-semibold mb-1 fs-13">Pin Berhasil Diposting</p>
                            <h3 class="fw-bold mb-0 text-success">{{ $totalPostedLinks }}</h3>
                        </div>
                        <div class="avatar-md bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center fs-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted fw-semibold mb-1 fs-13">Link Skipped (Non-Baju)</p>
                            <h3 class="fw-bold mb-0 text-warning">{{ $totalSkippedLinks }}</h3>
                        </div>
                        <div class="avatar-md bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center fs-3">
                            <i class="bi bi-shield-slash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Add Affiliate Link & Recent Overview -->
        <div class="row g-4">
            <!-- Left: Add Link Form -->
            <div class="col-lg-5">
                <div class="card h-100 border shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-plus-circle me-1 text-danger"></i> Tambah Link Shopee Affiliate</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('apps.pinterest.links.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="shopee_url" class="form-label fw-semibold">URL Produk Shopee Original <span class="text-danger">*</span></label>
                                <input type="url" name="shopee_url" id="shopee_url" class="form-control" placeholder="https://shopee.co.id/product-name-i.1234.5678" required>
                                <div class="form-text">Masukkan link produk Shopee untuk di-extract foto & judulnya.</div>
                            </div>

                            <div class="mb-4">
                                <label for="affiliate_url" class="form-label fw-semibold">URL Affiliate Anda <span class="text-danger">*</span></label>
                                <input type="url" name="affiliate_url" id="affiliate_url" class="form-control" placeholder="https://s.shopee.co.id/XXXXXX" required>
                                <div class="form-text">Link ini yang akan ditautkan pada Pin Pinterest.</div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 fw-bold py-2">
                                <i class="bi bi-lightning-fill me-1"></i> Extract & Masukkan Antrean
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Recent Links Table -->
            <div class="col-lg-7">
                <div class="card h-100 border shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-list-task me-1 text-primary"></i> Antrean Terbaru</h5>
                        <a href="{{ route('apps.pinterest.links') }}" class="btn btn-sm btn-outline-primary fw-semibold">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentLinks as $link)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($link->product_image)
                                                        <img src="{{ $link->product_image }}" class="rounded avatar-sm object-fit-cover flex-shrink-0" alt="Img">
                                                    @else
                                                        <div class="avatar-sm rounded bg-light d-flex align-items-center justify-content-center flex-shrink-0"><i class="bi bi-image text-muted"></i></div>
                                                    @endif
                                                    <div class="text-truncate max-w-200px">
                                                        <h6 class="mb-0 fs-13 text-truncate">{{ $link->product_title ?? 'Memproses...' }}</h6>
                                                        <small class="text-muted text-truncate d-block">{{ $link->shopee_url }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fs-12 text-muted">{{ $link->category ?? '-' }}</span>
                                            </td>
                                            <td>
                                                @if ($link->status === 'posted')
                                                    <span class="badge bg-success-subtle text-success">Posted</span>
                                                @elseif($link->status === 'skipped')
                                                    <span class="badge bg-warning-subtle text-warning">Skipped</span>
                                                @elseif($link->status === 'pending')
                                                    <span class="badge bg-primary-subtle text-primary">Pending</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($link->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if ($link->status === 'pending')
                                                    <form action="{{ route('apps.pinterest.links.process', $link->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" title="Post Sekarang">
                                                            <i class="bi bi-send-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada link affiliate yang ditambahkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
