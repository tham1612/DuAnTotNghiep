<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow_member extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'task_id',
        'follow',
    ];
    protected $casts = [
        'follow' => 'boolean',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
