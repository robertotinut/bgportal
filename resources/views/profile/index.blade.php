@extends('partials.Layouts.master')

@section('title', 'Profil Saya & Pengaturan Akun | BGPortal')
@section('title-sub', 'Akun')
@section('pagetitle', 'Profil Saya')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">

                <!-- Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Profil & Pengaturan Akun</h4>
                        <p class="text-muted fs-13 mb-0">Kelola identitas, kata sandi, dan status hak akses akun Anda</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill px-3.5 py-1.5 btn-sm fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Central Hub
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                        <ul class="mb-0 ps-3 fs-13">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- User Summary Card -->
                <div class="card border shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex align-items-center gap-4 flex-wrap flex-sm-nowrap">
                        <div class="avatar-xl rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0 fs-1 fw-bold" style="width: 72px; height: 72px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h4 class="fw-bold text-dark mb-0 fs-18">{{ $user->name }}</h4>
                                <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-primary' }} text-uppercase fs-11 px-2.5 py-1 rounded-pill">
                                    {{ $user->isAdmin() ? 'Administrator' : 'Member' }}
                                </span>
                            </div>
                            <p class="text-muted fs-13 mb-2">{{ $user->email }}</p>
                            <div class="d-flex align-items-center gap-3 fs-12 text-muted flex-wrap">
                                <span><i class="bi bi-calendar-check me-1 text-primary"></i> Terdaftar sejak {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</span>
                                <span><i class="bi bi-shield-lock me-1 text-success"></i> Status Akun: <strong class="text-success">Aktif</strong></span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('profile.subscription') }}" class="btn btn-primary rounded-pill btn-sm px-3.5 py-2 fw-semibold text-nowrap">
                                <i class="bi bi-credit-card me-1"></i> Status Langganan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form Edit Profil & Ganti Password -->
                <div class="card border shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square me-2 text-primary"></i> Perbarui Data Profil</h5>

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fs-13 fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fs-13 fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-12 pt-3 border-top mt-4">
                                <h6 class="fw-bold text-dark mb-1"><i class="bi bi-key me-1 text-primary"></i> Ganti Kata Sandi (Opsional)</h6>
                                <p class="text-muted fs-12 mb-3">Kosongkan bagian ini jika Anda tidak ingin mengubah password akun Anda.</p>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label fs-13 fw-semibold">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control rounded-3" placeholder="Masukkan password lama">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fs-13 fw-semibold">Password Baru</label>
                                <input type="password" name="new_password" class="form-control rounded-3" placeholder="Minimal 6 karakter">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label fs-13 fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" class="form-control rounded-3" placeholder="Ulangi password baru">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Aplikasi yang Dapat Diakses -->
                <div class="card border shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-grid-fill me-2 text-primary"></i> Hak Akses Aplikasi Anda</h5>
                    <div class="row g-3">
                        @forelse ($assignedApps as $app)
                            <div class="col-12 col-md-6">
                                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-3 bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                            <i class="bi {{ $app->icon ?? 'bi-app' }} fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-14">{{ $app->name }}</h6>
                                            <span class="badge bg-success-subtle text-success fs-11">Akses Aktif</span>
                                        </div>
                                    </div>
                                    <a href="{{ url($app->route_url ?? '/apps/finance') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Buka &rarr;
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-3">
                                Belum ada aplikasi yang diberikan hak akses untuk akun Anda.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
