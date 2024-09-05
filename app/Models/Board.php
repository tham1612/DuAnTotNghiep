<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'workspace_id',

        'access',
        'name',
        'description',
        'image',
        'comment_rights',
        'add_delete_rights',
        'edit_workspace',
        'link_invite',
        'complete'
    ];
    protected $casts = [
        'comment_rights' => 'boolean',
         'add_delete_rights' => 'boolean',
        'edit_workspace' => 'boolean',
    ];
    public function taskLinks()
    {
        return $this->morphMany(TaskLink::class, 'linkable');
    }
}
