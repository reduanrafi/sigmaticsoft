@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card mx-auto">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Edit Client Profile</h4>
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="company_name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $client->company_name) }}" required placeholder="e.g. ABC Ltd.">
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Contact Person Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $client->name) }}" required placeholder="e.g. John Doe">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $client->email) }}" placeholder="e.g. contact@company.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $client->phone) }}" placeholder="e.g. +8801XXXXXXXXX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="alternate_phone">Alternate Phone</label>
                            <input type="text" name="alternate_phone" id="alternate_phone" class="form-control" value="{{ old('alternate_phone', $client->alternate_phone) }}" placeholder="e.g. Alternate phone number">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="status">Profile Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $client->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $client->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Office Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Write company address here...">{{ old('address', $client->address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="notes">Internal Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Write internal notes about this client company (Admin only)...">{{ old('notes', $client->notes) }}</textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-gradient-success text-white w-50"><i class="mdi mdi-content-save"></i> Update Client Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
