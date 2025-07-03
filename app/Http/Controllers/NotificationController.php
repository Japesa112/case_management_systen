<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class NotificationController extends Controller
{
    /**
     * Return current user's notifications (latest 6).
     * This is used for the dropdown via AJAX.
     */
    public function fetch()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $notifications = $user->notifications()
                ->wherePivot('is_read', false)
                ->orderByDesc('notifications.created_at')
                ->take(6)
                ->get();

            return response()->json($notifications);
        } catch (\Exception $e) {
            Log::error('Notification Fetch Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Failed to fetch notifications'], 500);
        }
    }


    /**
     * Mark a specific notification as read for the current user.
     */
  public function markAsRead($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user->notifications()->updateExistingPivot($id, [
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true]);
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

    public function unreadCount()
    {
        $count = Auth::user()->notifications()->wherePivot('is_read', false)->count();
        return response()->json(['count' => $count]);
    }

    public function toggleNotificationStatus(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $newStatus = $request->input('notifications_enabled') ? 'ON' : 'OFF';

    DB::table('notification_preferences')->updateOrInsert(
        ['user_id' => $user->user_id],
        ['status' => $newStatus, 'updated_at' => now()]
    );

    return response()->json(['status' => $newStatus]);
}

public function getNotificationStatus()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $setting = DB::table('notification_preferences')
        ->where('user_id', $user->user_id)
        ->first();

    $status = $setting ? $setting->status : 'ON'; // Default to ON if not found

    return response()->json(['status' => $status]);
}

}
