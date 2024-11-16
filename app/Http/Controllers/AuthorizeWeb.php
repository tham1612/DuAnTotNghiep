<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardMember;
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
    }

    public function authorizeArchiver($boardId)
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $boardId)
            ->value('authorize');

        $authorize = Board::query()
            ->where('id', $boardId)
            ->first()
            ? Board::query()
                ->where('id', $boardId)
                ->first()
            : Board::withTrashed()
                ->where('id', $boardId)
                ->first();

        if ($authorize->archiver_permission == 'board') {
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
}
