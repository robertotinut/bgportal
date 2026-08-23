@extends('partials.Layouts.master')

@section('title', 'Pengaturan Otomasi | BGPortal')
@section('title-sub', 'Pinterest Affiliate')
@section('pagetitle', 'Pengaturan Jadwal & Filter Kategori')

@section('content')
    <div id="layout-wrapper">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-sliders me-1 text-danger"></i> Form Pengaturan Otomasi & Filter</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('apps.pinterest.settings.update') }}" method="POST">
                            @csrf

                            <!-- Category Filter Rule -->
                            <div class="mb-4 p-3 bg-danger-subtle rounded-3 border border-danger-subtle">
                                <label for="target_category" class="form-label fw-bold text-danger">Kategori Wajib (Mandatory Category Filter) <span class="text-danger">*</span></label>
                                <input type="text" name="target_category" id="target_category" class="form-control form-control-lg border-danger-subtle" value="{{ old('target_category', $settings->target_category) }}" required>
                                <div class="form-text text-dark mt-2">
                                    <i class="bi bi-info-circle me-1"></i> Sistem hanya akan memposting produk yang termasuk dalam kategori ini (misal: <strong>Pakaian / Baju</strong>). Produk luar kategori akan otomatis di-PASS/SKIPPED.
                                </div>
                            </div>

                            <!-- Schedule Time -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label fw-semibold">Jam Mulai Otomasi Setiap Hari <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $settings->start_time) }}" required>
                                    <div class="form-text">Contoh: 09:00 WIB</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="interval_minutes" class="form-label fw-semibold">Jeda Antar Posting (Menit) <span class="text-danger">*</span></label>
                                    <input type="number" name="interval_minutes" id="interval_minutes" class="form-control" value="{{ old('interval_minutes', $settings->interval_minutes) }}" min="5" max="1440" required>
                                    <div class="form-text">Interval posting per produk (misal: 30 menit).</div>
                                </div>
                            </div>

                            <!-- Active Days Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-2">Hari Aktif Eksekusi Otomasi <span class="text-danger">*</span></label>
                                <div class="d-flex flex-wrap gap-3 p-3 bg-light rounded border">
                                    @php
                                        $days = [
                                            'Monday' => 'Senin',
                                            'Tuesday' => 'Selasa',
                                            'Wednesday' => 'Rabu',
                                            'Thursday' => 'Kamis',
                                            'Friday' => 'Jumat',
                                            'Saturday' => 'Sabtu',
                                            'Sunday' => 'Minggu',
                                        ];
                                        $activeDays = $settings->active_days ?? [];
                                    @endphp

                                    @foreach ($days as $eng => $indo)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="active_days[]" value="{{ $eng }}" id="day_{{ $eng }}" {{ in_array($eng, $activeDays) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="day_{{ $eng }}">{{ $indo }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-danger btn-lg px-5 fw-bold">
                                    <i class="bi bi-save me-1"></i> Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/app.js') }}"></script>
@endsection
