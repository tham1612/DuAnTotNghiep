<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'board_id',
        'name',
        'image',
        'position',
    ];
    public function taskLinks()
    {
        return $this->morphMany(TaskLink::class, 'linkable');
    }
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }
}
