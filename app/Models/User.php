<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];
    public function WorkspaceMember()
    {
        return $this->hasMany(WorkspaceMember::class);
    }
//    kieemr tra xem nguoiwf dung dax cso workspace chuaw
    public function hasWorkspace()
    {
        $userId = Auth::id();
        $isWorkspace = WorkspaceMember::where('user_id', $userId)
            ->where('authorize', 1)
            ->exists();
        return $isWorkspace ? 1 : 0;
    }
}
