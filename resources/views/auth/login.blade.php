@extends('partials.Layouts.master_auth')

@section('title', 'Login | BGPortal Admin')

@section('content')

    <!-- START -->
    <div>
        <img src="{{ asset('assets/images/auth/login_bg.jpg') }}" alt="Auth Background"
            class="auth-bg light w-full h-full opacity-60 position-absolute top-0">
        <img src="{{ asset('assets/images/auth/auth_bg_dark.jpg') }}" alt="Auth Background" class="auth-bg d-none dark">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-10">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card mx-xxl-8">
                        <div class="card-body py-12 px-8">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="BGPortal Logo" height="30"
                                class="mb-4 mx-auto d-block">
                            <h6 class="mb-3 mb-8 fw-medium text-center">Masuk ke Panel BGPortal</h6>
                            
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email / Username <span class="text-danger">*</span></label>
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                            placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    <div class="col-12">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                            placeholder="Enter your password" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                            </div>
                                            <div class="form-text">
                                                <a href="#" class="link link-primary text-muted text-decoration-underline">Lupa password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-8">
                                        <button type="submit" class="btn btn-primary w-full mb-3 py-2.5 rounded-pill fw-bold shadow-sm">Sign In <i class="bi bi-box-arrow-in-right ms-1 fs-16"></i></button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <span class="text-muted fs-13">Belum punya akun?</span>
                                        <a href="{{ route('register') }}" class="link-primary fw-semibold fs-13 ms-1">Daftar sekarang</a>
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

@section('js')
@endsection
