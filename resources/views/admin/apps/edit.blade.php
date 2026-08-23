@extends('partials.Layouts.master')

@section('title', 'Edit Aplikasi | BGPortal Admin')
@section('title-sub', 'Admin')
@section('pagetitle', 'Edit Aplikasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Form Edit Aplikasi: {{ $app->name }}</h5>
                <a href="{{ route('admin.apps.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.apps.update', $app->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Aplikasi <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $app->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="code" class="form-label">Kode Unik App <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" id="code" value="{{ old('code', $app->code) }}" required>
                        </div>

                        <div class="col-md-8">
                            <label for="url" class="form-label">URL Aplikasi <span class="text-danger">*</span></label>
                            <input type="text" name="url" class="form-control" id="url" value="{{ old('url', $app->url) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="icon" class="form-label">Icon Class</label>
                            <input type="text" name="icon" class="form-control" id="icon" value="{{ old('icon', $app->icon) }}">
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Deskripsi Aplikasi</label>
                            <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $app->description) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="sort_order" class="form-label">Urutan Tampil</label>
                            <input type="number" name="sort_order" class="form-control" id="sort_order" value="{{ old('sort_order', $app->sort_order) }}">
                        </div>

                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $app->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Status Aplikasi Aktif</label>
                            </div>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Perbarui Aplikasi
                            </button>
                        </div>
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
