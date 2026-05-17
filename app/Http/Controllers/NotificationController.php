<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('user.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['read' => true]);

        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->unread()->update(['read' => true]);
        return back()->with('sucesso', 'Todas as notificações marcadas como lidas.');
    }

    public function count()
    {
        return response()->json([
            'count' => Notification::where('user_id', Auth::id())->unread()->count(),
        ]);
    }

    public function latest()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->limit(5)
            ->get();

        $count = Notification::where('user_id', Auth::id())->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'count' => $count,
        ]);
    }
}
