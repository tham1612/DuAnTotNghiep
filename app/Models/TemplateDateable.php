<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateDateable extends Model
{
    use HasFactory;

    protected $fillable = [
        'dateable_id',
        'dateable_type',
        'start_date',
        'end_date',
        'reminder_date',
    ];
    public function dateable()
    {
        return $this->morphTo();
    }
}
