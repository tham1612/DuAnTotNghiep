<?php

namespace App\Http\Controllers;

use App\Events\RealtimeCatalogArchiver;
use App\Events\RealtimeCatalogDetail;
use App\Events\RealtimeCatalogRestore;
use App\Events\RealtimeCreateCatalog;
use App\Events\RealtimeNotificationBoard;
use App\Http\Requests\StoreCatalogRequest;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Catalog;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Activitylog\Models\Activity;

class CatalogControler extends Controller
{
//    public $taskController;

    public function __construct(
        TaskController $taskController,
        AuthorizeWeb   $authorizeWeb)
    {
        $this->taskController = $taskController;
        $this->authorizeWeb = $authorizeWeb;
    }

    const PATH_UPLOAD = 'catalogs.';

    public function getFormCreateCatalog($boardId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        if (!$boardId) {
            return response()->json(['error' => 'boardId is missing'], 400);
        }

        $htmlForm = View::make('dropdowns.createCatalog', ['boardId' => $boardId])->render();

        // Trả về HTML cho frontend
        return response()->json(['html' => $htmlForm]);
    }

    public function store(StoreCatalogRequest $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $authorize = $this->authorizeWeb->authorizeEdit($request->board_id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $data = $request->except(['image', 'position']);

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $maxPosition = Catalog::where('board_id', $request->board_id)
            ->max('position');
        $data['position'] = $maxPosition + 1;

        $catalog = Catalog::query()->create($data);
        broadcast(new RealtimeCreateCatalog($catalog, $catalog->board->id))->toOthers();

        // lấy thông tin board
        $board = Board::findOrFail($request->board_id);
        activity('thêm mới danh sách')
            ->performedOn($catalog)
            ->causedBy(Auth::user())
            ->withProperties(['catalog_name' => $catalog->name, 'board_id' => $request->board_id, 'workspace_id' => $board->workspace_id])
            ->tap(function (Activity $activity) use ($board, $request, $catalog) {
                $activity->board_id = $request->board_id;
                $activity->catalog_id = $catalog->id;
                $activity->workspace_id = $board->workspace_id;
            })
            ->log('danh sách đã được thêm:' . $catalog->name);
        return response()->json([
            'msg' => $catalog->name . 'đã được thêm thành công',
            'action' => 'success',
            'success' => true,
            'catalog' => $catalog,
            'task_count' => $catalog->tasks->count(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $catalog = Catalog::query()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeEdit($catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $catalog->update($request->all());
        broadcast(new RealtimeCatalogDetail($catalog, $catalog->board_id))->toOthers();
        return response()->json([
            'action' => 'success',
            'msg' => 'Chỉnh sửa danh sách thành công!!',
            'catalog' => $catalog
        ]);
    }

    public function destroy(string $id)
    {
        $catalog = Catalog::query()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeArchiver($catalog->board_id);
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

        $catalog = Catalog::query()->findOrFail($id);

        $tasksId = Task::query()
            ->where('catalog_id', $id)
            ->get()
            ->pluck('id')
            ->toArray();
        try {
            DB::beginTransaction();

            foreach ($tasksId as $taskId) {
                $this->taskController->destroy($taskId);
            }

            $catalog->delete();

            DB::commit();
            broadcast(new RealtimeCatalogArchiver($catalog, $catalog->board_id))->toOthers();
            // Ghi log khi xóa danh sách
            activity('Catalog Deleted')
                ->causedBy(Auth::user()) // Người thực hiện
                ->withProperties(['catalog_name' => $catalog->name])
                ->tap(function (Activity $activity) use ($catalog) {
                    $activity->board_id = $catalog->board_id;
                    $activity->catalog_id = $catalog->id;
                    $activity->workspace_id = $catalog->board->workspace_id;
                })
                ->log('Người dùng đã xóa danh sách khỏi bảng');
            return response()->json([
                'action' => 'success',
                'msg' => 'Lưu trữ danh sách thành công!!',
                'catalog' => $catalog
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return response()->json([
                'action' => 'error',
                'msg' => 'Có lỗi xảy ra!!'
            ]);
        }
    }

    public function destroyCatalog(string $id)
    {
        $catalog = Catalog::withTrashed()->findOrFail($id);
        $boardId = $catalog->board_id;
        $authorize = $this->authorizeWeb->authorizeArchiver($boardId);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }

        $tasks = Task::withTrashed()
            ->where('catalog_id', $id)
            ->get();

        try {

            DB::beginTransaction();

            foreach ($tasks as $task) {
                $this->taskController->destroyTask($task->id);
            }

            $catalog->forceDelete();

            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Xóa vĩnh viễn danh sách thành công!!',
                'catalog' => $catalog,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return response()->json([
                'action' => 'error',
                'msg' => 'Có lỗi xảy ra!!'
            ]);
        }

    }

    public function restoreCatalog(string $id)
    {

        $catalog = Catalog::withTrashed()
            ->findOrFail($id);

        $boardId = Catalog::withTrashed()
            ->join('boards', 'catalogs.board_id', '=', 'boards.id')
            ->where('catalogs.id', $catalog->id)
            ->value('boards.id');
        $authorize = $this->authorizeWeb->authorizeArchiver($boardId);

        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $tasks = Task::withTrashed()
            ->where('catalog_id', $id)
            ->get();
//        dd($tasksId);
        try {
            DB::beginTransaction();

            foreach ($tasks as $task) {
                if ($catalog->deleted_at == $task->deleted_at) {
                    $task = Task::withTrashed()->findOrFail($task->id);
                    $task->restore();
                }
            }

            $catalog->restore();
            $msg = 'Quản trị viên đã khôi phục danh sách "' . $catalog->name . '"';
            DB::commit();
            broadcast(new RealtimeCatalogRestore($catalog, $boardId,$msg))->toOthers();
            return response()->json([
                'action' => 'success',
                'msg' => 'Khôi phục danh sách thành công!',
                'catalog' => $catalog,
                'task_count' => $catalog->tasks->count(),
                'tasks' => $catalog->tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'text' => $task->text,
                        'image' => $task->image,
                        'start_date' => $task->start_date,
                        'end_date' => $task->end_date,
                        'totalMember' => $task->members->count(),
                        'totalTag' => $task->tags->count(),
                        'priority' => $task->priority,
                        'risk' => $task->risk,
                        'totalComment' => $task->taskComments->count(),
                        'totalChecklist' => $task->checklists->count(),
                        'totalAttachment' => $task->attachments->count(),
                        'authFlow' => $task->followMembers->contains('user_id', auth()->id()),
                        'members' => $task->members->map(function ($member) {
                            return [
                                'id' => $member->id,
                                'name' => $member->name,
                                'image' => $member->image,
                            ];
                        }),
                        'tags' => $task->tags->map(function ($tag) {
                            return [
                                'name' => $tag->name,
                                'color_code' => $tag->color_code,
                            ];
                        }),
                        'checklists' => $task->checklists->map(function ($checklist) {
                            return [
                                'totalChecklist' => $checklist->checklistItems->count(),
                                'totalChecklistComplete' => $checklist->checklistItems->where('is_complete', true),

                            ];
                        })
                    ];
                }),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return response()->json([
                'action' => 'error',
                'msg' => 'Có lỗi xảy ra!!'
            ]);
        }

    }

    public function archiverAllTasks(string $id)
    {
        $catalog = Catalog::withTrashed()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeArchiver($catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $allTask = Task::query()->where('catalog_id', $id)->get();

        if ($allTask->isEmpty()) {
            return response()->json([
                'action' => 'warning',
                'msg' => 'Danh sách không có task nào',
            ]);
        }
        foreach ($allTask as $task) {
            $task->delete();
        }

        return response()->json([
            'action' => 'success',
            'msg' => 'Lưu trữ tất cả task thành công',
            'task' => $allTask,

        ]);
    }

    public function copyCatalog(Request $request)
    {
        $catalog = Catalog::query()->findOrFail($request->id);
        $authorize = $this->authorizeWeb->authorizeEdit($catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        try {
            DB::beginTransaction();
            $catalogNew = Catalog::query()->create([
                'board_id' => $catalog->board_id,
                'name' => $request->name,
                'image' => $catalog->image,
                'position' => $catalog->board->count() + 1,
            ]);

            $taskOld = Task::query()->where('catalog_id', $catalog->id)->get();
            foreach ($taskOld as $task) {
                Task::query()->create([
                    'catalog_id' => $catalogNew->id,
                    'text' => $task->text,
                    'description' => $task->description,
                    'position' => $task->position,
                    'image' => $task->image,
                    'priority' => $task->priority,
                    'risk' => $task->risk,
                    'progress' => $task->progress,
                    'start_date' => $task->start_date,
                    'end_date' => $task->end_date,
                    'parent' => $task->parent,
                    'sortorder' => $task->sortorder,
                    'id_google_calendar' => $task->id_google_calendar,
                    'creator_email' => $task->creator_email,
                ]);
            }
            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Sao chép danh sách thành công!!',
                'catalog' => $catalog
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function moveCatalog(Request $request)
    {
        $catalog = Catalog::query()->findOrFail($request->catalog_id);
        $authorize = $this->authorizeWeb->authorizeEdit($catalog->board->id);
        $authorizeMoveBoard = $this->authorizeWeb->authorizeEdit($request->board_id);
        if (!$authorizeMoveBoard) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền di chuyển sang bảng này!!',
            ]);
        }
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        try {
            DB::beginTransaction();
            $positionCatalog = Board::query()->findOrFail($request->board_id);
            $catalog->update([
                'board_id' => $request->board_id,
                'name' => $request->name,
                'position' => $positionCatalog->catalogs->count() + 1,
            ]);

            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Di chuyển danh sách thành công!!',
                'boardId' => $request->board_id
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function getModalSettingCatalog($catalogId)
    {
        $catalog = Catalog::with(
            'tasks'
        )->findOrFail($catalogId);
        //    dd( $catalog);
        $htmlForm = View::make('components.modalSettingCatalog', [
            'catalog' => $catalog,
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }
}
