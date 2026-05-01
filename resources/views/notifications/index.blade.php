@extends('layouts.app')
@section('title', 'Notifications')

@section('content')

    <div class="page-heading d-flex justify-content-between align-items-center">
        <div>
            <h4>🔔 Notifications</h4>
            <small>Your activity and budget alerts</small>
        </div>
        @if (auth()->user()->unreadNotifications->count() > 0)
            <a href="{{ route('notifications.read-all') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check-all me-1"></i> Mark all read
            </a>
        @endif
    </div>

    <div class="table-card">
        @forelse($notifications as $notif)
            <a href="{{ route('notifications.read', $notif->id) }}"
                class="notif-item-full {{ is_null($notif->read_at) ? 'unread' : 'read' }}">

                <div class="notif-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div class="notif-body flex-grow-1">
                    <div class="notif-text">{{ $notif->data['message'] }}</div>
                    <div class="notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                </div>

                @if (is_null($notif->read_at))
                    <span class="notif-dot"></span>
                @endif
            </a>
        @empty
            <div class="notif-empty py-5">
                <i class="bi bi-bell-slash fs-2 d-block mb-2 text-muted"></i>
                No notifications yet.
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $notifications->links() }}
    </div>

@endsection
