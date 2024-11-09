<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateTag extends Model
{
    use HasFactory;

    protected $fillable = ['template_board_id', 'color_code', 'name'];

}
