<?php

namespace App\Http\Controllers;

use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Task;
use App\Models\TaskMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MemberController extends Controller
{
    protected $googleApiClient;

    public function __construct(GoogleApiClientController $googleApiClient)
    {
        $this->googleApiClient = $googleApiClient;
    }

    // task
    public function addMemberTask(Request $request)
    {

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');

        $data = $request->all();
        $task = Task::query()->findOrFail($data['task_id']);
        $data['text'] = $task->text;
        $data['description'] = $task->description;
        $existingMember = TaskMember::where('task_id', $request->task_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingMember) {
            return response()->json([
                'success' => false,
                'message' => 'Thành viên đã tồn tại trong task.'
            ], 400);
        }

        try {
            TaskMember::query()->insert([
                "user_id" => $data['user_id'],
                "task_id" => $data['task_id']
            ]);
            $this->googleApiClient->updateEvent($data); // cập nhật người được giao việc
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thêm thành viên thành công.'
        ]);
    }

    public function deleteTaskMember(Request $request)
    {

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->all();

        $taskMember = TaskMember::query()
            ->where('task_id', $data['task_id'])
            ->where('user_id', $data['user_id'])
            ->first();
        $task = Task::query()->where('id', $data['task_id'])->select('text', 'description')->first();
        $data['text'] = $task->text;
        $data['description'] = $task->description;
        if (!$taskMember) {
            return response()->json([
                'success' => false,
                'message' => 'Thành viên không tồn tại trong task này.'
            ], 404);
        }
        try {
            TaskMember::query()
                ->where('task_id', $data['task_id'])
                ->where('user_id', $data['user_id'])
                ->delete();
            $this->googleApiClient->updateEvent($data); // cập nhật người được giao việc
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Xóa thành viên thành công.'
        ], 200);
    }

    //    checklist item
    public function addMemberChecklistItem(Request $request)
    {
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        CheckListItemMember::create($data);
        return response()->json([
            'success' => "them CheckListItemMember thành công",
            'msg' => true
        ]);
    }

    public function deleteMemberChecklistItem(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checklistItem = CheckListItemMember::where('check_list_item_id', $request->check_list_item_id)
            ->where('user_id', $request->user_id)
            ->first();
        $checklistItem->delete();
        return response()->json([
            'success' => "xoas CheckListItemMember thành công",
            'msg' => true
        ]);
    }

    // call giao diện
    public function getFormMemberTask(Request $request, $taskId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $boardMembers0 = session('boardMembers_' . $request->boardId);
        $boardMembers = json_decode(json_encode($boardMembers0));

        $task = json_decode(json_encode(Task::with('members')->findOrFail($taskId)));
//        dd( $boardMembers);

        $htmlForm = View::make('dropdowns.member', [
            'taskId' => $taskId,
            'boardMembers' => $boardMembers,
            'task' => $task
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

    public function getFormMemberChecklistItem( $checkListItemId)
    {
        $checklistItem = CheckListItem::findOrFail($checkListItemId);
//        dd( $checklistItem);
        $boardMembers0=$checklistItem->checkList->task->catalog->board->members->unique('id');
        $boardMembers = json_decode(json_encode($boardMembers0));
        $htmlForm = View::make('dropdowns.memberCheckList', [
            'checkListItemId' => $checkListItemId,
            'boardMembers' => $boardMembers,
            'checklistItem' => $checklistItem
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }
}
