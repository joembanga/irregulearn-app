<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verb extends Model
{
    protected $fillable = [
        'infinitive',
        'past_simple',
        'past_participle',
        'translation',
        'level',
        'category'
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class);
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
