@extends('partials.Layouts.master')

@section('title', 'Atur Akses Aplikasi | BGPortal Admin')
@section('title-sub', 'Admin')
@section('pagetitle', 'Kelola Akses Aplikasi User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Atur Akses Aplikasi untuk: <strong>{{ $user->name }}</strong></h5>
                    <small class="text-muted">{{ $user->email }} (Role: <strong>{{ strtoupper($user->role) }}</strong>)</small>
                </div>
                <a href="{{ route('admin.app-access.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if ($user->isAdmin())
                    <div class="alert alert-warning mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> User ini adalah <strong>Administrator</strong>. Administrator secara otomatis dapat mengkases <strong>seluruh aplikasi central</strong> tanpa perlu mencentang opsi di bawah. Opsi di bawah diperuntukkan untuk penyesuaian khusus.
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.app-access.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <h6 class="mb-3 text-uppercase text-muted fs-12 fw-bold">Pilih Aplikasi yang Dapat Diakses:</h6>

                    <div class="list-group mb-4">
                        @forelse ($apps as $app)
                            <label class="list-group-item d-flex align-items-center justify-content-between p-3 {{ in_array($app->id, $userAppIds) ? 'list-group-item-action active-subtle' : '' }}">
                                <div class="d-flex align-items-center gap-3">
                                    <input class="form-check-input flex-shrink-0 mt-0 fs-5" type="checkbox" name="apps[]" value="{{ $app->id }}" {{ in_array($app->id, $userAppIds) ? 'checked' : '' }}>
                                    <div>
                                        <div class="fw-semibold text-dark mb-0">
                                            <i class="{{ $app->icon ?? 'bi bi-app' }} me-2 text-primary"></i> {{ $app->name }}
                                            @if (!$app->is_active)
                                                <span class="badge bg-danger-subtle text-danger ms-2">App Nonaktif</span>
                                            @endif
                                        </div>
                                        <small class="text-muted d-block mt-1">{{ $app->description ?? $app->url }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-light text-dark border">Kode: {{ $app->code }}</span>
                            </label>
                        @empty
                            <div class="alert alert-info mb-0">Belum ada aplikasi central yang dibuat. Silakan buat aplikasi terlebih dahulu di menu Manajemen Aplikasi.</div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fs-13">Centang aplikasi yang diizinkan untuk dibuka oleh user ini.</span>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Akses
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
@endsection
