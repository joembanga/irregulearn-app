<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $verb_id
 * @property string $sentence
 * @property string $missing_word
 * @property string|null $form
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Verb $verb
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence whereForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence whereMissingWord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence whereSentence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbSentence whereVerbId($value)
 * @mixin \Eloquent
 */
class VerbSentence extends Model
{
    protected $fillable = ['verb_id', 'sentence', 'missing_word', 'form'];

    public function verb()
    {
        return $this->belongsTo(Verb::class);
    }
}
