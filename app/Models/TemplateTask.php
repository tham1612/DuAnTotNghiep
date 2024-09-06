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
        'title',
        'description',
        'position',
        'image',
        'priority',
        'risk',

    ];
    protected $casts = [
        'priority' => IndexEnum::class,
        'risk' => IndexEnum::class,
    ];
    public function templateDateable()
    {
        return $this->morphMany(TemplateDateable::class, ' dateable');
    }
}
