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
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('mastered');
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    
    public function isMasteredBy($user)
    {
        return $this->users->contains($user->id) && $this->users->find($user->id)->pivot->mastered;
    }
}
