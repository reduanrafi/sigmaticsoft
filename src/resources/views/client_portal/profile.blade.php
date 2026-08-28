@extends('layouts.portal_client')

@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">My Account Profile Settings</h4>
                    <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('client.profile.update') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Contact Person Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <h5 class="font-weight-bold mb-3 text-warning">Change Account Password</h5>
                    <p class="text-muted small mb-3">Leave blank if you do not wish to update your password.</p>

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Verify current password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min 8 characters">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat new password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradient-blue text-white w-100 mt-3 font-weight-bold"><i class="mdi mdi-content-save"></i> Save Profile Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
