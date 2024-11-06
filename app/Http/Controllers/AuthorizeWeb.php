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
            ->value('authorize');

        $authorize = Board::query()
            ->findOrFail($boardId)
            ->value('member_permission');

        if ($authorize == 'board') {
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize == 'owner') {
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
            ->value('authorize');

        $authorize = Board::query()
            ->findOrFail($boardId)
            ->value('edit_board');

        if ($authorize == 'owner') {
            //       chỉ có quản trị viên
            return ($checkAuthorize == 'Owner' || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize == 'board') {
            //       tất cả thành viên trong bảng
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize == 'workspace') {
            //       tất cả thành viên trong workspace
            return true;
        }
    }

    public function authorizeComment($boardId)
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->value('authorize');

        $authorize = Board::query()
            ->findOrFail($boardId)
            ->value('comment_permission');


        if ($authorize == 'owner') {
            //       chỉ có quản trị viên
            return ($checkAuthorize == 'Owner' || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize == 'board') {
            //       tất cả thành viên trong bảng
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize == 'workspace') {
            //       tất cả thành viên trong workspace
            return true;
        }
    }

    public function authorizeArchiver($boardId)
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->value('authorize');

        $authorize = Board::query()
            ->where('id', $boardId)
            ->value('archiver_permission')
            ? Board::query()
                ->where('id', $boardId)
                ->value('archiver_permission')
            : Board::withTrashed()
                ->where('id', $boardId)
                ->value('archiver_permission');

        if ($authorize == 'board') {
//            tất cả thành viên trong bảng
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Member'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        } else if ($authorize == 'owner') {
//            chỉ có quản trị viên với phó quản trị viên
            return ($checkAuthorize == 'Owner'
                || $checkAuthorize == 'Sub_Owner')
                ? true
                : false;
        }
    }

    public function authorizeEditPermissionBoard()
    {
        $checkAuthorize = BoardMember::query()
            ->where('user_id', auth()->id())
            ->value('authorize');

        return ($checkAuthorize == 'Owner' || $checkAuthorize == 'Sub_Owner')
            ? true
            : false;
    }
}
