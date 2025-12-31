<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaredVerb extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
