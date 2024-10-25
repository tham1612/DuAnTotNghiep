<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index($user_id)
    {
        // Lấy thông báo của người dùng và map lại theo cấu trúc yêu cầu
        $allNotifications = User::find($user_id)
            ->notifications() // Lấy thông báo qua quan hệ
            ->latest('created_at') // Sắp xếp theo `created_at` mới nhất
            ->get() // Lấy kết quả
            ->map(function ($notification, $index) {
                return [
                    'id' => $index + 1, // Tăng dần chỉ mục
                    'readed' => $notification->data['readed'] ?? false,
                    'name' => $notification->data['name'] ?? 'N/A',
                    'title' => $notification->data['title'] ?? 'No title',
                    'description' => $notification->data['description'] ?? 'No description',
                    'date' => date('M d', strtotime($notification->created_at)), // Định dạng lại ngày
                ];
            });


        // Trả về JSON với key 'primary'
        return response()->json([
            [
                'primary' => $allNotifications,
            ]
        ]);
    }
    

}
