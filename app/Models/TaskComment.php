<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskComment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'task_id',
        'content',
        'image',
        'parent_id',
    ];
}
