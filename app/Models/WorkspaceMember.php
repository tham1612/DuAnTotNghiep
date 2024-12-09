<?php

namespace App\Models;

use App\Enums\AccessEnum;
use App\Enums\AuthorizeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class WorkspaceMember extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'workspace_id',
        'authorize',
        'invite',
        'is_active',
        'is_accept_invite'
    ];
    protected $casts = [
        'authorize' => AuthorizeEnum::class,
        'is_active' => 'boolean',
        'is_accept_invite' => 'integer',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
    public function relatedBoardMembers()
    {
        return $this->hasMany(BoardMember::class, 'user_id', 'user_id');
    }

}
