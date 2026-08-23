@extends('partials.Layouts.master')

@section('title', 'Laporan POS | BGPortal App')
@section('title-sub', 'POS Module')
@section('pagetitle', 'Laporan Penjualan POS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i> Ringkasan Penjualan POS Hari Ini</h5>
                <button class="btn btn-outline-primary btn-sm"><i class="bi bi-download me-1"></i> Export Laporan</button>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-primary-subtle text-primary">
                            <span class="d-block text-muted fs-12 mb-1">Total Omset Hari Ini</span>
                            <h4 class="fw-bold mb-0">Rp 4.850.000</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-success-subtle text-success">
                            <span class="d-block text-muted fs-12 mb-1">Total Transaksi</span>
                            <h4 class="fw-bold mb-0">142 Transaksi</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-info-subtle text-info">
                            <span class="d-block text-muted fs-12 mb-1">Rata-rata per Transaksi</span>
                            <h4 class="fw-bold mb-0">Rp 34.154</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded bg-warning-subtle text-warning">
                            <span class="d-block text-muted fs-12 mb-1">Item Terjual</span>
                            <h4 class="fw-bold mb-0">318 Item</h4>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3">Riwayat Transaksi Terakhir:</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No. Nota</th>
                                <th>Waktu</th>
                                <th>Kasir</th>
                                <th>Metode Bayar</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>#POS-0088</code></td>
                                <td>16:45:12</td>
                                <td>Budi Staff</td>
                                <td>QRIS / e-Wallet</td>
                                <td class="fw-semibold">Rp 125.000</td>
                                <td><span class="badge bg-success-subtle text-success border border-success">Selesai</span></td>
                            </tr>
                            <tr>
                                <td><code>#POS-0087</code></td>
                                <td>16:30:05</td>
                                <td>Budi Staff</td>
                                <td>Tunai / Cash</td>
                                <td class="fw-semibold">Rp 55.000</td>
                                <td><span class="badge bg-success-subtle text-success border border-success">Selesai</span></td>
                            </tr>
                            <tr>
                                <td><code>#POS-0086</code></td>
                                <td>16:12:40</td>
                                <td>Admin BGPrime</td>
                                <td>Kartu Debit</td>
                                <td class="fw-semibold">Rp 210.000</td>
                                <td><span class="badge bg-success-subtle text-success border border-success">Selesai</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
@endsection
