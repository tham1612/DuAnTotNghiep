<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    // Liên kết với user gửi tin nhắn
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Liên kết với user nhận tin nhắn
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
