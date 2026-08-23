@extends('partials.Layouts.master')

@section('title', 'Status Akun & Langganan | BGPortal')
@section('title-sub', 'Akun')
@section('pagetitle', 'Status Langganan')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">

                <!-- Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Status Akun & Langganan</h4>
                        <p class="text-muted fs-13 mb-0">Informasi status keanggotaan dan paket akses sistem BGPortal</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary rounded-pill px-3.5 py-1.5 btn-sm fw-semibold">
                            <i class="bi bi-person me-1"></i> Edit Profil
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill px-3.5 py-1.5 btn-sm fw-semibold">
                            <i class="bi bi-arrow-left me-1"></i> Central Hub
                        </a>
                    </div>
                </div>

                <!-- Active Plan Card -->
                <div class="card bg-primary text-white rounded-4 border-0 shadow-sm p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge bg-white text-primary fs-12 px-3 py-1.5 rounded-pill fw-bold text-uppercase">
                            {{ $user->isAdmin() ? 'Administrator Enterprise Plan' : 'Active Member Plan' }}
                        </span>
                        <span class="badge bg-success text-white px-3 py-1 rounded-pill fs-12">
                            <i class="bi bi-check-circle-fill me-1"></i> Lifetime Access
                        </span>
                    </div>

                    <h2 class="fw-bold text-white mb-1">
                        {{ $user->isAdmin() ? 'Full System Master Admin' : 'BGPortal Dedicated Member' }}
                    </h2>
                    <p class="opacity-75 fs-14 mb-4">
                        {{ $user->isAdmin() ? 'Akses penuh tanpa batas ke seluruh modul aplikasi, manajemen pengguna, dan pengaturan sistem.' : 'Akun aktif dengan akses ke modul dan aplikasi terpilih di ekosistem BGPortal.' }}
                    </p>

                    <div class="row g-3 pt-3 border-top border-white border-opacity-25">
                        <div class="col-6 col-md-3">
                            <div class="fs-12 opacity-75 mb-1">Status Keanggotaan</div>
                            <div class="fw-bold fs-15 text-white">Aktif (Active)</div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="fs-12 opacity-75 mb-1">Total Modul Aktif</div>
                            <div class="fw-bold fs-15 text-white">{{ $assignedApps->count() }} Aplikasi</div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="fs-12 opacity-75 mb-1">Periode Tagihan</div>
                            <div class="fw-bold fs-15 text-white">Unlimited / Gratis</div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="fs-12 opacity-75 mb-1">Email Terdaftar</div>
                            <div class="fw-bold fs-14 text-white text-truncate">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Hak Akses Modul Detail -->
                <div class="card border shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-check2-square me-2 text-primary"></i> Rincian Hak Akses Modul Anda</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 rounded-start">Nama Aplikasi</th>
                                    <th class="border-0">Kategori</th>
                                    <th class="border-0">Tipe Akses</th>
                                    <th class="border-0 rounded-end text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignedApps as $app)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi {{ $app->icon ?? 'bi-app' }} text-primary fs-5"></i>
                                                <strong class="text-dark">{{ $app->name }}</strong>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-light text-dark fs-11">{{ $app->category ?? 'General' }}</span></td>
                                        <td><span class="badge bg-success-subtle text-success fs-11 fw-bold">Unlimited Access</span></td>
                                        <td class="text-end">
                                            <a href="{{ url($app->route_url ?? '/apps/finance') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fs-12">
                                                Masuk &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
