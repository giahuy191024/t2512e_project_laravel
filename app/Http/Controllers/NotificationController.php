<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Lấy danh sách thông báo của user hiện tại
    public function index()
    {
        $notifications = Notification::with('booking.timeSlot.doctorSchedule.doctor')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return response()->json($notifications);
    }

    // Đánh dấu 1 thông báo là đã đọc
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    // Đánh dấu tất cả là đã đọc
    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back();
    }

    // Lấy số thông báo chưa đọc
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}
