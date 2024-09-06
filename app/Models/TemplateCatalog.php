<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateCatalog extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_board_id',
        'name',
        'image',
        'position',
    ];
}
