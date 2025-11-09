<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['konseling_id'];

    public function konseling()
    {
        return $this->belongsTo(Konseling::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}