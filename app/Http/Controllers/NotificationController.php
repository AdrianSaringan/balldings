<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!Schema::hasTable('notifications')) {
            $notifications = new LengthAwarePaginator(collect(), 0, 15);
            $unreadCount = 0;
        } else {
            $notifications = $user->notifications()->latest()->paginate(15);
            $unreadCount = $user->unreadNotifications()->count();
        }

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function read(Request $request, string $id)
    {
        $user = $request->user();
        if (!\Schema::hasTable('notifications')) {
            return back();
        }
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification && is_null($notification->read_at)) {
            $notification->markAsRead();
        }
        return back()->with('success', 'Notification marked as read.');
    }

    public function readAll(Request $request)
    {
        $user = $request->user();
        if (!\Schema::hasTable('notifications')) {
            return back();
        }
        $user->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        if (!\Schema::hasTable('notifications')) {
            return back();
        }
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->delete();
        }
        return back()->with('success', 'Notification deleted.');
    }
}
