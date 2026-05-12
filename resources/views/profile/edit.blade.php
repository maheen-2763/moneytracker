@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Edit Profile
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Update your personal information
                </p>
            </div>
            <a href="{{ route('profile.index') }}"
                class="text-sm font-medium text-indigo-500 hover:text-indigo-600 transition">
                ← Back to Profile
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- ── Left: Avatar ── --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                <div
                    class="flex items-center gap-2 px-6 py-4
                        border-b border-gray-200 dark:border-gray-800">
                    <i class="bi bi-image text-indigo-500"></i>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                        Profile Avatar
                    </h2>
                </div>

                <div class="p-6 flex flex-col items-center text-center space-y-4">

                    {{-- Preview --}}
                    <img src="{{ $user->avatarUrl() }}" id="avatarPreview" alt="avatar"
                        class="w-24 h-24 rounded-full object-cover
                            ring-4 ring-indigo-100 dark:ring-indigo-900/30">

                    {{-- Upload Form --}}
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        class="w-full space-y-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <label for="avatarInput"
                            class="w-full inline-flex items-center justify-center gap-2
                               px-4 py-2 rounded-lg cursor-pointer
                               border border-indigo-500
                               text-indigo-500 hover:bg-indigo-50
                               dark:hover:bg-indigo-900/20
                               text-sm font-medium transition">
                            <i class="bi bi-upload"></i>
                            Choose Photo
                        </label>
                        <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*"
                            onchange="previewAvatar(this)">

                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            JPG, PNG or WebP · Max 2MB
                        </p>

                        @error('avatar')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2
                               px-4 py-2 rounded-lg
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-medium transition">
                            <i class="bi bi-check"></i>
                            Upload Avatar
                        </button>
                    </form>

                    {{-- Remove Avatar --}}
                    @if ($user->avatar)
                        <form method="POST" action="{{ route('profile.avatar.remove') }}" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2
                                   px-4 py-2 rounded-lg
                                   border border-red-200 dark:border-red-900/40
                                   text-red-500 hover:bg-red-50
                                   dark:hover:bg-red-900/20
                                   text-sm font-medium transition">
                                <i class="bi bi-trash"></i>
                                Remove Avatar
                            </button>
                        </form>
                    @endif

                </div>
            </div>

            {{-- ── Right: Forms ── --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Personal Information --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

                    <div
                        class="flex items-center gap-2 px-6 py-4
                            border-b border-gray-200 dark:border-gray-800">
                        <i class="bi bi-person text-indigo-500"></i>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Personal Information
                        </h2>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                                Full Name
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      px-4 py-2.5 text-sm
                                      text-gray-900 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition
                                      @error('name') border-red-400 @enderror">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                                Email Address
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      px-4 py-2.5 text-sm
                                      text-gray-900 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition
                                      @error('email') border-red-400 @enderror">
                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                                Phone
                                <span class="normal-case tracking-normal font-normal ml-1">
                                    (optional)
                                </span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                placeholder="+91 9876543210"
                                class="w-full rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      px-4 py-2.5 text-sm
                                      text-gray-900 dark:text-white
                                      placeholder:text-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition">
                        </div>

                        {{-- Bio --}}
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                                Bio
                                <span class="normal-case tracking-normal font-normal ml-1">
                                    (optional, max 200 chars)
                                </span>
                            </label>
                            <textarea name="bio" rows="3" maxlength="200" placeholder="A short description about yourself..."
                                class="w-full rounded-xl
                                         border border-gray-200 dark:border-gray-700
                                         bg-white dark:bg-gray-800
                                         px-4 py-2.5 text-sm
                                         text-gray-900 dark:text-white
                                         placeholder:text-gray-400
                                         focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                         focus:border-indigo-500 transition resize-none">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                                   bg-indigo-500 hover:bg-indigo-600
                                   text-white text-sm font-semibold transition">
                                <i class="bi bi-check-lg"></i>
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>

                {{-- Change Password --}}
                <div class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden"
                    id="password">

                    <div
                        class="flex items-center gap-2 px-6 py-4
                            border-b border-gray-200 dark:border-gray-800">
                        <i class="bi bi-shield-lock text-indigo-500"></i>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">
                            Change Password
                        </h2>
                    </div>

                    <form method="POST" action="{{ route('profile.password') }}" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Current Password --}}
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                                Current Password
                            </label>
                            <input type="password" name="current_password"
                                class="w-full rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      px-4 py-2.5 text-sm
                                      text-gray-900 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition
                                      @error('current_password') border-red-400 @enderror">
                            @error('current_password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                                New Password
                            </label>
                            <input type="password" name="password"
                                class="w-full rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      px-4 py-2.5 text-sm
                                      text-gray-900 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition
                                      @error('password') border-red-400 @enderror">
                            @error('password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label
                                class="block text-xs font-semibold uppercase tracking-widest
                                      text-gray-500 dark:text-gray-400 mb-1.5">
                                Confirm New Password
                            </label>
                            <input type="password" name="password_confirmation"
                                class="w-full rounded-xl
                                      border border-gray-200 dark:border-gray-700
                                      bg-white dark:bg-gray-800
                                      px-4 py-2.5 text-sm
                                      text-gray-900 dark:text-white
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                                      focus:border-indigo-500 transition">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                                   bg-indigo-500 hover:bg-indigo-600
                                   text-white text-sm font-semibold transition">
                                <i class="bi bi-lock"></i>
                                Update Password
                            </button>
                        </div>

                    </form>
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
