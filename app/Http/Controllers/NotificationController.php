<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Return current user's notifications (latest 6).
     * This is used for the dropdown via AJAX.
     */
    public function fetch()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderByDesc('notifications.created_at')
            ->take(6)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Mark a specific notification as read for the current user.
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|exists:notifications,notification_id',
        ]);

        UserNotification::where('user_id', Auth::id())
            ->where('notification_id', $request->notification_id)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Mark all notifications as read for the current user.
     */
    public function markAllAsRead()
    {
        UserNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['status' => 'all_read']);
    }

    /**
     * Delete old notifications (older than 30 days) from both tables.
     */
    public function cleanOld()
    {
        $cutoffDate = Carbon::now()->subDays(30);

        // First, delete from pivot table
        UserNotification::whereIn('notification_id', function ($query) use ($cutoffDate) {
            $query->select('notification_id')
                  ->from('notifications')
                  ->where('created_at', '<', $cutoffDate);
        })->delete();

        // Then, delete from notifications table
        Notification::where('created_at', '<', $cutoffDate)->delete();

        return response()->json(['status' => 'cleaned']);
    }
}
