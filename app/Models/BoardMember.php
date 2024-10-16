<?php

namespace App\Models;

use App\Enums\AuthorizeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardMember extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'board_id',
        'authorize',
        'is_star',
        'follow',
        'invite',
        'is_accept_invite'
    ];
    protected $casts = [
       'is_star' => 'boolean',
        'follow' => 'boolean',
        'authorize' => AuthorizeEnum::class,

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function board()
    {
        return $this->belongsTo(Board::class);
    }


}
