@extends('partials.Layouts.master')

@section('title', 'Akun Pinterest | BGPortal')
@section('title-sub', 'Pinterest Affiliate')
@section('pagetitle', 'Manajemen Akun Pinterest (Multi-Account)')

@section('content')
    <div id="layout-wrapper">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-person-badge me-1 text-danger"></i> Daftar Akun Pinterest Terhubung</h5>
                <button type="button" class="btn btn-danger btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Akun Baru
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Akun</th>
                                <th>Username / Profile</th>
                                <th>Board Target ID</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($accounts as $index => $acc)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center fw-bold">
                                                <i class="bi bi-pinterest"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fs-14 fw-semibold">{{ $acc->account_name }}</h6>
                                                <small class="text-muted">ID: {{ $acc->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>@ {{ $acc->username ?? 'pinterest_user' }}</td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">{{ $acc->board_name }}</span>
                                        <div class="fs-12 text-muted mt-1">ID: {{ $acc->board_id }}</div>
                                    </td>
                                    <td>
                                        @if ($acc->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('apps.pinterest.accounts.destroy', $acc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus akun Pinterest ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-person-exclamation fs-1 d-block mb-2 text-secondary"></i>
                                        Belum ada akun Pinterest terhubung. Klik "Tambah Akun Baru" untuk menghubungkan token.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Akun -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('apps.pinterest.accounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="addAccountModalLabel"><i class="bi bi-pinterest text-danger me-1"></i> Hubungkan Akun Pinterest</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#addAccountModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="account_name" class="form-label">Nama / Label Akun <span class="text-danger">*</span></label>
                            <input type="text" name="account_name" id="account_name" class="form-control" placeholder="Contoh: Akun Fashion Utama" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username Pinterest</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Contoh: fashion_ootd_id">
                        </div>
                        <div class="mb-3">
                            <label for="board_id" class="form-label">Board Target ID <span class="text-danger">*</span></label>
                            <input type="text" name="board_id" id="board_id" class="form-control" placeholder="Contoh: 10423984920481" required>
                        </div>
                        <div class="mb-3">
                            <label for="board_name" class="form-label">Nama Board Target</label>
                            <input type="text" name="board_name" id="board_name" class="form-control" placeholder="Contoh: Rekomendasi Baju Shopee">
                        </div>
                        <div class="mb-3">
                            <label for="access_token" class="form-label">Access Token Pinterest API <span class="text-danger">*</span></label>
                            <textarea name="access_token" id="access_token" class="form-control" rows="3" placeholder="Masukkan Access Token / API Key Pinterest" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger fw-bold"><i class="bi bi-save me-1"></i> Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
