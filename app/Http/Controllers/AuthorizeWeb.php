<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardMember;
use App\Models\WorkspaceMember;
use Illuminate\Http\Request;

class AuthorizeWeb extends Controller
{
    public function authorizeDeleteCreateMember($boardId)
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $boardId)
            ->value('authorize');

        $authorize = Board::query()
            ->findOrFail($boardId);

        if ($authorize->member_permission == 'board') {
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize->member_permission == 'owner') {
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        }
        return false;
    }

    public function authorizeEdit($boardId)
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $boardId)
            ->value('authorize');

        $authorize = Board::query()
            ->findOrFail($boardId);

        if ($authorize->edit_board == 'owner') {
            //       chỉ có quản trị viên
            return ($checkAuthorize == 'Owner' || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize->edit_board == 'board') {
            //       tất cả thành viên trong bảng
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize->edit_board == 'workspace') {
            //       tất cả thành viên trong workspace
            return true;
        }
        return false;
    }

    public function authorizeComment($boardId)
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $boardId)
            ->value('authorize');

        $authorize = Board::query()
            ->findOrFail($boardId);

        if ($authorize->comment_permission == 'owner') {
            //       chỉ có quản trị viên
            return ($checkAuthorize == 'Owner' || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize->comment_permission == 'board') {
            //       tất cả thành viên trong bảng
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize->comment_permission == 'workspace') {
            //       tất cả thành viên trong workspace
            return true;
        }
        return false;
    }

    public function authorizeArchiver($boardId)
    {
        $checkAuthorizeBoard = BoardMember::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $boardId)
            ->value('authorize');
        $checkAuthorizeWsp = WorkspaceMember::query()
            ->where('user_id', auth()->id())
            ->where('is_active', 1)
            ->where('authorize', 'Owner')
            ->value('authorize');
        $checkAuthorize = $checkAuthorizeWsp ? $checkAuthorizeWsp : $checkAuthorizeBoard;
        $authorize = Board::withTrashed()
            ->where('id', $boardId)
            ->first();
//        dd($checkAuthorizeWsp);
        if ($authorize->archiver_permission == 'board' && !empty($checkAuthorizeWsp)) {
//            owner của wsp có thể đóng bảng
            return true;
        } else if ($authorize->archiver_permission == 'board') {
            //            tất cả thành viên trong bảng
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize->archiver_permission == 'owner') {
            //            chỉ có quản trị viên với phó quản trị viên
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        }
        return false;
    }

    public function authorizeEditPermissionBoard($boardId)
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $boardId)
            ->first();
        return ($checkAuthorize->authorize == 'Owner' || $checkAuthorize->authorize == 'Sub_Owner')
            ? true
            : false;
    }

    public function authorizeCreateBoardOnWorkspace()
    {
        $checkAuthorize = WorkspaceMember::query()
            ->where('user_id', auth()->id())
            ->where('is_active', 1)
            ->first();
        if ($checkAuthorize) {
            return ($checkAuthorize->authorize == 'Owner' || $checkAuthorize->authorize == 'Sub_Owner' || $checkAuthorize->authorize == 'Member')
                ? true
                : false;
        }
        return false;
    }

    public function authorizeWorkspaceOwner()
    {
        $checkAuthorize = WorkspaceMember::query()
            ->where('user_id', auth()->id())
            ->where('is_active', 1)
            ->first();

        if ($checkAuthorize) {
            return $checkAuthorize->authorize == 'Owner'
                ? true
                : false;
        }
        return false;
    }

    public function authorizeEditWorkspace()
    {
        $checkAuthorize = WorkspaceMember::query()
            ->where('user_id', auth()->id())
            ->where('is_active', 1)
            ->first();

        if ($checkAuthorize) {
//            return $checkAuthorize->authorize == 'Owner' || $checkAuthorize->authorize == 'Sub_Owner'
//                ? true
//                : false;
            return $checkAuthorize->authorize == 'Owner'
                ? true
                : false;
        }
        return false;
    }
}
