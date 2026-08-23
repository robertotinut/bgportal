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
            <div class="card-header bg-transparent border-bottom py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-person-badge me-1 text-danger"></i> Daftar Akun Pinterest Terhubung</h5>
                <div>
                    <button type="button" class="btn btn-outline-danger btn-sm fw-bold me-2" data-bs-toggle="modal" data-bs-target="#guideModal">
                        <i class="bi bi-question-circle me-1"></i> Panduan Ambil Token & Board ID
                    </button>
                    <button type="button" class="btn btn-danger btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Akun Baru
                    </button>
                </div>
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

    <!-- Modal Panduan Ambil Token -->
    <div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="guideModalLabel"><i class="bi bi-book text-danger me-1"></i> Panduan Ambil Token Pinterest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="fw-bold text-danger mb-2">Langkah Mudah Mendapatkan Access Token:</h6>
                    <ol class="mb-3">
                        <li class="mb-2">Buka Developer Portal di <a href="https://developers.pinterest.com/apps/" target="_blank" class="fw-bold text-danger">developers.pinterest.com/apps/</a> dan login dengan Akun Bisnis Pinterest Anda.</li>
                        <li class="mb-2">Klik tombol <strong>Create app</strong> -> beri nama aplikasi (misal: <code>BGPortal Affiliate</code>).</li>
                        <li class="mb-2">Masuk ke aplikasi -> buka tab <strong>Generate access token</strong>.</li>
                        <li class="mb-2">Centang semua izin (scopes): <code>boards:read</code>, <code>boards:write</code>, <code>pins:read</code>, <code>pins:write</code>.</li>
                        <li class="mb-2">Klik <strong>Generate token</strong> lalu salin string token (misal: <code>pina_...</code>) ke kolom Access Token di form bawah.</li>
                        <li class="mb-0">Setelah memasukkan Access Token, klik tombol <strong>"Cek & Load Daftar Board"</strong> agar sistem otomatis mengambilkan seluruh Board ID milik Anda!</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup Panduan</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <label for="access_token" class="form-label">Access Token Pinterest API <span class="text-danger">*</span></label>
                            <textarea name="access_token" id="access_token" class="form-control" rows="3" placeholder="Masukkan Access Token (misal: pina_...)" required></textarea>
                            <button type="button" id="btnFetchBoards" class="btn btn-sm btn-outline-danger w-100 mt-2 fw-semibold">
                                <i class="bi bi-arrow-repeat me-1"></i> Cek & Load Daftar Board Otomatis
                            </button>
                        </div>

                        <div id="boardSelectContainer" class="mb-3 d-none">
                            <label for="board_select" class="form-label">Pilih Board Target dari Pinterest <span class="text-danger">*</span></label>
                            <select id="board_select" class="form-select">
                                <option value="">-- Pilih Board --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="board_id" class="form-label">Board Target ID <span class="text-danger">*</span></label>
                            <input type="text" name="board_id" id="board_id" class="form-control" placeholder="ID Board (akan terisi otomatis)" required>
                        </div>
                        <div class="mb-3">
                            <label for="board_name" class="form-label">Nama Board Target</label>
                            <input type="text" name="board_name" id="board_name" class="form-control" placeholder="Nama Board (akan terisi otomatis)">
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
    <script>
        document.getElementById('btnFetchBoards').addEventListener('click', function() {
            const token = document.getElementById('access_token').value.trim();
            if (!token) {
                alert('Silakan masukkan Access Token Pinterest terlebih dahulu!');
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengambil data Board...';

            fetch("{{ route('apps.pinterest.fetch-boards') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ access_token: token })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Board Berhasil Dimuat!';

                if (data.success && data.boards.length > 0) {
                    const container = document.getElementById('boardSelectContainer');
                    const select = document.getElementById('board_select');
                    select.innerHTML = '<option value="">-- Pilih Board Target --</option>';

                    data.boards.forEach(b => {
                        const opt = document.createElement('option');
                        opt.value = b.id;
                        opt.textContent = `${b.name} (ID: ${b.id})`;
                        opt.dataset.name = b.name;
                        select.appendChild(opt);
                    });

                    container.classList.remove('d-none');

                    select.addEventListener('change', function() {
                        const selectedOpt = this.options[this.selectedIndex];
                        if (selectedOpt && selectedOpt.value) {
                            document.getElementById('board_id').value = selectedOpt.value;
                            document.getElementById('board_name').value = selectedOpt.dataset.name || selectedOpt.textContent;
                        }
                    });
                } else {
                    alert(data.message || 'Tidak ada Board yang ditemukan pada akun Pinterest ini.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i> Cek & Load Daftar Board Otomatis';
                alert('Gagal menghubungi Pinterest API: ' + err.message);
            });
        });
    </script>
@endsection
