<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Task;
use App\Models\TaskLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Broadcast;

class GanttController extends Controller
{
    public function data($boardId)
    {
        $board = Board::with([
            'catalogs.tasks',
        ])->findOrFail($boardId);

        // Lấy tất cả các catalog_id thuộc board
        $catalogIds = $board->catalogs->pluck('id');

        // Lấy các task thuộc về những catalog_ids này, sắp xếp theo sortorder và kiểm tra duration khác 0
        $tasks = Task::whereIn('catalog_id', $catalogIds)
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->orderBy('sortorder')
            ->get()
            ->map(function ($task) {
                $startDate = $task->start_date instanceof \Carbon\Carbon ? $task->start_date : \Carbon\Carbon::parse($task->start_date);
                $endDate = $task->end_date instanceof \Carbon\Carbon ? $task->end_date : \Carbon\Carbon::parse($task->end_date);

                $task->duration = $startDate->diffInDays($endDate);
                return $task;
            })
            ->filter(function ($task) {
                return $task->duration > 0;
            });



        $links = TaskLink::all();
        return response()->json(['data' => $tasks, 'links' => $links]); // Trả dữ liệu dưới dạng JSON
    }
}
