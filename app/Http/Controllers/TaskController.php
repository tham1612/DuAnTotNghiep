<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Catalog;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, Request $request) {}

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->except(['position', 'priority', 'risk', 'sortorder',]);
        $maxPosition = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('position');
        $data['position'] = $maxPosition + 1;
        $maxSortorder = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('sortorder');
        $data['sortorder'] = $maxSortorder + 1;
        $data['risk'] = $data['risk'] ?? 'Medium';
        $data['priority'] = $data['priority'] ?? 'Medium';
        $task = Task::query()->create($data);
        activity('thêm mới task')
            ->causedBy(Auth::user())
            ->withProperties(['task_name' => $task->name])
            ->tap(function (Activity $activity) use ($task) {
                $activity->catalog_id = $task->catalog_id;
                $activity->task_id = $task->id;
            })
            ->log('task đã được thêm vào danh sách');
        return back()
            ->with('success', 'Thêm mới danh sách thành công vào bảng');
    }

    public function show()
    {
        // $activities = Activity::all();
        // return
    }

    public function update($id, Request $request)
    {
        $data = $request->except(['_token', '_method']);

         Task::query()
            ->where('id', $id)
            ->update($data);
        $task = Task::query()->findOrFail($id);
        activity('Cập nhật task')
            ->causedBy(Auth::user())
            ->withProperties([
                'task_id' => $task->id,
                'updated_data' => $data
            ])
            ->log('Task đã được cập nhật');
        return response()->json([
            'message' => 'Task đã được cập nhật thành công',
            'success' => true
        ]);
    }

    public function updatePosition(Request $request, string $id)
    {
        $data = $request->all();
        $model = Task::query()->findOrFail($id);
        //        dd($data,$id);
        $data['position'] = $request->position + 1;

        $positionOldSameCatalog = Task::query()
            ->select('position', 'id')
            ->findOrFail($id);
        //        dd($positionOldSameCatalog->position);

        if ($request['catalog_id_old'] != $data['catalog_id']) {
            //            dd($data['position']);
            $positionChangeNew = Task::query()
                ->whereNotBetween('position', [1, $data['position'] - 1])
                ->where('catalog_id', $data['catalog_id'])
                ->get();

            $positionChangeOld = Task::query()
                ->where('position', '>', $positionOldSameCatalog->position)
                ->where('catalog_id', $data['catalog_id_old'])
                ->get();

            //            dd($positionChangeOld->toArray());
            // cap nhat vi tri o catalog moi
            foreach ($positionChangeNew as $item) {
                Task::query()
                    ->where('id', $item->id)
                    ->update([
                        'position' => $item->position + 1
                    ]);
            }
            activity('thay đổi vị trí trong task')
            ->causedBy(Auth::user())
            ->withProperties([
                'task_id'=>$id,
                'catalog_id_new'=>$data['catalog_id'],
                'tasks_affected_new'=>$positionChangeNew->pluck('id')->toArray(),
            ])
            ->log('vị trí các task trong catalog mới đã thay đổi.');
            // cap nhat lai vi tri o catalog cu
            foreach ($positionChangeOld as $item) {
                Task::query()
                    ->where('id', $item->id)
                    ->update([
                        'position' => $item->position - 1
                    ]);
            }
            activity('thay đổi vị trí trong task')
             ->causedBy(Auth::user())
             ->withProperties([
                'task_id'=>$id,
                'catalog_id_old'=>$data['catalog_id_old'],
                'tasks_affected_new'=>$positionChangeNew->pluck('id')->toArray(),
             ])
             ->log('Vị trí các task trong catalog cũ đã thay đổi.');
        } else {

            $positionChange = Task::query()
                ->whereBetween('position', $positionOldSameCatalog->position > $data['position'] ? [$data['position'], $positionOldSameCatalog->position] : [$positionOldSameCatalog->position, $data['position']])
                ->where('catalog_id', $data['catalog_id'])
                ->whereNot('id', $id)
                ->get();

            foreach ($positionChange as $item) {
                Task::query()
                    ->where('id', $item->id)
                    ->update([
                        'position' => $data['position'] < $positionOldSameCatalog->position ? $item->position + 1 : $item->position - 1
                    ]);
            }
            activity('Thay đổi vị trí task')
            ->causedBy(Auth::user())
            ->withProperties([
                'task_id' => $id,
                'catalog_id' => $data['catalog_id'],
                'tasks_affected' => $positionChange->pluck('id')->toArray(),
            ])
            ->log('Vị trí các task trong cùng catalog đã thay đổi.');
        }
        $model->update($data);
        return redirect()->route('b.edit', $id)->with('success', 'Cập nhật thành công!!');
    }

}
