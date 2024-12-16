<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // public function index($user_id)
    // {
    //     // Lấy thông báo của người dùng và map lại theo cấu trúc yêu cầu
    //     $allNotifications = User::find($user_id)
    //         ->notifications() // Lấy thông báo qua quan hệ
    //         ->latest('created_at') // Sắp xếp theo `created_at` mới nhất
    //         ->get() // Lấy kết quả
    //         ->map(function ($notification) {

    //             $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
    //             return [
    //                 'user_id' => $data['user_id'] ?? 'N/A',
    //                 'id' => $notification->id,
    //                 'readed' => $data['readed'] ?? false,
    //                 'name' => $data['name'] ?? 'N/A',
    //                 'title' => $data['title'] ?? 'No title',
    //                 'description' => $data['description'] ?? 'No description',
    //                 'date' => date('M d', strtotime($notification->created_at)), // Định dạng lại ngày
    //             ];

    //         });


    //     // Trả về JSON với key 'primary'
    //     return response()->json([
    //         [
    //             'primary' => $allNotifications,
    //         ]
    //     ]);
    // }

    public function index($user_id)
    {
        // Lấy workspace để lọc
        $workspaceChecked = \App\Models\Workspace::query()
            ->join('workspace_members', 'workspaces.id', '=', 'workspace_members.workspace_id')
            ->where('workspace_members.user_id', $user_id)
            ->where('workspace_members.is_active', 1)
            ->first();

        // Kiểm tra nếu không tìm thấy workspace
        if (!$workspaceChecked) {
            return response()->json(['message' => 'No active workspace found.'], 404);
        }

        // Lấy thông báo của người dùng và lọc theo workspace_id
        $allNotifications = User::find($user_id)
            ->notifications() // Lấy thông báo qua quan hệ
            ->latest('created_at') // Sắp xếp theo `created_at` mới nhất
            ->get() // Lấy kết quả
            ->map(function ($notification) {
                // Giải mã data
                $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;

                return [
                    'user_id' => $data['user_id'] ?? 'N/A',
                    'workspace_id' => $data['workspace_id'] ?? null,
                    'id' => $notification->id,
                    'readed' => $data['readed'] ?? false,
                    'name' => $data['name'] ?? 'N/A',
                    'title' => $data['title'] ?? 'No title',
                    'description' => $data['description'] ?? 'No description',
                    // 'date' => date('M d', strtotime($notification->created_at)), // Định dạng lại ngày
                    'date' => $this->formatNotificationTime($notification->created_at),
                ];
            })
            // Lọc theo workspace_id
            ->filter(function ($notification) use ($workspaceChecked) {
                return $notification['workspace_id'] == $workspaceChecked->workspace_id;
            });

        // Trả về JSON với key 'primary'
        return response()->json([
            [
                'primary' => $allNotifications->values(), // Reset key cho mảng
            ]
        ]);
    }

    /**
     * Định dạng thời gian thông báo như Trello.
     */
    private function formatNotificationTime($date)
    {
        $carbonDate = Carbon::parse($date);
        $now = Carbon::now();

        if ($carbonDate->isToday()) {
            return $carbonDate->format('h:i A'); // Giờ phút cụ thể cho hôm nay
        } elseif ($carbonDate->isYesterday()) {
            return 'Hôm qua ' . $carbonDate->format('h:i A'); // Hôm qua + giờ
        } else {
            return $carbonDate->format('M d, Y'); // Ngày tháng cụ thể
        }
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
