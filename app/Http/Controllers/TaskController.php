<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Request received', $request->all()); // Ghi lại request nhận được

        $task = new Task();
        $task->text = $request->text;
        $task->start_date = $request->start_date;
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->sortorder = Task::max("sortorder") + 1;

        try {
            $task->save();
            Log::info('Task saved successfully', ['task_id' => $task->id]); // Ghi lại sau khi lưu task thành công
        } catch (\Exception $e) {
            Log::error('Error saving task', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }

        return response()->json([
            "action" => "inserted",
            "tid" => $task->id
        ]);
    }
    public function update($id, Request $request)
    {
        $task = Task::find($id);

        $task->text = $request->text;
        $task->start_date = $request->start_date;
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;

        $task->save();
        if ($request->has("target")) {
            $this->updateOrder($id, $request->target);
        }

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
        $updatedTask->sortorder = $targetOrder;
        $updatedTask->save();
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
