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
            ->map(function ($notification) {

                $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                return [
                    'user_id' => $data['user_id'] ?? 'N/A',
                    'id' => $notification->id,
                    'readed' => $data['readed'] ?? false,
                    'name' => $data['name'] ?? 'N/A',
                    'title' => $data['title'] ?? 'No title',
                    'description' => $data['description'] ?? 'No description',
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


    public function markAsRead($id, $user_id)
    {
        $notification = User::find($user_id)->notifications()->find($id);

        if ($notification) {
            // Kiểm tra nếu data là một chuỗi, nếu có thì giải mã
            $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;

            // Cập nhật trường 'readed'
            $data['readed'] = true;

            // Lưu lại mảng `data` vào notification mà không cần `json_encode`
            $notification->update([
                'data' => $data
            ]);

            return response()->json(['status' => 'success', 'message' => 'Notification marked as read']);
        }

        return response()->json(['status' => 'error', 'message' => 'Notification not found'], 404);
    }

}
