<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;
    protected $fillable=[
        'task_id',
        'name',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function checkListItems()
    {
        return $this->hasMany(CheckListItem::class);
    }
}
