<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permasalahan extends Model
{
    use HasFactory;

    protected $table = 'permasalahan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'deskripsi',
    ];

    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
}
