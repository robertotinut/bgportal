@extends('partials.Layouts.master')

@section('title', 'Hak Akses Aplikasi User | BGPortal Admin')
@section('title-sub', 'Admin')
@section('pagetitle', 'Pengaturan Hak Akses Aplikasi')

@section('content')
<div class="row">
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="card-title mb-0">Pengaturan Akses Aplikasi per User</h5>
                <span class="badge bg-info-subtle text-info border border-info px-3 py-2 fs-12">
                    <i class="bi bi-info-circle me-1"></i> User dengan Role <strong>Admin</strong> memiliki akses penuh ke SEMUA aplikasi secara otomatis.
                </span>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.app-access.index') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama / email user..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aplikasi yang Diberikan Akses</th>
                                <th style="width: 120px;" class="text-end">Pengaturan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-xs rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->isAdmin())
                                            <span class="badge bg-danger-subtle text-danger border border-danger">Administrator</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary">Regular User</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->isAdmin())
                                            <span class="badge bg-success-subtle text-success border border-success me-1 mb-1">
                                                <i class="bi bi-shield-check me-1"></i> Semua Aplikasi (Full Access)
                                            </span>
                                        @else
                                            @forelse ($user->apps as $app)
                                                <span class="badge bg-primary-subtle text-primary border border-primary me-1 mb-1">
                                                    <i class="{{ $app->icon ?? 'bi bi-app' }} me-1"></i> {{ $app->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted fs-12 italic">Belum ada akses aplikasi</span>
                                            @endforelse
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.app-access.edit', $user->id) }}" class="btn btn-soft-primary btn-sm">
                                            <i class="bi bi-gear me-1"></i> Atur Akses
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada data user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
@endsection
