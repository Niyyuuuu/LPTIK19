<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = "tiket";
    protected $primaryKey = "id";
    public $timestamps = true;

    protected $fillable = [
        'tanggal',
        'subjek',
        'permasalahan',
        'satker',
        'prioritas',
        'area',
        'pesan',
        'lampiran',
        'created_by',
        'status_id',
        'rating',
        'rating_comment',
        'technician_id',
    ];

    // Relasi ke model Satker
    public function satkerData()
    {
        return $this->belongsTo(Satker::class, 'satker', 'id');
    }

    public function statusData()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'tiket_id');
    }

}
