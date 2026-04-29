@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

    <div class="page-heading d-flex justify-content-between align-items-center">
        <div>
            <h4>My Profile</h4>
            <small>Manage your personal information</small>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit Profile
        </a>
    </div>

    <div class="row g-4">

        {{-- ── Left: Avatar card ── --}}
        <div class="col-md-4">
            <div class="profile-avatar-card text-center">

                <div class="avatar-wrapper mx-auto mb-3">
                    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="profile-avatar-img">
                    <div class="avatar-status"></div>
                </div>

                <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ $user->email }}</p>

                @if ($user->bio)
                    <p class="profile-bio">{{ $user->bio }}</p>
                @endif

                {{-- Stats row --}}
                <div class="profile-stats">
                    <div>
                        <div class="stat-num">{{ auth()->user()->expenses()->count() }}</div>
                        <div class="stat-label">Expenses</div>
                    </div>
                    <div>
                        <div class="stat-num">
                            Rs.{{ number_format(auth()->user()->expenses()->sum('amount'), 0) }}
                        </div>
                        <div class="stat-label">Total Spent</div>
                    </div>
                    <div>
                        <div class="stat-num">
                            {{ auth()->user()->expenses()->whereMonth('date', now()->month)->count() }}
                        </div>
                        <div class="stat-label">This Month</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Right: Info card ── --}}
        <div class="col-md-8 d-flex flex-column gap-4">

            {{-- Personal info --}}
            <div class="profile-info-card">
                <div class="info-card-header">
                    <i class="bi bi-person-lines-fill me-2"></i> Personal Information
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <span class="info-label">Full Name</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone</span>
                        <span class="info-value">
                            {{ $user->phone ?? '—' }}
                        </span>
                    </div>
                    <div class="info-row border-0 pb-0">
                        <span class="info-label">Member Since</span>
                        <span class="info-value">
                            {{ $user->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Security card --}}
            <div class="profile-info-card">
                <div class="info-card-header">
                    <i class="bi bi-shield-lock me-2"></i> Security
                </div>
                <div class="info-card-body">
                    <div class="info-row border-0 pb-0 align-items-center">
                        <div>
                            <div class="info-value">Password</div>
                            <div class="info-label">Last updated: unknown</div>
                        </div>
                        <a href="{{ route('profile.edit') }}#password" class="btn btn-sm btn-outline-secondary ms-auto">
                            Change Password
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
