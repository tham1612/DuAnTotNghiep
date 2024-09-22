<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskLink;

class GanttController extends Controller
{
    public function data()
{
    // Chỉ lấy các trường cần thiết từ bảng tasks
    $tasks = Task::orderBy('sortorder')->get();
    // Lấy tất cả các liên kết nếu cần
    $links = TaskLink::all();

    return response()->json(['data' => $tasks, 'links' => $links]); // Trả dữ liệu dưới dạng JSON
}


}
