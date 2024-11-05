<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    use HasFactory;

    protected $table = 'table_satker';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nama_satker',
    ];

    
    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }       
}
