<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateTaskTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_task_id',
        'template_tag_id',
    ];
}
