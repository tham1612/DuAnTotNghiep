<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {

    // }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'catalog_id' => 'required|integer|exists:catalogs,id',
//            'text' => 'required|string|max:255',
//            'description' => 'nullable|string',
//            'position' => 'required|integer',
//            'priority' => 'required|in:Low,Medium,High',
//            'risk' => 'required|in:Low,Medium,High',
//            'duration' => 'required|integer',
//            'progress' => 'nullable|numeric|min:0|max:1',
//            'start_date'=>'required|date',
//            'parent' => 'nullable|integer'
//          ]);
//          $taskData = $request->all();
////          $taskData['sortorder'] = Task::max('sortorder') + 1;
////          $taskData['progress'] = $request->input('progress',0);
////          dd($taskData);
////           Task::create($taskData);
        $data=$request->except(['position','priority','risk','sortorder',]);
        $maxPosition = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('position');
        $data['position']=$maxPosition +1;
        $maxSortorder = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('sortorder');
        $data['sortorder']=$maxSortorder +1;
        $data['risk']=$data['risk'] ?? 'Medium';
        $data['priority']=$data['priority'] ?? 'Medium';
//        dd($data);
        Task::query()->create($data);
        return back()
            ->with('success', 'Thêm mới danh sách thành công vào bảng');
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
