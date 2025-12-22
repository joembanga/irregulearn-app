<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = ['type', 'question', 'correct_answer', 'options', 'points'];

    protected $casts = [
        'options' => 'array',
    ];

    public function verbs()
    {
        return $this->belongsToMany(Verb::class);
    }
}