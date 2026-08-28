@extends('website.layouts.master')

@section('title', 'Confirm Password | Sigmatic Soft')
@section('meta_description', 'Confirm your client portal password to access secure administrative routes.')

@section('content')
    <div class="py-5 bg-light border-bottom">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5 text-start">
                    <!-- Intro -->
                    <div class="text-center mb-4">
                        <img width="80" src="{{ asset('assets/website/images/logo.png') }}" alt="Sigmatic Soft Logo" class="mb-3">
                        <h2 class="fw-bold text-dark mb-1">Confirm Security Access</h2>
                        <p class="small text-muted">{{ __('Please confirm your password before continuing.') }}</p>
                    </div>

                    <!-- Confirm Card -->
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

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

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

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-premium btn-premium-primary w-100 py-3 fs-6 mt-2">
                                {{ __('Confirm Password') }} <i class="fa-solid fa-shield-check ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
