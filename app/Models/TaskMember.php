<?php

namespace App\Models;

use App\Enums\IndexEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskMember extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
        'user_id',
        'task_id',
        'follow',
    ];
    protected $casts = [
        'follow' =>'boolean',

    ];
}
