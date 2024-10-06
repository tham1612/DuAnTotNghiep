<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskUpdated;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Contracts\Activity;

use function Laravel\Prompts\text;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        // $request->validate([
        //     'catalog_id' => 'required|integer|exists:catalogs,id',
        //     'text' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'position' => 'required|integer',
        //     'priority' => 'required|in:Low,Medium,High',
        //     'risk' => 'required|in:Low,Medium,High',
        //     'duration' => 'required|integer',
        //     'progress' => 'nullable|numeric|min:0|max:1',
        //     'start_date'=>'required|date',
        //     'parent' => 'nullable|integer'
        //   ]);
        //   $taskData = $request->all();
        //   $taskData['sortorder'] = Task::max('sortorder') + 1;
        //   $taskData['progress'] = $request->input('progress',0);
        //   $task = Task::create($taskData);
        //   return response()->json(['action' => 'inserted', 'tid' => $task->id]);
    }

    public function update($id, Request $request)
    {
        $task = Task::find($id);
        $task->text = $request->text;
        $task->start_date = $request->start_date;

        // Tính toán end_date dựa trên start_date và duration (nếu duration vẫn gửi từ client)
        if ($request->has('duration')) {
            $task->end_date = \Carbon\Carbon::parse($request->start_date)
                               ->addDays($request->duration);
        }

        // Nếu client gửi end_date, cập nhật end_date
        if ($request->has('end_date')) {
            $task->end_date = $request->end_date;
        }

        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;

        // Lưu lại task
        $task->save();
        Log::info('Event TaskUpdated fired for task ID: ' . $task->id);
        // event(new TaskUpdated($task));

        // Nếu có target, cập nhật thứ tự task
        if ($request->has("target")) {
            $this->updateOrder($id, $request->target);
        }
        activity('Cập nhật task')
        ->performedOn($task)
        ->causedBy(Auth::user())
        ->withProperties([
            'task_id' => $task->id,
            'task_name'=>$task->text,
            'board_id' => $task->catalog->board_id,
        ])
        ->tap(function (Activity $activity) use ($task) {
            $activity->catalog_id = $task->catalog_id;
            $activity->task_id = $task->id;
            $activity->board_id = $task->catalog->board_id;
        })
        ->log('Task "' . $task->text . '" đã được cập nhập vào danh sách "' . $task->catalog->name . '"');
        return response()->json([
            "action" => "updated"
        ]);
    }



    private function updateOrder($taskId, $target)
    {
        $nextTask = false;
        $targetId = $target;

        if (strpos($target, "next:") === 0) {
            $targetId = substr($target, strlen("next:"));
            $nextTask = true;
        }

        if ($targetId == "null")
            return;

        $targetOrder = Task::find($targetId)->sortorder;
        if ($nextTask)
            $targetOrder++;

        Task::where("sortorder", ">=", $targetOrder)->increment("sortorder");

        $updatedTask = Task::find($taskId);
        $oldOrder = $updatedTask->sortorder;
        $updatedTask->sortorder = $targetOrder;
        $updatedTask->save();

        activity('Cập nhật thứ tự task')
        ->causedBy(Auth::user()) // Người dùng thực hiện hành động
        ->performedOn($updatedTask) // Task được cập nhật
        ->withProperties([
            'task_id' => $updatedTask->id,
            'task_name' => $updatedTask->text,
            'old_order' => $oldOrder,
            'new_order' => $targetOrder,
            'board_id' => $updatedTask->catalog->board_id,
        ])
        ->tap(function (Activity $activity) use ($updatedTask) {
            $activity->catalog_id = $updatedTask->catalog_id;
            $activity->task_id = $updatedTask->id;
            $activity->board_id = $updatedTask->catalog->board_id;
        })
        ->log('Task đã được cập nhật thứ tự');


    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json(['action' => 'deleted']);
        }
        return response()->json(['error' => 'Task not found'], 404);
    }
}
