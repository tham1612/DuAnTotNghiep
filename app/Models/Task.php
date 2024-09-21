<?php

namespace App\Models;

use App\Enums\AccessEnum;
use App\Enums\IndexEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'catalog_id',
        'text',
        'description',
        'position',
        'image',
        'priority',
        'risk',
        'duration',
        'progress',
        'start_date',
        'parent',
        'sortorder',

    ];
    protected $casts = [
        'priority' => IndexEnum::class,
        'risk' => IndexEnum::class,
    ];
    protected $appends = ["open"];

    public function getOpenAttribute(){
        return true;
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'task_members')->withPivot('follow');
    }

}
