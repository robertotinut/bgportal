@extends('partials.Layouts.master')

@section('title', 'Central Hub | BGPortal')
@section('title-sub', 'Portal')
@section('pagetitle', 'Central Hub Applications')

@section('content')
    <div class="container-fluid py-3">

        <!-- Welcome Banner & Quick Summary -->
        <div class="card bg-primary text-white rounded-4 border-0 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-white text-primary fw-bold fs-12 px-3 py-1 rounded-pill mb-2">BGPortal Central Hub</span>
                    <h2 class="fw-bold text-white mb-1">Selamat datang, {{ Auth::user()->name }}! 👋</h2>
                    <p class="opacity-75 fs-14 mb-0">Pilih aplikasi yang ingin Anda buka atau kelola hak akses akun Anda di bawah ini.</p>
                </div>
                @if (Auth::user()->isAdmin())
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="{{ route('admin.apps.create') }}" class="btn btn-light rounded-pill px-3.5 py-2 fw-bold text-primary shadow-sm fs-13">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Aplikasi
                        </a>
                        <a href="{{ route('admin.apps.index') }}" class="btn btn-outline-light rounded-pill px-3.5 py-2 fw-semibold fs-13">
                            <i class="bi bi-grid-fill me-1"></i> Kelola Aplikasi
                        </a>
                        <a href="{{ route('admin.app-access.index') }}" class="btn btn-outline-light rounded-pill px-3.5 py-2 fw-semibold fs-13">
                            <i class="bi bi-people-fill me-1"></i> Hak Akses User
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Daftar Aplikasi Central Grid -->
        <div class="d-flex align-items-center justify-content-between mb-3 px-1">
            <h5 class="fw-bold mb-0 text-dark fs-18"><i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i> Aplikasi Tersedia</h5>
            <span class="text-muted fs-13">{{ Auth::user()->accessibleApps()->count() }} aplikasi aktif</span>
        </div>

        <div class="row g-3 mb-5">
            @forelse (Auth::user()->accessibleApps() as $app)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 border shadow-sm rounded-4 hover-shadow transition p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="avatar-lg rounded-3 bg-primary text-white d-flex align-items-center justify-content-center fs-2" style="width: 52px; height: 52px;">
                                    <i class="{{ $app->icon ?? 'bi bi-app-indicator' }}"></i>
                                </div>
                                <span class="badge bg-success-subtle text-success fs-11 px-2.5 py-1 rounded-pill fw-bold">Aktif</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1 fs-16">{{ $app->name }}</h5>
                            <p class="text-muted fs-13 mb-4" style="min-height: 40px;">
                                {{ Str::limit($app->description ?? 'Modul aplikasi terintegrasi BGPortal', 80) }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ $app->url ?? url('/apps/finance') }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold fs-13 d-flex align-items-center justify-content-center gap-2">
                                <span>Buka Aplikasi</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border shadow-sm rounded-4 p-5 text-center text-muted">
                        <i class="bi bi-shield-lock fs-1 text-secondary mb-2 d-block"></i>
                        <h6 class="fw-bold text-dark mb-1">Belum Ada Aplikasi yang Diberikan</h6>
                        <p class="text-muted fs-13 mb-0">Akun Anda belum memiliki akses ke modul aplikasi. Silakan hubungi Administrator sistem.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
@endsection
