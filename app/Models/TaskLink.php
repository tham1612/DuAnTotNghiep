<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskLink extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'task_id',
        'linkable_id',
        'linkable_type',
    ];
    public function linkable()
    {
        return $this->morphTo();
    }
}
