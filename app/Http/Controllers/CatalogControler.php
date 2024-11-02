<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogRequest;
use App\Models\Board;
use App\Models\Catalog;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class CatalogControler extends Controller
{
    public $taskController;

    public function __construct(TaskController $taskController)
    {
        $this->taskController = $taskController;
    }

    const PATH_UPLOAD = 'catalogs.';

    public function store(StoreCatalogRequest $request)
    {

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');

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
        return back()
            ->with('success', 'Thêm mới danh sách thành công vào bảng');


    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
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
        Log::debug('catalog work');
        $catalog = Catalog::withTrashed()->findOrFail($id);

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
            Catalog::withTrashed()->findOrFail($id)->restore();

            DB::commit();

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
}
