<?php

namespace App\Models;

use App\Models\Traits\HasEncryptedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory, HasEncryptedAttributes;

    protected $fillable = ['chat_room_id', 'user_id', 'message', 'attachment_path'];

    protected $encrypted = ['message'];

    protected $dates = ['read_at'];

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}