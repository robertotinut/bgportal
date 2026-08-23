@extends('partials.Layouts.master_auth')

@section('title', 'Daftar Akun | BGPortal')

@section('content')

    <!-- START REGISTER -->
    <div>
        <img src="{{ asset('assets/images/auth/login_bg.jpg') }}" alt="Auth Background"
            class="auth-bg light w-full h-full opacity-60 position-absolute top-0">
        <img src="{{ asset('assets/images/auth/auth_bg_dark.jpg') }}" alt="Auth Background" class="auth-bg d-none dark">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-10">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card mx-xxl-8">
                        <div class="card-body py-10 px-8">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="BGPortal Logo" height="30"
                                class="mb-3 mx-auto d-block">
                            <h5 class="fw-bold text-center text-dark mb-1">Daftar Akun Baru</h5>
                            <p class="text-muted fs-13 text-center mb-4">Buat akun untuk mengakses portal aplikasi BGPortal</p>
                            
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 ps-3 fs-13">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fs-13 fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name"
                                            placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label fs-13 fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" id="email"
                                            placeholder="nama@email.com" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label fs-13 fw-semibold">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" id="password"
                                            placeholder="Minimal 6 karakter" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="password_confirmation" class="form-label fs-13 fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" class="form-control rounded-3" id="password_confirmation"
                                            placeholder="Ulangi password Anda" required>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary w-full py-2.5 rounded-pill fw-bold shadow-sm">
                                            Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <span class="text-muted fs-13">Sudah punya akun?</span>
                                        <a href="{{ route('login') }}" class="link-primary fw-semibold fs-13 ms-1">Masuk disini</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <p class="position-relative text-center fs-12 mb-0">© {{ date('Y') }} BGPortal System. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
