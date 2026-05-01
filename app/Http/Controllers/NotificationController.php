<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Mark one as read
    public function markRead(string $id)
    {
        Auth::user()
            ->notifications()
            ->where('id', $id)
            ->first()
            ?->markAsRead();

        return back();
    }

    // Mark all as read
    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    // Full notifications page
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }
}