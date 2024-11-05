<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category_id',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
