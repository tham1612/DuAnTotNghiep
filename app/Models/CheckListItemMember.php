<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckListItemMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'check_list_item_id',
        'user_id'
    ];
    public function checkListItem()
    {
        return $this->belongsTo(CheckListItem::class, 'check_list_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
