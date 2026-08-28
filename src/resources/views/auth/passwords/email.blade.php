@extends('website.layouts.master')

@section('title', 'Reset Password | Sigmatic Soft')
@section('meta_description', 'Recover your Sigmatic Soft client portal password by requesting a secure password reset link.')

@section('content')
    <div class="py-5 bg-light border-bottom">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 text-start">
                    <!-- Intro -->
                    <div class="text-center mb-4">
                        <img width="80" src="{{ asset('assets/website/images/logo.png') }}" alt="Sigmatic Soft Logo" class="mb-3">
                        <h2 class="fw-bold text-dark mb-1">Reset Password</h2>
                        <p class="small text-muted">Request a secure password reset link</p>
                    </div>

                    <!-- Reset Link Card -->
                    <div class="p-4 bg-white border rounded shadow-sm">
                        <!-- Status Alerts -->
                        @if (session('status'))
                            <div class="alert alert-success border-0 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger border-0 mb-4" role="alert">
                                <ul class="mb-0 small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-4">
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

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-premium btn-premium-primary w-100 py-3 fs-6">
                                {{ __('Send Password Reset Link') }} <i class="fa-solid fa-paper-plane ms-2"></i>
                            </button>
                        </form>
                    </div>

                    <div class="text-center mt-4">
                        <p class="small text-muted">
                            Remember your credentials? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-primary">Sign In Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
