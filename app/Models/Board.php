<?php

namespace App\Models;

use App\Enums\AccessEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'workspace_id',
        'access',
        'name',
        'description',
        'image',
        'comment_permission',
        'member_permission',
        'archiver_permission',
        'edit_board',
        'link_invite',
        'complete'
    ];

    protected $casts = [
        'comment_rights' => 'boolean',
        'add_delete_rights' => 'boolean',
        'edit_workspace' => 'boolean',
        'access' => AccessEnum::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'board_members', 'board_id', 'user_id')->withPivot('authorize');
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    // Định nghĩa quan hệ với BoardMembers nếu cần
    public function boardMembers()
    {
        return $this->hasMany(BoardMember::class)->where('is_accept_invite', 0);
    }

    public function catalogs()
    {
        return $this->hasMany(Catalog::class);
    }

    public function taskLinks()
    {
        return $this->morphMany(TaskLink::class, 'linkable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'board_members', 'board_id', 'user_id')// Nếu bảng `board_members` có cột `is_star`
        ->withPivot('authorize', 'is_star', 'invite', 'is_accept_invite')
            ->withTimestamps();    // Nếu bảng trung gian có các cột timestamps
    }
}
