<?php

namespace App\Http\Controllers;

use App\Events\TaskUpdated;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Jobs\CreateGoogleApiClientEvent;
use App\Jobs\UpdateGoogleApiClientEvent;
use App\Models\BoardMember;
use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Follow_member;
use App\Models\Task;
use App\Models\TaskMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;


class TaskController extends Controller
{
    protected $googleApiClient;

    public function __construct(GoogleApiClientController $googleApiClient)
    {
        $this->googleApiClient = $googleApiClient;
    }

    /**
     * Display a listing of the resource.
     */
    const PATH_UPLOAD = 'tasks';

    public function index($id, Request $request)
    {


    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->except(['position', 'priority', 'risk', 'sortorder']);
        if (isset($data['start']) || isset($data['end'])) {
            $data['start_date'] = $data['start'] == 'Invalid date' ? $data['end'] : $data['start'];
            $data['end_date'] = $data['end'];
        }

        $maxPosition = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('position');
        $data['position'] = $maxPosition + 1;
        $maxSortorder = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('sortorder');
        $data['sortorder'] = $maxSortorder + 1;
        $data['creator_email'] = Auth::user()->email;
        $data['risk'] = $data['risk'] ?? 'Medium';
        $data['priority'] = $data['priority'] ?? 'Medium';
//        dd($data['start'], $data['end']);
        $task = Task::query()->create($data);
        $data['id'] = $task->id;
        if (isset($data['start_date']) || isset($data['end_date'])) {
            $this->googleApiClient->createEvent($data); // them du lieu vao gg calendar
        }


        // ghi lại hoạt động khi thêm
        activity('thêm mới task')
            ->performedOn($task)
            ->causedBy(Auth::user())
            ->withProperties(['task_name' => $task->text, 'board_id' => $task->catalog->board_id,])
            ->tap(function (Activity $activity) use ($task) {
                $activity->catalog_id = $task->catalog_id;
                $activity->task_id = $task->id;
                $activity->board_id = $task->catalog->board_id;
            })
            ->log('Task "' . $task->text . '" đã được thêm vào danh sách "' . $task->catalog->name . '"');
        // event(new TaskUpdated($task));
        session(['msg' => 'Thêm task ' . $data['text'] . ' thành công!']);
        session(['action' => 'success']);
        return back();
    }

    public function show()
    {
        // $activities = Activity::all();
        // return
    }

    public function update(string $id, UpdateTaskRequest $request)
    {
        $task = Task::query()->findOrFail($id);

        $data = $request->except(['image']);
        if ($request->hasFile('image')) {
            $imagePath = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            $data['image'] = $imagePath;
            if ($task->image && Storage::exists($task->image)) {
                Storage::delete($task->image);
            }
        }
//        dd($data);
        if (isset($data['start_date']) || isset($data['end_date'])) {
            $this->updateCalendar($request, $id);
        }
        $task->update($data);


        activity('Cập nhật task')
            ->performedOn($task)
            ->causedBy(Auth::user())
            ->withProperties([
                'task_id' => $task->id,
                'task_name' => $task->text,
                'board_id' => $task->catalog->board_id,
            ])
            ->tap(function (Activity $activity) use ($task) {
                $activity->catalog_id = $task->catalog_id;
                $activity->task_id = $task->id;
                $activity->board_id = $task->catalog->board_id;
            })
            ->log('Task "' . $task->text . '" đã được cập nhập vào danh sách "' . $task->catalog->name . '"');

        session(['msg' => 'Task ' . $data['text'] . ' đã được cập nhật thành công!']);
        session(['action' => 'success']);
        return response()->json([
            'message' => 'Task đã được cập nhật thành công',
            'success' => true
        ]);

    }
//    public function updateDateTask(Request $request, string $id)
//    {
//        $dateTask = Task::query()->findOrFail($id);
//        $data=$request->only(['reminder_date','end_date','start_date']);
//        $dateTask->update($data);
//        return response()->json([
//            'success' => "update dateTask thành công",
//        ]);
//    }
    public function updatePosition(Request $request, string $id)
    {
        $data = $request->all();
        $model = Task::query()->findOrFail($id);
        // $task = Task::find($id);
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
                    'task_id' => $id,
                    'catalog_id_new' => $data['catalog_id'],
                    'board_id' => $model->catalog->board_id,
                    'tasks_affected_new' => $positionChangeNew->pluck('id')->toArray(),
                ])
                ->tap(function (Activity $activity) use ($model) {
                    $activity->catalog_id = $model->catalog_id;
                    $activity->task_id = $model->id;
                    $activity->board_id = $model->catalog->board_id;
                })
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
                    'task_id' => $id,
                    'catalog_id_old' => $data['catalog_id_old'],
                    'board_id' => $model->catalog->board_id,
                    'tasks_affected_new' => $positionChangeNew->pluck('id')->toArray(),
                ])
                ->tap(function (Activity $activity) use ($model) {
                    $activity->catalog_id = $model->catalog_id;
                    $activity->task_id = $model->id;
                    $activity->board_id = $model->catalog->board_id;
                })
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
                    'board_id' => $model->catalog->board_id,
                    'tasks_affected' => $positionChange->pluck('id')->toArray(),
                ])
                ->tap(function (Activity $activity) use ($model) {
                    $activity->catalog_id = $model->catalog_id;
                    $activity->task_id = $model->id;
                    $activity->board_id = $model->catalog->board_id;
                })
                ->log('Vị trí các task trong cùng catalog đã thay đổi.');
        }
        $model->update($data);
        return redirect()->back()->with('success', 'Cập nhật thành công!!');
    }

    public function updateFolow(Request $request, string $id)
    {
        $data = $request->only(['user_id']);
        $userId = $data['user_id'];

        $taskMemberFollow = Follow_member::where('task_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($taskMemberFollow) {

            $newFollow = $taskMemberFollow->follow == 1 ? 0 : 1;
            $taskMemberFollow->update(['follow' => $newFollow]);

            return response()->json([
                'follow' => $taskMemberFollow->follow,
            ]);
        } else {

            $newTaskMemberFollow = Follow_member::create([
                'user_id' => $userId,
                'task_id' => $id,
                'follow' => 1
            ]);

            return response()->json([
                'follow' => $newTaskMemberFollow->follow,
            ]);
        }

    }

    public function updateCalendar(Request $request, string $id)
    {
        $task = Task::query()->findOrFail($id);
        $data = $request->all();
        $data['id_gg_calendar'] = $task->id_google_calendar;
//        dd($data);
        if ($task->id_google_calendar) {
//            dd('ton tai');
            $this->googleApiClient->updateEvent($data);
        } else {
//            dd('khong ton tai');
            $this->googleApiClient->createEvent($data); // them du lieu vao gg calendar
        }

        $task->update($data);
    }

    public function addMemberTask(Request $request)
    {
        $existingMember = TaskMember::where('task_id', $request->task_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingMember) {
            return response()->json([
                'success' => false,
                'message' => 'Thành viên đã tồn tại trong task.'
            ], 400);
        }

        $data = $request->except(['_token', '_method']);
        TaskMember::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm thành viên thành công.'
        ]);
    }

    public function deleteTaskMember(Request $request)
    {
//        dd($request->all());
        $taskMember = TaskMember::query()
            ->where('task_id', $request->task_id)
            ->where('user_id', $request->user_id)
            ->first();
//        dd($taskMember);
        if (!$taskMember) {
            return response()->json([
                'success' => false,
                'message' => 'Thành viên không tồn tại trong task này.'
            ], 404);
        }
        try {
            $check = $taskMember->delete();
//            dd($check);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Xóa thành viên thành công.'
        ], 200);
    }

    public function destroy(Request $request)
    {

    }
}
