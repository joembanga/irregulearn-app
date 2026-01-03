<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerbExample extends Model
{
    protected $fillable = [
        'verb_id',
        'user_id',
        'body',
        'xp_given'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
