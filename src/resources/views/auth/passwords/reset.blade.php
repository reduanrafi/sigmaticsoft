@extends('website.layouts.master')

@section('title', 'Set New Password | Sigmatic Soft')
@section('meta_description', 'Define a new secure password for your Sigmatic Soft client portal account.')

@section('content')
    <div class="py-5 bg-light border-bottom">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6 text-start">
                    <!-- Intro -->
                    <div class="text-center mb-4">
                        <img width="80" src="{{ asset('assets/website/images/logo.png') }}" alt="Sigmatic Soft Logo" class="mb-3">
                        <h2 class="fw-bold text-dark mb-1">Set New Password</h2>
                        <p class="small text-muted">Set up your new password below to regain portal access</p>
                    </div>

                    <!-- Reset Form Card -->
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

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="premium-form-label">{{ __('E-Mail Address') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-regular fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control premium-form-control rounded-end @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="name@company.com" style="border-left: none;">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block mt-1 small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

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
                                {{ __('Reset Password') }} <i class="fa-solid fa-key ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
