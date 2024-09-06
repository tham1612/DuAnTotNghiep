<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateCheckListItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_check_list_id',
        'name',
        'parent_id',
        'is_complete',

    ];
    protected $casts = [
        'is_complete'=> 'boolean',

    ];
    public function templateDateable()
    {
        return $this->morphMany(TemplateDateable::class, ' dateable');
    }
}
