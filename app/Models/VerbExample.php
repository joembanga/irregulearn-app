<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $verb_id
 * @property int $user_id
 * @property string $body
 * @property int $likes_count
 * @property int $xp_given
 * @property int $is_hidden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Verb $verb
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereVerbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbExample whereXpGiven($value)
 *
 * @mixin \Eloquent
 */
class VerbExample extends Model
{
    protected $fillable = [
        'verb_id',
        'user_id',
        'body',
        'xp_given',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verb()
    {
        return $this->belongsTo(Verb::class);
    }
}
