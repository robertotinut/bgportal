@extends('partials.Layouts.master')

@section('title', 'Manajemen Aplikasi | BGPortal Admin')
@section('title-sub', 'Admin')
@section('pagetitle', 'Daftar Aplikasi Central')

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
                <h5 class="card-title mb-0">Daftar Aplikasi Central</h5>
                <a href="{{ route('admin.apps.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Aplikasi Baru
                </a>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.apps.index') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama / kode aplikasi..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">Icon</th>
                                <th>Nama Aplikasi</th>
                                <th>Kode</th>
                                <th>URL App</th>
                                <th>Status</th>
                                <th style="width: 80px;">Urutan</th>
                                <th style="width: 150px;" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($apps as $app)
                                <tr>
                                    <td>
                                        <div class="h-40px w-40px rounded bg-primary-subtle text-primary d-flex align-items-center justify-content-center fs-5">
                                            <i class="{{ $app->icon ?? 'bi bi-app-indicator' }}"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $app->name }}</div>
                                        <small class="text-muted">{{ Str::limit($app->description, 50) }}</small>
                                    </td>
                                    <td><code>{{ $app->code }}</code></td>
                                    <td>
                                        <a href="{{ $app->url }}" target="_blank" class="text-primary text-decoration-none">
                                            {{ $app->url }} <i class="bi bi-box-arrow-up-right fs-12 ms-1"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($app->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $app->sort_order }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.apps.edit', $app->id) }}" class="btn btn-soft-warning btn-sm me-1" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.apps.destroy', $app->id) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aplikasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada aplikasi yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $apps->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
@endsection
