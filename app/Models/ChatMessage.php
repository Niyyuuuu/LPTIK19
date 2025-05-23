<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['tiket_id', 'user_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}
