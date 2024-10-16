<?php

namespace App\Models;

use App\Enums\AccessEnum;
use App\Enums\IndexEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

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
        'end_date',
        'reminder_date',
        'parent',
        'sortorder',
        'id_google_calendar',
        'creator_email'
    ];
    protected $casts = [
        'priority' => IndexEnum::class,
        'risk' => IndexEnum::class,
    ];
    protected $appends = ["open"];

    protected $dates = ['start_date', 'end_date'];

    public function getOpenAttribute()
    {
        return true;
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'task_members');
    }

    public function membersFl()
    {
        return $this->belongsToMany(User::class, 'follow_members')->withPivot('follow');
    }
    public function followMembers()
    {
        return $this->hasMany(Follow_member::class);
    }
    public function checkLists()
    {
        return $this->hasMany(CheckList::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
