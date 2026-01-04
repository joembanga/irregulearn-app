<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerbSentence extends Model
{
    protected $fillable = ['verb_id', 'sentence', 'missing_word', 'form'];

    public function verb()
    {
        return $this->belongsTo(Verb::class);
    }
}
