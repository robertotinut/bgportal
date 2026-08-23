@extends('partials.Layouts.master')

@section('title', 'Link Affiliate & Queue | BGPortal')
@section('title-sub', 'Pinterest Affiliate')
@section('pagetitle', 'Manajemen Link Affiliate & Antrean Posting')

@section('content')
    <div id="layout-wrapper">
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

        <div class="card border shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-plus-circle me-1 text-danger"></i> Tambah Link Shopee Affiliate Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('apps.pinterest.links.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="shopee_url" class="form-label fw-semibold">URL Produk Shopee Original <span class="text-danger">*</span></label>
                            <input type="url" name="shopee_url" id="shopee_url" class="form-control" placeholder="https://shopee.co.id/product-name-i.1234.5678" required>
                        </div>
                        <div class="col-md-6">
                            <label for="affiliate_url" class="form-label fw-semibold">URL Affiliate Anda <span class="text-danger">*</span></label>
                            <input type="url" name="affiliate_url" id="affiliate_url" class="form-control" placeholder="https://s.shopee.co.id/XXXXXX" required>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-danger fw-bold px-4">
                                <i class="bi bi-magic me-1"></i> Extract Metadata & Simpan ke Antrean
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Links Table -->
        <div class="card border shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-list-stars me-1 text-primary"></i> Daftar Link Dalam Antrean</h5>
                <span class="badge bg-danger-subtle text-danger fw-bold">Filter Kategori Aktif: {{ $settings->target_category }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Produk & Foto</th>
                                <th>Kategori</th>
                                <th>Judul Pin Generated</th>
                                <th>Status Validation</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($links as $index => $link)
                                <tr>
                                    <td>{{ $links->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($link->product_image)
                                                <img src="{{ $link->product_image }}" class="rounded avatar-md object-fit-cover flex-shrink-0" alt="Product">
                                            @else
                                                <div class="avatar-md rounded bg-light d-flex align-items-center justify-content-center flex-shrink-0"><i class="bi bi-image text-muted fs-3"></i></div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1 fs-14 fw-semibold text-truncate max-w-250px">{{ $link->product_title ?? 'Dalam Proses Extract...' }}</h6>
                                                <a href="{{ $link->shopee_url }}" target="_blank" class="fs-12 text-muted text-decoration-none"><i class="bi bi-box-arrow-up-right me-1"></i> Buka Shopee</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $link->category ?? 'Unknown' }}</span>
                                    </td>
                                    <td>
                                        <div class="fs-13 text-truncate max-w-200px">{{ $link->pin_title ?? '-' }}</div>
                                    </td>
                                    <td>
                                        @if ($link->status === 'posted')
                                            <span class="badge bg-success">POSTED</span>
                                            <div class="fs-11 text-muted mt-1">{{ $link->posted_at ? $link->posted_at->format('d M Y H:i') : '' }}</div>
                                        @elseif($link->status === 'skipped')
                                            <span class="badge bg-warning text-dark" title="{{ $link->error_message }}">SKIPPED / DISKIP</span>
                                            <div class="fs-11 text-danger mt-1">Non-Kategori Baju</div>
                                        @elseif($link->status === 'pending')
                                            <span class="badge bg-primary">PENDING</span>
                                        @else
                                            <span class="badge bg-secondary">{{ strtoupper($link->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @if ($link->status === 'pending')
                                                <form action="{{ route('apps.pinterest.links.process', $link->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Post Sekarang">
                                                        <i class="bi bi-send-fill"></i> Post
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('apps.pinterest.links.destroy', $link->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus link ini dari antrean?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-link-45deg fs-1 d-block mb-2 text-secondary"></i>
                                        Belum ada link affiliate dalam antrean. Masukkan URL Shopee di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $links->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
