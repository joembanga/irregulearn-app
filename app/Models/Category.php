<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function verbs()
    {
        return $this->belongsToMany(Verb::class);
    }
}
