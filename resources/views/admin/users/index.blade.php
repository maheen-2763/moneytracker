@extends('admin.layouts.app')
@section('title', 'Manage Users')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">👥 Users</h4>
            <small class="text-muted">{{ $users->total() }} total users</small>
        </div>
    </div>

    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
        <div class="card-body py-3">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Search by name or email..." value="{{ request('search') }}">
                <button class="btn btn-sm btn-primary px-3">Search</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>User</th>
                    <th>Expenses</th>
                    <th>Total Spent</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $user->avatarUrl() }}" class="rounded-circle" width="32" height="32"
                                    style="object-fit:cover; border:2px solid #e2e8f0;">
                                <div>
                                    <div class="fw-semibold" style="font-size:.875rem">
                                        {{ $user->name }}
                                    </div>
                                    <div class="text-muted" style="font-size:.75rem">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $user->expenses_count }}
                            </span>
                        </td>
                        <td class="fw-bold text-danger" style="font-size:.875rem">
                            ₹{{ number_format($user->expenses_sum_amount ?? 0, 0) }}
                        </td>
                        <td class="text-muted" style="font-size:.82rem">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning me-1"
                                    onclick="return confirm('Ban this user?')" title="Ban user">
                                    <i class="bi bi-slash-circle"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Permanently delete this user?')" title="Delete user">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-people fs-3 d-block mb-2"></i>
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $users->withQueryString()->links() }}
    </div>

@endsection
