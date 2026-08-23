@extends('partials.Layouts.master')

@section('title', 'Produk POS | BGPortal App')
@section('title-sub', 'POS Module')
@section('pagetitle', 'Manajemen Produk POS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><i class="bi bi-box-seam me-2 text-primary"></i> Daftar Produk POS</h5>
                <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga Jual</th>
                                <th>Stok POS</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-semibold">Kopi Espreso Prime</div>
                                    <small class="text-muted">SKU: POS-BEV-001</small>
                                </td>
                                <td><span class="badge bg-secondary-subtle text-secondary">Minuman</span></td>
                                <td class="fw-semibold">Rp 25.000</td>
                                <td><span class="badge bg-success-subtle text-success">150 Pcs</span></td>
                                <td><span class="badge bg-success-subtle text-success">Aktif</span></td>
                                <td class="text-end">
                                    <button class="btn btn-soft-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="fw-semibold">Matcha Ice Latte</div>
                                    <small class="text-muted">SKU: POS-BEV-002</small>
                                </td>
                                <td><span class="badge bg-secondary-subtle text-secondary">Minuman</span></td>
                                <td class="fw-semibold">Rp 28.000</td>
                                <td><span class="badge bg-success-subtle text-success">85 Pcs</span></td>
                                <td><span class="badge bg-success-subtle text-success">Aktif</span></td>
                                <td class="text-end">
                                    <button class="btn btn-soft-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="fw-semibold">Nasi Goreng Special</div>
                                    <small class="text-muted">SKU: POS-FOOD-001</small>
                                </td>
                                <td><span class="badge bg-secondary-subtle text-secondary">Makanan</span></td>
                                <td class="fw-semibold">Rp 35.000</td>
                                <td><span class="badge bg-success-subtle text-success">40 Pcs</span></td>
                                <td><span class="badge bg-success-subtle text-success">Aktif</span></td>
                                <td class="text-end">
                                    <button class="btn btn-soft-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                </td>
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
