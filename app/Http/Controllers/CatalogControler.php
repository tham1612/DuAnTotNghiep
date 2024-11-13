<?php

namespace App\Http\Controllers;

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
        return response()->json([
            'action' => 'success',
            'msg' => 'Chỉnh sửa danh sách thành công!!',
            'catalog' => $catalog
        ]);
    }

    public function destroy(string $id)
    {
        $catalog = Catalog::query()->findOrFail($id);
        $authorize = $this->authorizeWeb->authorizeArchiver($catalog->board->id);
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
            // Ghi log khi xóa danh sách
            activity('Catalog Deleted')
                ->causedBy(Auth::user()) // Người thực hiện
                ->withProperties(['catalog_name' => $catalog->name])
                ->tap(function (Activity $activity) use ($catalog) {
                    $activity->board_id = $catalog->board_id;
                    $activity->catalog_id = $catalog->id;
                })
                ->log('Người dùng đã xóa danh sách khỏi bảng');
            return response()->json([
                'action' => 'success',
                'msg' => 'Lưu trữ danh sách thành công!!'
            ]);
        } catch (\Exception $e) {
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

        $tasksId = Task::withTrashed()
            ->where('catalog_id', $id)
            ->get()
            ->pluck('id')
            ->toArray();

        try {

            DB::beginTransaction();

            foreach ($tasksId as $taskId) {
                $this->taskController->destroyTask($taskId);
            }

            $catalog->forceDelete();

            DB::commit();
            return response()->json([
                'action' => 'sucess',
                'msg' => 'Xóa vĩnh viễn danh sách thành công!!'
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json([
                'action' => 'error',
                'msg' => 'Có lỗi xảy ra!!'
            ]);
        }

    }

    public function restoreCatalog(string $id)
    {
        $catalog = Catalog::withTrashed()->findOrFail($id);
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
        $tasksId = Task::withTrashed()
            ->where('catalog_id', $id)
            ->get()
            ->pluck('id')
            ->toArray();

        try {
            DB::beginTransaction();

            foreach ($tasksId as $taskId) {
                $this->taskController->restoreTask($taskId);
            }

            $catalog->restore();

            DB::commit();
            return response()->json([
                'action' => 'sucess',
                'msg' => 'Khôi phục danh sách thành công!!'
            ]);
        } catch (\Exception $e) {
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
        $allTask = Task::withTrashed()->where('catalog_id', $id)->get();
        if ($allTask->isEmpty()) {
            return response()->json([
                'action' => 'warning',
                'msg' => 'Danh sách không có task nào',
            ]);
        }
        $allTask->delete();
        return response()->json([
            'action' => 'success',
            'msg' => 'Lưu trữ tất cả task thành công',
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
}
