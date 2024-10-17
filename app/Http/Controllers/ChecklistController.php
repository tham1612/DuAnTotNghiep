<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Task;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        CheckList::create($data);
        return response()->json([
            'success' => "them thao tác thành công",
             'msg' => true
        ]);
    }
    public function createChecklistItem(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        CheckListItem::create($data);
        return response()->json([
            'success' => "them ChecklistItem thành công",
             'msg' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $checkList = CheckList::query()->findOrFail($id);
        $data=$request->only(['name','task_id']);
        $checkList->update($data);
        return response()->json([
            'success' => "update checkList thành công",
             'msg' => true
        ]);
    }
    public function updateChecklistItem(Request $request, string $id)
    {
        $checkListItem = CheckListItem::query()->findOrFail($id);
        $data=$request->only(['reminder_date','end_date','start_date','is_complete']);
        $checkListItem->update($data);
        return response()->json([
            'success' => "update checkListItem thành công",
             'msg' => true
        ]);
    }
    public function addMemberChecklist(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        CheckListItemMember::create($data);
        return response()->json([
            'success' => "them CheckListItemMember thành công",
             'msg' => true
        ]);
    }
    public function deleteMemberChecklist( Request $request )
    {
        $checklistItem = CheckListItemMember::where('check_list_item_id',$request->check_list_item_id)
            ->where('user_id',$request->user_id)
            ->first();
        $checklistItem->delete();
        return response()->json([
            'success' => "xoas CheckListItemMember thành công",
             'msg' => true
        ]);
    }
////    public function getProgress( Request $request )
////    {
////        $checklistItem = CheckListItemMember::where('check_list_item_id',$request->check_list_item_id)
////            ->where('user_id',$request->user_id)
////            ->first();
////        $checklistItem->delete();
////        return response()->json([
////            'success' => "xoas CheckListItemMember thành công",
////            'msg' => true
////        ]);
//    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
