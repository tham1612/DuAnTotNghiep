<?php

namespace App\Models;

use App\Enums\AccessEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'access',
        'image',
        'link_invite',
    ];
    protected $casts = [
        'access' => AccessEnum::class,
    ];
    public function WorkspaceMember()
    {
        return $this->hasMany(WorkspaceMember::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'workspace_members', 'workspace_id', 'user_id')
            ->withPivot('authorize');
    }

    public function boards()
    {
        return $this->hasMany(Board::class);
    }
    public function workspaceMembers()
    {
        return $this->hasMany(WorkspaceMember::class);
    }
}
