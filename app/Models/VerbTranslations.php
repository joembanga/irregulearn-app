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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations whereTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VerbTranslations whereVerbId($value)
 *
 * @mixin \Eloquent
 */
class VerbTranslations extends Model
{
    //
}
