<?php

namespace App\Http\Controllers;

use App\Events\EventNotification;
use App\Models\CheckList;
use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Follow_member;
use App\Models\Tag;
use App\Models\Task;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ChecklistController extends Controller
{
    public function create(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $checkList = CheckList::create($data);

        $followMember = Follow_member::where('task_id', $checkList->task->id)
            ->where('follow', 1)
            ->get();
        foreach ($followMember as $member) {
            if ($member->user->id != Auth::id()) {
                event(new EventNotification("Nhiệm vụ " . $checkList->task->text . " đã thêm checklist ". $checkList->name.". Xem chi tiết! ", 'success', $member->user->id));
            }
        }
        return response()->json([
            'success' => "them thao tác thành công",
            'msg' => true,
            'checkList' => $checkList,
            'checkListId' => $checkList->id,
            'name' => $checkList->name,


        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkList = CheckList::query()->findOrFail($id);
        $data = $request->only(['name', 'task_id','progress']);
        $checkList->update($data);
        return response()->json([
            'success' => "update checkList thành công",
            'msg' => true
        ]);
    }


    public function updateChecklistItem(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkListItem = CheckListItem::query()->findOrFail($request->id);
        $data = $request->only(['reminder_date', 'end_date', 'start_date', 'is_complete']);
        $checkListItem->update($data);
        return response()->json([
            'success' => "update checkListItem thành công",
            'msg' => true
        ]);
    }

    public function addMemberChecklist(Request $request)
    {
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $checkListItemMember=CheckListItemMember::create($data);
//        dd($checkListItemMember);
        return response()->json([
            'success' => "them CheckListItemMember thành công",
            'msg' => true,
            'checkListItemMember'=>$checkListItemMember
        ]);
    }

    public function deleteMemberChecklist(Request $request)
    {
//        if (session('view_only', false)) {
//            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
//        }
//        session()->forget('view_only');
        $checklistItem = CheckListItemMember::where('check_list_item_id', $request->check_list_item_id)
            ->where('user_id', $request->user_id)
            ->first();
        $checklistItem->delete();
        return response()->json([
            'success' => "xoas CheckListItemMember thành công",
            'msg' => true
        ]);
    }

    public function getFormDateChecklistItem( $checkListItemId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checklistItem = CheckListItem::findOrFail($checkListItemId);
//        dd( $checklistItem);

        $htmlForm = View::make('dropdowns.dateCheckList', [
            'checklistItem' => $checklistItem
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

    public function deleteChecklist(Request $request)

    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkList = CheckList::with(['checkListItems.checkListItemMembers'])
            ->where('id', $request->id)
            ->first();
        if ($checkList) {
            foreach ($checkList->checkListItems as $checkListItem) {
                foreach ($checkListItem->checkListItemMembers as $checkListMember) {
                    $checkListMember->delete();
                }
                $checkListItem->delete();
            }

            $checkList->delete();

            return response()->json([
                'success' => "Xóa CheckList thành công",
                'msg' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => "CheckList không tồn tại"
            ], 404);
        }
    }

//    checklist item
    public function createChecklistItem(Request $request)
    {

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $checkListItem = CheckListItem::create($data);

        $followMember = Follow_member::where('task_id', $checkListItem->checkList->task->id)
            ->where('follow', 1)
            ->get();
        foreach ($followMember as $member) {
            if ($member->user->id != Auth::id()) {
                event(new EventNotification("Nhiệm vụ " . $checkListItem->checkList->task->text . " đã thêm checklist " . $checkListItem->name . ". Xem chi tiết! ", 'success', $member->user->id));
            }
        }
        return response()->json([
            'success' => "them ChecklistItem thành công",
            'msg' => true,
            'checkListItem' => $checkListItem,
            'check_list_id' => $checkListItem->check_list_id,
            'id' => $checkListItem->id,
            'is_complete' => $checkListItem->is_complete,
            'start_date' => $checkListItem->start_date,
            'end_date' => $checkListItem->end_date,
            'reminder_date' => $checkListItem->reminder_date,
            'task_id' => CheckList::with('checkListItems')
                ->where('id', $checkListItem->check_list_id)->value('task_id'),
        ]);
    }
    public function deleteChecklistItem(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkListItem = CheckListItem::with(['checkListItemMembers'])
            ->where('id', $request->id)
            ->first();
        if ($checkListItem) {
            foreach ($checkListItem->checkListItemMembers as $checkListMember) {
                $checkListMember->delete();
            }

            $checkListItem->delete();

            return response()->json([
                'success' => "Xóa checkListItem thành công",
                'msg' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => "checkListItem không tồn tại"
            ], 404);
        }
    }


//    call giao diện
    public function getFormCheckList($taskId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        if (!$taskId) {
            return response()->json(['error' => 'Task ID is missing'], 400);
        }

        $htmlForm = View::make('dropdowns.checklist', ['taskId' => $taskId])->render();

        // Trả về HTML cho frontend
        return response()->json(['html' => $htmlForm]);
    }


    public function getFormDate($checkListItemId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checklistItem = CheckListItem::findOrFail($checkListItemId);
//        dd( $checklistItem);

        $htmlForm = View::make('dropdowns.dateCheckList', [
            'checklistItem' => $checklistItem
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

}
