<?php

namespace App\Models;

use App\Enums\IndexEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateTask extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_catalog_id',
        'text',
        'description',
        'position',
        'image',
        'priority',
        'risk',
        'progress',
        'start_date',
        'start_date',
        'parent',
        'sortorder'
    ];
    protected $casts = [
        'priority' => IndexEnum::class,
        'risk' => IndexEnum::class,
    ];
}
