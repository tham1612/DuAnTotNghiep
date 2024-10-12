<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_list_id',
        'name',
        'parent_id',
        'is_complete',
        'start_date',
        'end_date',
        'reminder_date',
    ];
    protected $casts = [
        'is_complete'=> 'boolean',

    ];
    public function members()
    {
        return $this->belongsToMany(User::class, 'check_list_item_members', 'check_list_item_id', 'user_id');
    }
    public function checkListItemMembers()
    {
        return $this->hasMany(CheckListItemMember::class, 'check_list_item_id');
    }

}
