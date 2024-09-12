<?php

namespace App\Models;

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
    ];
    protected $casts = [
        'authorize' => 'boolean',
       'is_star' => 'boolean',
        'follow' => 'boolean',

    ];



}
