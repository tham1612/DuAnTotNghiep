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
use App\Models\TemplateTag;
use App\Models\TemplateTask;
use App\Models\TemplateTaskTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    public $authorizeWeb;
    public function __construct(AuthorizeWeb $authorizeWeb)
    {
        $this->authorizeWeb = $authorizeWeb;
    }

    public function createBoardTemplate(Request $request)
    {
        $data = $request->all();

        $authorize = $this->authorizeWeb->authorizeCreateBoardOnWorkspace($data['workspace_id']);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền tạo bảng mẫu trong không gian làm việc này!!',
            ]);
        }
//        dd();
        $uuid = Str::uuid();
        $token = Str::random(40);
        $data['link_invite'] = url("taskflow/invite/b/{$uuid}/{$token}");

        try {
            DB::beginTransaction();
            $boardNew = Board::query()->create($data);

            // Create a new BoardMember entry
            BoardMember::query()->create([
                'user_id' => auth()->id(),
                'board_id' => $boardNew->id,
                'authorize' => 'Owner',
                'invite' => now(),
            ]);

            // Migrate TemplateTags to Tags
            $tagOld = TemplateTag::query()->where('template_board_id', $data['board_template_id'])->get();
            $tagMap = []; // This will store mapping between old TemplateTag IDs and new Tag IDs

            foreach ($tagOld as $tag) {
                $newTag = Tag::query()->create([
                    'board_id' => $boardNew->id,
                    'color_code' => $tag->color_code,
                    'name' => $tag->name,
                ]);

                // Store the mapping of old TemplateTag ID to new Tag ID
                $tagMap[$tag->id] = $newTag->id;
            }

            // Migrate TemplateCatalogs and their TemplateTasks to Catalogs and Tasks
            $catalogOld = TemplateCatalog::query()->where('template_board_id', $data['board_template_id'])->get();

            foreach ($catalogOld as $catalog) {
                $catalogNew = Catalog::query()->create([
                    'board_id' => $boardNew->id,
                    'name' => $catalog->name,
                    'image' => $catalog->image,
                    'position' => $catalog->position,
                ]);

                // Fetch and migrate TemplateTasks if `isTask` is set
                $taskOld = TemplateTask::query()->where('template_catalog_id', $catalog->id)->get();
                if ($taskOld->isNotEmpty() && !empty($data['isTask'])) {
                    foreach ($taskOld as $task) {
                        $taskNew = Task::query()->create([
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
                            'id_google_calendar' => null,
                            'creator_email' => Auth::user()->email,
                        ]);

                        // Migrate TemplateTaskTags to TaskTags
                        $taskTagOld = TemplateTaskTag::query()->where('template_task_id', $task->id)->get();
                        foreach ($taskTagOld as $taskTag) {
                            // Ensure the tag ID maps to the new Tag ID using the $tagMap
                            if (isset($tagMap[$taskTag->template_tag_id])) {
                                TaskTag::query()->create([
                                    'task_id' => $taskNew->id,
                                    'tag_id' => $tagMap[$taskTag->template_tag_id], // Use the new Tag ID
                                ]);
                            }
                        }
                    }
                }
            }

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
            return response()->json([
                'action' => 'error',
                'msg' => 'Có lỗi xảy ra!!'
            ]);
        }
    }
}
