@extends('partials.Layouts.master')

@section('title', 'POS Kasir | BGPortal App')
@section('title-sub', 'POS Module')
@section('pagetitle', 'Point of Sale (Kasir)')

@section('content')
<div class="row g-3">
    <!-- Products Catalog Column -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><i class="bi bi-shop me-2 text-primary"></i> Katalog Produk Kasir</h5>
                <div class="input-group w-50">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari nama produk / barcode...">
                    <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-search"></i></button>
                </div>
            </div>
            <div class="card-body">
                <!-- Category Badges -->
                <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
                    <button class="btn btn-primary btn-sm px-3 rounded-pill">Semua</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill">Makanan</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill">Minuman</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill">Snack</button>
                    <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill">Paket Combo</button>
                </div>

                <!-- Product Grid Demo -->
                <div class="row g-3">
                    <div class="col-md-4 col-sm-6">
                        <div class="card border shadow-none h-100 hover-shadow transition">
                            <div class="card-body p-3 text-center">
                                <div class="h-60px w-60px mx-auto rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-2 mb-2">
                                    <i class="bi bi-cup-hot"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Kopi Espreso Prime</h6>
                                <p class="text-primary fw-bold mb-2">Rp 25.000</p>
                                <button class="btn btn-soft-primary btn-sm w-100"><i class="bi bi-cart-plus me-1"></i> Tambah</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="card border shadow-none h-100 hover-shadow transition">
                            <div class="card-body p-3 text-center">
                                <div class="h-60px w-60px mx-auto rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center fs-2 mb-2">
                                    <i class="bi bi-cup-straw"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Matcha Ice Latte</h6>
                                <p class="text-primary fw-bold mb-2">Rp 28.000</p>
                                <button class="btn btn-soft-primary btn-sm w-100"><i class="bi bi-cart-plus me-1"></i> Tambah</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="card border shadow-none h-100 hover-shadow transition">
                            <div class="card-body p-3 text-center">
                                <div class="h-60px w-60px mx-auto rounded-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center fs-2 mb-2">
                                    <i class="bi bi-egg-fried"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Nasi Goreng Special</h6>
                                <p class="text-primary fw-bold mb-2">Rp 35.000</p>
                                <button class="btn btn-soft-primary btn-sm w-100"><i class="bi bi-cart-plus me-1"></i> Tambah</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="card border shadow-none h-100 hover-shadow transition">
                            <div class="card-body p-3 text-center">
                                <div class="h-60px w-60px mx-auto rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center fs-2 mb-2">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Snack Combo Basket</h6>
                                <p class="text-primary fw-bold mb-2">Rp 40.000</p>
                                <button class="btn btn-soft-primary btn-sm w-100"><i class="bi bi-cart-plus me-1"></i> Tambah</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="card border shadow-none h-100 hover-shadow transition">
                            <div class="card-body p-3 text-center">
                                <div class="h-60px w-60px mx-auto rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center fs-2 mb-2">
                                    <i class="bi bi-cake"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Red Velvet Cake Slice</h6>
                                <p class="text-primary fw-bold mb-2">Rp 30.000</p>
                                <button class="btn btn-soft-primary btn-sm w-100"><i class="bi bi-cart-plus me-1"></i> Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Summary Column -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><i class="bi bi-receipt me-2"></i> Keranjang Transaksi</h5>
                <span class="badge bg-primary">Order #POS-0089</span>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <div>
                    <div class="table-responsive mb-3">
                        <table class="table table-borderless align-middle table-sm">
                            <thead class="table-light fs-12">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-semibold fs-13">Kopi Espreso Prime</div>
                                        <small class="text-muted">Rp 25.000</small>
                                    </td>
                                    <td class="text-center">2</td>
                                    <td class="text-end fw-semibold">Rp 50.000</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold fs-13">Nasi Goreng Special</div>
                                        <small class="text-muted">Rp 35.000</small>
                                    </td>
                                    <td class="text-center">1</td>
                                    <td class="text-end fw-semibold">Rp 35.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-semibold">Rp 85.000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pajak (11%):</span>
                        <span class="fw-semibold">Rp 9.350</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 fs-5 fw-bold text-primary">
                        <span>Total Bayar:</span>
                        <span>Rp 94.350</span>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success py-2 fw-semibold">
                            <i class="bi bi-credit-card me-1"></i> Bayar Sekarang (Checkout)
                        </button>
                        <button class="btn btn-outline-danger btn-sm">Batalkan Transaksi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
@endsection
