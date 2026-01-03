<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'verb_example_id', 'reason'];

    public function example()
    {
        return $this->belongsTo(VerbExample::class, 'verb_example_id');
    }
}
