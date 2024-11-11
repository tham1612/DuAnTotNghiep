<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Catalog;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskTag;
use App\Models\TemplateBoard;
use App\Models\TemplateCatalog;
use App\Models\TemplateTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public function createBoardTemplate(Request $request)
    {
//        dd($request->all());
        $data = $request->all();
        $boardTemplate = TemplateBoard::query()->findOrFail($data['board_template_id']);
        $uuid = Str::uuid();
        $token = Str::random(40);
        $data['link_invite'] = url("taskflow/invite/b/{$uuid}/{$token}");

        try {
            DB::beginTransaction();
            $boardNew = Board::query()->create($data);

            BoardMember::query()->create([
                'user_id' => auth()->id(),
                'board_id' => $boardNew->id,
                'authorize' => 'Owner',
                'invite' => now(),
            ]);


            $catalogOld = TemplateCatalog::query()->where('template_board_id', $data['board_template_id'])->get();
            foreach ($catalogOld as $catalog) {
                $catalogNew = Catalog::query()->create([
                    'board_id' => $boardNew->id,
                    'name' => $catalog['name'],
                    'image' => $catalog['image'],
                    'position' => $catalog['position'],
                ]);
                $taskOld = TemplateTask::query()->where('template_catalog_id', $catalog['id'])->get();
                if ($taskOld->isNotEmpty() && $data['isTask']) {
                    foreach ($taskOld as $task) {
                        Task::query()->create([
                            'catalog_id' => $catalogNew->id,
                            'text' => $task['title'],
                            'description' => $task['description'],
                            'position' => $task['position'],
                            'image' => $task['image'],
                            'priority' => $task['priority'],
                            'risk' => $task['risk'],
                            'progress' => 0,
                            'start_date' => $task['start_date'],
                            'end_date' => $task['end_date'],
                            'parent' => $task['parent'],
                            'sortorder' => $task['sortorder'],
                            'id_google_calendar' => $task['id_google_calendar'],
                            'creator_email' => Auth::user()->email,
                        ]);

                    }
                }
            }


//            if ($data['isTag']) {
//                $tagOld = Tag::query()->where('board_id', $data['id'])->get();
//                foreach ($tagOld as $tag) {
//                    Tag::query()->create([
//                        'board_id' => $boardNew->id,
//                        'color_code' => $tag['color_code'],
//                        'name' => $tag['name'],
//                    ]);
//                }
//            }
            // ghi lại hoạt động của bảng
            activity('Người dùng đã tạo bảng ')
                ->performedOn($boardNew) // đối tượng liên quan là bảng vừa tạo
                ->causedBy(Auth::user()) // ai là người thực hiện hoạt động này
                ->withProperties(['workspace_id' => $boardNew->workspace_id]) // Lưu trữ workspace_id vào properties
                ->log('Đã tạo bảng mới: ' . $boardNew->name); // Nội dung ghi log


            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Tạo bảng thành công!!',
                'board_id' => $boardNew->id
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['action' => 'error',
                'msg' => 'Có lỗi xảy ra!!']);
        }
    }
}
