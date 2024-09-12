<?php

namespace App\Models;

use App\Enums\AccessEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'access',
        'image',
        'link_invite',
    ];
    protected $casts = [
        'access' => AccessEnum::class,
    ];
    public function WorkspaceMember()
    {
        return $this->hasMany(WorkspaceMember::class);
    }
}
