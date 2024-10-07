<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\AuthorizeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'fullName',
        'phone ',
        'image',
        'introduce',
        'address',
        'email',
        'password',
        'social_id',
        'social_name',
        'access_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'access_token' => 'hashed',
    ];

    public function WorkspaceMember()
    {
        return $this->hasMany(WorkspaceMember::class);
    }

    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_members', 'user_id', 'workspace_id');
    }

    public function Board()
    {
        return $this->belongsToMany(Board::class);
    }

    public function BoardMember()
    {
        return $this->hasMany(BoardMember::class);
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_members')->withPivot('follow');
    }

    //    kieemr tra xem nguoiwf dung dax cso workspace chuaw
    public function hasWorkspace()
    {
        $userId = Auth::id();


        $isWorkspace = WorkspaceMember::query()
            ->where('user_id', $userId)
            ->exists();
        return $isWorkspace;
    }

    //    public function getWorkspace()
    //    {
    //        // Lấy các workspace mà người dùng hiện tại là thành viên hoặc owner
    //        return Workspace::whereHas('users', function ($query) {
    //            $query->where('user_id', $this->id)
    //                ->whereIn('authorize', [0, 1]); // authorize = 0 hoặc 1
    //        })->get();
    //    }
}
