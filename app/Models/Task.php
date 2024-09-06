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
        'title',
        'description',
        'position',
        'image',
        'priority',
        'risk',
        'complete',
    ];
    protected $casts = [
         'priority' => IndexEnum::class,
        'risk' => IndexEnum::class,
    ];

}
