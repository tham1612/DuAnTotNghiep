<?php

namespace App\Http\Controllers;

use App\Events\EventNotification;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Task;
use App\Models\TaskMember;
use App\Notifications\AddMemberChecklistNotification;
use App\Notifications\DeleteMemberChecklistNotification;
use App\Notifications\TaskAddMemberNotification;
use App\Notifications\TaskDeleteMemberNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    protected $googleApiClient;

    public function __construct(GoogleApiClientController $googleApiClient, AuthorizeWeb $authorizeWeb)
    {
        $this->googleApiClient = $googleApiClient;
        $this->authorizeWeb = $authorizeWeb;
    }

    // task
    public function addMemberTask(Request $request)
    {

        $data = $request->all();

        $task = Task::query()->findOrFail($data['task_id']);
        $authorize = $this->authorizeWeb->authorizeDeleteCreateMember($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }

        $data['id'] = $task->id;
        $data['text'] = $task->text;
        $data['description'] = $task->description;
        $data['id_google_calendar'] = $task->id_google_calendar;
        $data['start_date'] = $task->start_date;
        $data['end_date'] = $task->end_date;
        $existingMember = TaskMember::where('task_id', $data['task_id'])
            ->where('user_id', $data['user_id'])
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
            //Thông báo
            $taskMemberIsSend = TaskMember::with(['task.catalog.board', 'user'])->where('task_id', $data['task_id'])
                ->where('user_id', $data['user_id'])
                ->first();
            $userName = Auth::user();
            $taskMemberIsSend->user->notify(new TaskAddMemberNotification($taskMemberIsSend->task, $userName));
            if ($taskMemberIsSend->user->id != Auth::id()) {
                event(new EventNotification("Bạn đã được thêm nhiệm vụ " . $taskMemberIsSend->task->text, 'success', $taskMemberIsSend->user->id));
            }
            if (Auth::user()->access_token) {
                if ($task->id_google_calendar) {
//                    dd($data);
                    $this->googleApiClient->updateEvent($data);
                } else {
//                    dd(123);
                    $this->googleApiClient->createEvent($data);
                }
            }


        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        return response()->json([
            'msg' => 'thêm  thành viên vô task thành công !',
            'action' => 'success',
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

        $task = Task::query()->where('id', $data['task_id'])->first();
        $authorize = $this->authorizeWeb->authorizeDeleteCreateMember($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }

        $taskMember = TaskMember::query()
            ->where('task_id', $data['task_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        $data['text'] = $task->text;
        $data['description'] = $task->description;
        $data['start_date'] = $task->start_date;
        $data['end_date'] = $task->end_date;
        $data['id_google_calendar'] = $task->id_google_calendar;
        if (!$taskMember) {
            return response()->json([
                'success' => false,
                'message' => 'Thành viên không tồn tại trong task này.'
            ], 404);
        }
        try {
            //Thông báo
            $taskMemberIsSend = TaskMember::with(['task.catalog.board', 'user'])->where('task_id', $data['task_id'])
                ->where('user_id', $data['user_id'])
                ->first();
            $userName = Auth::user();
            $taskMemberIsSend->user->notify(new TaskDeleteMemberNotification($taskMemberIsSend->task, $userName));
            if ($taskMemberIsSend->user->id != Auth::id()) {
                event(new EventNotification("Bạn đã bị xóa khỏi nhiệm vụ " . $taskMemberIsSend->task->text, 'error', $taskMemberIsSend->user->id));
            }
            TaskMember::query()
                ->where('task_id', $data['task_id'])
                ->where('user_id', $data['user_id'])
                ->delete();

            if (Auth::user()->access_token) {
                if ($task->id_google_calendar) {
//                    dd($data);
                    $this->googleApiClient->updateEvent($data);
                } else {
//                    dd(123);
                    $this->googleApiClient->createEvent($data);
                }
            }

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        return response()->json([
            'msg' => 'xóa thành viên khỏi task thành công !',
            'action' => 'success',
            'success' => true,
            'message' => 'Xóa thành viên thành công.'
        ], 200);
    }

    //    checklist item
    public function addMemberChecklistItem(Request $request)
    {
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $checkListItemMember = CheckListItemMember::create($data);

        //Thông báo
        $checkListItemMemberIsSend = CheckListItemMember::with(['checkListItem.checkList.task.catalog.board', 'user'])->where('check_list_item_id', $data['check_list_item_id'])
            ->where('user_id', $data['user_id'])
            ->first();
        $userName = Auth::user();
        $checkListItemMemberIsSend->user->notify(new AddMemberChecklistNotification($checkListItemMemberIsSend, $userName));
        if ($checkListItemMemberIsSend->user->id != Auth::id()) {
            event(new EventNotification("Bạn đã được thêm vào checklist " . $checkListItemMemberIsSend->checkListItem->name, 'success', $checkListItemMemberIsSend->user->id));
        }
        $userImage = $checkListItemMember->user->image ?? null;
        return response()->json([
            'success' => "them CheckListItemMember thành công",
            'msg' => true,
            'userImage' => $userImage,
            'userName' => $checkListItemMember->user->name
        ]);
    }

    public function deleteMemberChecklistItem(Request $request)
    {
        Log::debug($request->all());

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');

        //Thông báo
        $checkListItemMemberIsSend = CheckListItemMember::with(['checkListItem.checkList.task.catalog.board', 'user'])
            ->where('check_list_item_id', $request->check_list_item_id)
            ->where('user_id', $request->user_id)
            ->first();
        $userName = Auth::user();

        $checkListItemMemberIsSend->user->notify(new DeleteMemberChecklistNotification($checkListItemMemberIsSend, $userName));
        if ($checkListItemMemberIsSend->user->id != Auth::id()) {
            event(new EventNotification("Bạn đã bị xóa khỏi checklist " . $checkListItemMemberIsSend->checkListItem->name, 'error', $checkListItemMemberIsSend->user->id));
        }
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
        //        $boardMembers0 = session('boardMembers_' . $request->boardId);
//        $boardMembers = json_decode(json_encode($boardMembers0));
        $boardMembers = BoardMember::with('user')
            ->where('board_id', $request->boardId)
            ->where('authorize', '!=', 'Viewer')
            ->get();

        $task = json_decode(json_encode(Task::with('members')->findOrFail($taskId)));
        //        dd( $boardMembers);

        $htmlForm = View::make('dropdowns.member', [
            'taskId' => $taskId,
            'boardMembers' => $boardMembers,
            'task' => $task
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

    public function getFormMemberChecklistItem($checkListItemId)
    {
        $checklistItem = CheckListItem::findOrFail($checkListItemId);
        //        dd( $checklistItem);
        $boardMembers0 = $checklistItem->checkList->task->catalog->board->members->unique('id');
        $boardMembers = json_decode(json_encode($boardMembers0));
        $htmlForm = View::make('dropdowns.memberCheckList', [
            'checkListItemId' => $checkListItemId,
            'boardMembers' => $boardMembers,
            'checklistItem' => $checklistItem
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }
}
