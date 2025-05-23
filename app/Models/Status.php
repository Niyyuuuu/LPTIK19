<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = "status";
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'status',
    ];
    
    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'status', 'id');
    }

}
