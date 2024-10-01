<?php

// namespace App\Http\Controllers;

// use App\Models\Board;
// use Illuminate\Http\Request;
// use Spatie\Activitylog\Models\Activity;

// class ActivityController extends Controller
// {
//     public function boardActivities($boardId)
//     {
//         // Lấy dữ liệu bảng
//         $board = Board::findOrFail($boardId);

//         // Lấy các hoạt động liên quan đến bảng
//         $activities = Activity::where('log_name', 'board_' . $boardId)->latest()->get();

//         // Trả về view hiển thị hoạt động của bảng
//         return view('boards.index', compact('board', 'activities'));
//     }
// }
