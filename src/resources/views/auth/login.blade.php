@extends('website.layouts.master')

@section('title', 'Portal Login | Sigmatic Soft')
@section('meta_description', 'Sign in to the Sigmatic Soft client portal to review your active systems engineering roadmaps, check tickets, and manage payments.')

@section('content')
    <div class="py-5 bg-light border-bottom">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 text-start">
                    <!-- Brand Title/Intro -->
                    <div class="text-center mb-4">
                        <img width="80" src="{{ asset('assets/website/images/logo.png') }}" alt="Sigmatic Soft Logo" class="mb-3">
                        <h2 class="fw-bold text-dark mb-1">Welcome Back</h2>
                        <p class="small text-muted">Sign in to manage your business systems portal</p>
                    </div>

                    <!-- Login Card -->
                    <div class="p-4 bg-white border rounded shadow-sm">
                        <!-- Validation Alerts -->
                        @if($errors->any())
                            <div class="alert alert-danger border-0 mb-4" role="alert">
                                <ul class="mb-0 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="premium-form-label">{{ __('E-Mail Address') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control premium-form-control rounded-end @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@company.com" style="border-left: none;">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <label for="password" class="premium-form-label mb-0">{{ __('Password') }} <span class="text-danger">*</span></label>
                                    @if (Route::has('password.request'))
                                        <a class="small text-decoration-none fw-semibold text-primary" href="{{ route('password.request') }}" style="font-size: 13px;">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control premium-form-control rounded-end @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••" style="border-left: none;">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Remember Me Checkbox -->
                            <div class="mb-4">
                                <div class="form-check text-start">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted small" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-premium btn-premium-primary w-100 py-3 fs-6">
                                Sign In <i class="fa-solid fa-right-to-bracket ms-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Register Link -->
                    @if (Route::has('register'))
                        <div class="text-center mt-4">
                            <p class="small text-muted">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Register Here</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
