<?php

namespace App\Http\Controllers;


use App\Events\RealtimeCreateTask;
use App\Events\TaskUpdated;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Jobs\CreateGoogleApiClientEvent;
use App\Jobs\UpdateGoogleApiClientEvent;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Catalog;
use App\Models\CheckList;
use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Follow_member;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\TaskComment;
use App\Models\TaskMember;
use App\Models\TaskTag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Mockery\Exception;
use Spatie\Activitylog\Models\Activity;


class TaskController extends Controller
{
    protected $googleApiClient;
    const PATH_UPLOAD = 'tasks';

    public function __construct(
        GoogleApiClientController $googleApiClient,
        AuthorizeWeb              $authorizeWeb
    )
    {
        $this->googleApiClient = $googleApiClient;
        $this->authorizeWeb = $authorizeWeb;
    }

    public function getFormCreateTask($catalogId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        if (!$catalogId) {
            return response()->json(['error' => 'catalogId is missing'], 400);
        }
        $catalog = Catalog::findOrFail($catalogId);

        $htmlForm = View::make('dropdowns.createTask', [
            'catalog' => $catalog,
        ])->render();

        // Trả về HTML cho frontend
        return response()->json(['html' => $htmlForm]);
    }

    public function store(StoreTaskRequest $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $catalog = Catalog::query()->findOrFail($request->catalog_id);
        $authorize = $this->authorizeWeb->authorizeEdit($catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $data = $request->except(['position', 'priority', 'risk', 'sortorder']);
        if (isset($data['start']) || isset($data['end'])) {
            $data['start_date'] = empty($data['start']) ? $data['end'] : $data['start'];
            $data['end_date'] = $data['end'];
        } else if (isset($data['start_date']) || isset($data['end_date'])) {
            $data['start_date'] = empty($data['start_date']) ? $data['end_date'] : $data['start_date'];
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

        broadcast(new RealtimeCreateTask($task))->toOthers();
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
        if (Auth::user()->access_token) {
            if (isset($data['start_date']) || isset($data['end_date'])) {
                $this->googleApiClient->createEvent($data);
            }
        }
        return response()->json([
            'msg' => $task->text . ' đã được thêm thành công',
            'action' => 'success',
            'success' => true,
            'task' => $task,
            'catalogs' => $task->catalog->board->catalogs,
            'task_count' => count($catalog->tasks),
        ]);
    }


    public function update(string $id, UpdateTaskRequest $request)
    {
        $task = Task::query()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeEdit($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');


        $data = $request->except(['image']);
        if (isset($data['start']) || isset($data['end'])) {
            $data['start_date'] = $data['start'] == 'Invalid date' ? $data['end'] : $data['start'];
            $data['end_date'] = $data['end'];
        } else if (isset($data['start_date']) || isset($data['end_date'])) {
            $data['start_date'] = $data['start_date'] == 'Invalid date' ? $data['end_date'] : $data['start_date'];
        }

        if ($request->hasFile('image')) {
            $imagePath = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            $data['image'] = $imagePath;
            if ($task->image && Storage::exists($task->image)) {
                Storage::delete($task->image);
            }
        }

        $task->update($data);
        $data['id'] = $id;
        $data['text'] = $task->text;
        $data['description'] = $task->description;
        $data['id_gg_calendar'] = $task->id_google_calendar;
        $data['start_date'] = $task->start_date;
        $data['end_date'] = $task->end_date;
// xử lý thêm vào gg calendar
        if (Auth::user()->access_token) {
            if ($task->id_google_calendar) {
                $this->googleApiClient->updateEvent($data);
            } else {
                $this->googleApiClient->createEvent($data);
            }
        }


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

        return response()->json([
            'msg' => 'Task ' . $data['text'] . ' đã được cập nhật thành công!',
            'action' => 'success',
            'task' => $task
        ]);

    }

    public function updatePosition(Request $request, string $id)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');

        $task = Task::query()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeEdit($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }

        $data = $request->all();

        $data['position'] = $request->position + 1;

        $positionOldSameCatalog = Task::query()
            ->select('position', 'id')
            ->findOrFail($id);

        if ($task->catalog_id != $data['catalog_id']) {
            //            dd($data['position']);
            $positionChangeNew = Task::query()
                ->whereNotBetween('position', [1, $data['position'] - 1])
                ->where('catalog_id', $data['catalog_id'])
                ->get();

            $positionChangeOld = Task::query()
                ->where('position', '>', $positionOldSameCatalog->position)
                ->where('catalog_id', $task->catalog_id)
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
                    'board_id' => $task->catalog->board_id,
                    'tasks_affected_new' => $positionChangeNew->pluck('id')->toArray(),
                ])
                ->tap(function (Activity $activity) use ($task) {
                    $activity->catalog_id = $task->catalog_id;
                    $activity->task_id = $task->id;
                    $activity->board_id = $task->catalog->board_id;
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
                    'catalog_id_old' => $task->catalog_id,
                    'board_id' => $task->catalog->board_id,
                    'tasks_affected_new' => $positionChangeNew->pluck('id')->toArray(),
                ])
                ->tap(function (Activity $activity) use ($task) {
                    $activity->catalog_id = $task->catalog_id;
                    $activity->task_id = $task->id;
                    $activity->board_id = $task->catalog->board_id;
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
                    'board_id' => $task->catalog->board_id,
                    'tasks_affected' => $positionChange->pluck('id')->toArray(),
                ])
                ->tap(function (Activity $activity) use ($task) {
                    $activity->catalog_id = $task->catalog_id;
                    $activity->task_id = $task->id;
                    $activity->board_id = $task->catalog->board_id;
                })
                ->log('Vị trí các task trong cùng catalog đã thay đổi.');
        }
        $task->update($data);
    }

    public function updateFolow(Request $request, string $id)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
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

    public function updatePriorityOrRisk(Request $request, string $id)
    {
        $task = Task::query()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeEdit($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }


        if ($request->type === 'priority') {
            $task->update([
                'priority' => $request->value
            ]);
        }
        if ($request->type === 'risk') {
            $task->update([
                'risk' => $request->value
            ]);
        }
        return response()->json([
            'task' => $task,
        ]);
    }

    public function destroy(string $id)
    {
        $task = Task::query()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeArchiver($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $task->delete();
        return response()->json([
            'action' => 'success',
            'msg' => 'Lưu trữ thẻ thành công!!',
            'task' => $task
        ]);
    }

    public function restoreTask(string $id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $boardId = Task::withTrashed()
            ->join('catalogs', 'tasks.catalog_id', '=', 'catalogs.id')
            ->join('boards', 'catalogs.board_id', '=', 'boards.id')
            ->where('tasks.id', $task->id)
            ->value('boards.id');
        $authorize = $this->authorizeWeb->authorizeArchiver($boardId);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }

        $task->restore();
        return response()->json([
            'action' => 'success',
            'msg' => 'Hoàn tác task thành công!!',
            'task' => $task
        ]);
    }

    public function destroyTask(string $id)
    {

        $task = Task::withTrashed()->findOrFail($id);
        $boardId = Task::withTrashed()
            ->join('catalogs', 'tasks.catalog_id', '=', 'catalogs.id')
            ->where('tasks.id', $task->id)
            ->value('catalogs.board_id');
        $authorize = $this->authorizeWeb->authorizeArchiver($boardId);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            // đơn
            Follow_member::query()->where('task_id', $id)->delete();
            TaskMember::query()->where('task_id', $id)->delete();
            TaskTag::query()->where('task_id', $id)->delete();
            TaskAttachment::query()->where('task_id', $id)->delete();

            foreach ($task->checkLists as $checklist) {
                // Lặp qua các checklist item của mỗi checklist và xóa các item members
                foreach ($checklist->checkListItems as $checklistItem) {
                    $checklistItem->checkListItemMembers()->delete();
                }
                // Xóa tất cả các checklist items của checklist
                $checklist->checkListItems()->delete();
            }

            TaskComment::query()->where('task_id', $id)->forceDelete();

            //  kết hợp
            CheckList::query()->where('task_id', $id)->delete();

            $task->forceDelete();
            if ($task->id_google_calendar) $this->googleApiClient->deleteEvent($task->id_google_calendar);
            // Nếu mọi thứ thành công, commit các thay đổi
            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Xóa vĩnh viễn task thành công!!',
            ]);
        } catch (\Exception $e) {
            // Nếu xảy ra lỗi, rollback các thay đổi
            DB::rollBack();
            dd($e->getMessage());
            // Xử lý lỗi (ghi log, trả về thông báo lỗi, ...)
        }
    }

    public function copyTask(Request $request)
    {
        $data = $request->all();
        $task = Task::query()->findOrFail($data['id']);
        $authorize = $this->authorizeWeb->authorizeEdit($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $catalog = Catalog::query()->findOrFail($data['catalog_id']);

        try {
            DB::beginTransaction();
            $taskNew = Task::query()->create([
                'catalog_id' => $data['catalog_id'],
                'text' => $data['text'],
                'description' => $task['description'],
                'position' => $catalog->tasks()->count() + 1,
                'image' => $task['image'],
                'priority' => $task['priority'],
                'risk' => $task['risk'],
                'progress' => $task['progress'],
                'start_date' => $task['start_date'],
                'end_date' => $task['end_date'],
                'parent' => $task['parent'],
                'sortorder' => $task['sortorder'],
                'id_google_calendar' => $task['id_google_calendar'],
                'creator_email' => Auth::user()->email,
            ]);

            if (isset($data['isAttachment'])) {
                $attachmentOld = TaskAttachment::query()->where('task_id', $task['id'])->get();

                foreach ($attachmentOld as $attachment) {
                    TaskTag::query()->create([
                        'task_id' => $taskNew->id,
                        'file_name' => $attachment['file_name'],
                        'name' => $attachment['name'],
                    ]);
                }
            }

            if (isset($data['isCheckList'])) {
                $checklistOld = CheckList::query()->where('task_id', $task['id'])->get();

                foreach ($checklistOld as $checklist) {
                    $checklistNew = CheckList::query()->create([
                        'task_id' => $taskNew->id,
                        'name' => $checklist['name'],
                    ]);

                    $checklistItemOld = CheckListItem::query()->where('check_list_id', $checklist['id'])->get();

                    foreach ($checklistItemOld as $checklistItem) {
                        CheckListItem::query()->create([
                            'check_list_id' => $checklistNew->check_list_id,
                            'name' => $checklistItem['name'],
                            'parent_id' => $checklistItem['parent_id'],
                            'is_complete' => $checklistItem['is_complete'],
                            'start_date' => $checklistItem['start_date'],
                            'end_date' => $checklistItem['end_date'],
                            'reminder_date' => $checklistItem['reminder_date'],
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Sao chép thẻ thành công!!',
                'board_id' => $data['toBoard']
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['action' => 'error',
                'msg' => 'Có lỗi xảy ra!!']);
        }
    }

// call giao diện

    public function getFormDateTask($taskID)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $task = Task::findOrFail($taskID);
//        dd( $task);

        $htmlForm = View::make('dropdowns.date', [
            'task' => $task
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

    public function getModalTask($taskId)
    {
        $task = Task::with(['catalog',
            'catalog.board',
            'members',
            'checkLists',
            'checkLists.checkListItems',
            'checkLists.checkListItems.checkListItemMembers',
            'checkLists.checkListItems.checkListItemMembers.user',
            'checkLists.checkListItems.members',
            'tags',
            'followMembers',
            'attachments',
            'taskComments',
            'taskComments.user'
        ])->findOrFail($taskId);
        //    dd( $task);

        $htmlForm = View::make('components.modalTask', [
            'task' => $task,
            'boardId' => $task->catalog->board->id,
            'board' => $task->catalog->board,
            'image' => $task->image ? asset('storage/' . $task->image) : asset('theme/assets/images/small/img-7.jpg'),
            'userId' => auth()->id()
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

}
