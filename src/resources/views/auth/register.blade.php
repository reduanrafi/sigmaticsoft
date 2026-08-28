@extends('website.layouts.master')

@section('title', 'Client Portal Registration | Sigmatic Soft')
@section('meta_description', 'Create your Sigmatic Soft client portal account to begin collaborating with our systems engineering team, review active project milestones, and submit requests.')

@section('content')
    <div class="py-5 bg-light border-bottom">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6 text-start">
                    <!-- Brand Title/Intro -->
                    <div class="text-center mb-4">
                        <img width="80" src="{{ asset('assets/website/images/logo.png') }}" alt="Sigmatic Soft Logo" class="mb-3">
                        <h2 class="fw-bold text-dark mb-1">Create Account</h2>
                        <p class="small text-muted">Register to access your business systems portal</p>
                    </div>

                    <!-- Register Card -->
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

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="premium-form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-user"></i></span>
                                    <input id="name" type="text" class="form-control premium-form-control rounded-end @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="John Doe" style="border-left: none;">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="premium-form-label">{{ __('E-Mail Address') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control premium-form-control rounded-end @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="john@company.com" style="border-left: none;">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div class="mb-3">
                                <label for="phone" class="premium-form-label">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                                    <input id="phone" type="text" class="form-control premium-form-control rounded-end @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="+1 (555) 000-0000" style="border-left: none;">
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Account Type (Hidden / Readonly) -->
                            <input type="hidden" name="type" value="store_owner">

                            <div class="row">
                                <!-- Password Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="premium-form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                        <input id="password" type="password" class="form-control premium-form-control rounded-end @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••" style="border-left: none;">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback d-block mt-1 small" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="col-md-6 mb-3">
                                    <label for="password-confirm" class="premium-form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                                        <input id="password-confirm" type="password" class="form-control premium-form-control rounded-end" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" style="border-left: none;">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-premium btn-premium-primary w-100 py-3 fs-6 mt-2">
                                Register Account <i class="fa-solid fa-user-plus ms-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Sign In Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
