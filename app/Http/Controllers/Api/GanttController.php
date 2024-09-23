<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Task;
use App\Models\TaskLink;
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
        // Lấy các task thuộc về những catalog_ids này và sắp xếp theo sortorder
        $tasks = Task::whereIn('catalog_id', $catalogIds)
                     ->orderBy('sortorder')
                     ->get();
                     
        $links = TaskLink::all();
        return response()->json(['data' => $tasks, 'links' => $links]); // Trả dữ liệu dưới dạng JSON
    }



}
