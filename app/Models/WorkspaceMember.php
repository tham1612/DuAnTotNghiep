<?php

namespace App\Models;

use App\Enums\AccessEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkspaceMember extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'workspace_id',
        'authorize',
        'invite',
    ];
    protected $casts = [
        'authorize' => 'boolean',
    ];
}
