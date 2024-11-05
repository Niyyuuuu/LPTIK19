<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Relationship: A Category has many FAQs.
     */
    public function faq()
    {
        return $this->hasMany(Faq::class);
    }
    public function help()
    {
        return $this->hasMany(Help::class);
    }
}
