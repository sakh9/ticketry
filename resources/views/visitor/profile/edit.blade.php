@extends('layouts.app')

@section('title', 'Edit Profile - cikieto')

@section('content')
<h2>Edit Visitor Profile</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('visitor.profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Profile Photo -->
    <div class="card mb-4">
        <div class="card-header"><strong>Profile Photo</strong></div>
        <div class="card-body">
            <div class="text-center mb-3">
                @if($visitor->foto_visitor)
                    <img src="{{ Storage::url($visitor->foto_visitor) }}" alt="Profile Photo" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                @else
                    <div style="width: 150px; height: 150px; background: #e9ecef; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 3rem; color: #999;">
                        {{ strtoupper(substr($visitor->nama_visitor, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Photo</label>
                <input type="file" name="foto_visitor" class="form-control" accept="image/*">
                <small class="text-muted">Leave empty to keep current photo. Max 2MB. JPG, PNG only.</small>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="card mb-4">
        <div class="card-header"><strong>Profile Information</strong></div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="nama_visitor" class="form-control" value="{{ old('nama_visitor', $visitor->nama_visitor) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="text" name="no_hp_visitor" class="form-control" value="{{ old('no_hp_visitor', $visitor->no_hp_visitor) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">NIK (16 digits)</label>
                <input type="text" name="nik_visitor" class="form-control" value="{{ old('nik_visitor', $visitor->nik_visitor) }}" readonly>
                <small class="text-muted">NIK cannot be changed.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email_visitor" class="form-control" value="{{ old('email_visitor', $visitor->email_visitor) }}" readonly>
                <small class="text-muted">Email cannot be changed.</small>
            </div>
        </div>
    </div>

    <!-- Password Section -->
    <div class="card mb-4">
        <div class="card-header"><strong>Change Password (Optional)</strong></div>
        <div class="card-body">
            <p class="text-muted">Leave blank if you don't want to change your password.</p>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Current password">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Min 8 characters">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Repeat new password">
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="{{ route('visitor.events.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection