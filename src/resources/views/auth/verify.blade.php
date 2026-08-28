@extends('website.layouts.master')

@section('title', 'Verify Email Address | Sigmatic Soft')
@section('meta_description', 'Please verify your email address to activate your Sigmatic Soft client portal dashboard.')

@section('content')
    <div class="py-5 bg-light border-bottom">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6 text-start">
                    <!-- Intro -->
                    <div class="text-center mb-4">
                        <img width="80" src="{{ asset('assets/website/images/logo.png') }}" alt="Sigmatic Soft Logo" class="mb-3">
                        <h2 class="fw-bold text-dark mb-1">Verify Your Email</h2>
                        <p class="small text-muted">A verification link has been sent to your email address.</p>
                    </div>

                    <!-- Verify Card -->
                    <div class="p-4 bg-white border rounded shadow-sm text-center">
                        @if (session('resent'))
                            <div class="alert alert-success border-0 mb-4 text-start" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        <p class="text-muted small mb-4">
                            {{ __('Before proceeding, please check your email inbox for a verification link.') }}
                            {{ __('If you did not receive the email, click the button below to request another.') }}
                        </p>

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-premium btn-premium-primary py-2 px-4 shadow-sm w-100">
                                {{ __('Request Another Verification Link') }} <i class="fa-solid fa-arrows-rotate ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
