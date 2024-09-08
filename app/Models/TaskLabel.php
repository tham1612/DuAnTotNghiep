<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskLabel extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'label_id',
    ];
}
