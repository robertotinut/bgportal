@extends('partials.Layouts.master')

@section('title', 'Log Posting | BGPortal')
@section('title-sub', 'Pinterest Affiliate')
@section('pagetitle', 'Log & Riwayat Posting Affiliate')

@section('content')
    <div id="layout-wrapper">
        <div class="card border shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-journal-text me-1 text-danger"></i> Riwayat Transaksi & Eksekusi Posting</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Akun Pinterest</th>
                                <th>Produk Affiliate</th>
                                <th>Pin ID</th>
                                <th>Status</th>
                                <th>Pesan Response</th>
                                <th>Waktu Diposting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $index => $log)
                                <tr>
                                    <td>{{ $logs->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-semibold text-danger"><i class="bi bi-pinterest me-1"></i> {{ $log->account->account_name ?? 'Akun Terhapus' }}</div>
                                        <small class="text-muted">Board: {{ $log->account->board_name ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-truncate max-w-250px">{{ $log->link->product_title ?? 'Product' }}</div>
                                        <a href="{{ $log->link->affiliate_url ?? '#' }}" target="_blank" class="fs-12 text-muted text-decoration-none"><i class="bi bi-link-45deg me-1"></i> Link Affiliate</a>
                                    </td>
                                    <td>
                                        <code class="fs-12">{{ $log->pin_id ?? '-' }}</code>
                                    </td>
                                    <td>
                                        @if ($log->status === 'success')
                                            <span class="badge bg-success">SUCCESS</span>
                                        @elseif($log->status === 'failed')
                                            <span class="badge bg-danger">FAILED</span>
                                        @else
                                            <span class="badge bg-secondary">{{ strtoupper($log->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fs-13 text-muted">{{ $log->message }}</span>
                                    </td>
                                    <td>
                                        <span class="fs-13">{{ $log->posted_at ? $log->posted_at->format('d M Y H:i:s') : '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                                        Belum ada riwayat posting yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
