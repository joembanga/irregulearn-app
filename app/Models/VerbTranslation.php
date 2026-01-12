<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $verb_id
 * @property string $lang_code
 * @property string $translation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation whereTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslation whereVerbId($value)
 *
 * @mixin \Eloquent
 */
class VerbTranslation extends Model
{
    //
}
