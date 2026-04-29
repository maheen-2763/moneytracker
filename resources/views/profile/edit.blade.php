@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')

<div class="page-heading">
    <h4>Edit Profile</h4>
    <small><a href="{{ route('profile.index') }}" class="text-muted">← Back to profile</a></small>
</div>

<div class="row g-4">

    {{-- ── Profile Info Form ── --}}
    <div class="col-md-8">
        <div class="profile-info-card mb-4">
            <div class="info-card-header">
                <i class="bi bi-person me-2"></i> Personal Information
            </div>
            <div class="info-card-body">
                <form method="POST"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone <span class="text-muted fw-normal">(optional)</span></label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="+91 9876543210">
                    </div>

                    {{-- Bio --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Bio <span class="text-muted fw-normal">(optional, max 200 chars)</span></label>
                        <textarea name="bio" rows="2"
                                  class="form-control"
                                  maxlength="200"
                                  placeholder="A short description about yourself...">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>

        {{-- ── Change Password ── --}}
        <div class="profile-info-card" id="password">
            <div class="info-card-header">
                <i class="bi bi-shield-lock me-2"></i> Change Password
            </div>
            <div class="info-card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Password</label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-warning text-white">
                        <i class="bi bi-lock me-1"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Avatar Upload ── --}}
    <div class="col-md-4">
        <div class="profile-info-card text-center">
            <div class="info-card-header text-start">
                <i class="bi bi-image me-2"></i> Profile Avatar
            </div>
            <div class="info-card-body">

                {{-- Current avatar preview --}}
                <div class="avatar-wrapper mx-auto mb-3" style="width:100px; height:100px;">
                    <img src="{{ $user->avatarUrl() }}"
                         id="avatarPreview"
                         alt="avatar"
                         style="width:100px; height:100px; border-radius:50%; object-fit:cover;
                                border: 3px solid #e2e8f0;">
                </div>

                {{-- Upload form --}}
                <form method="POST"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <input type="hidden" name="name"  value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <label class="btn btn-outline-primary btn-sm w-100 mb-2" for="avatarInput">
                        <i class="bi bi-upload me-1"></i> Choose Photo
                    </label>
                    <input type="file" name="avatar" id="avatarInput"
                           class="d-none" accept="image/*"
                           onchange="previewAvatar(this)">

                    <p class="text-muted" style="font-size:0.72rem">
                        JPG, PNG or WebP · Max 2MB
                    </p>

                    @error('avatar')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-check me-1"></i> Upload Avatar
                    </button>
                </form>

                {{-- Remove avatar --}}
                @if($user->avatar)
                <form method="POST" action="{{ route('profile.avatar.remove') }}" class="mt-2">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-trash me-1"></i> Remove Avatar
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

@endsection