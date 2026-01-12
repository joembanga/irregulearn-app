<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property string $slug
 * @property string $infinitive
 * @property string $past_simple
 * @property string $past_participle
 * @property string $level
 * @property array<array-key, mixed>|null $description
 * @property string|null $phonetic
 * @property string|null $source_url
 * @property string|null $details_origin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VerbExample> $communityExamples
 * @property-read int|null $community_examples_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $favoritedByUsers
 * @property-read int|null $favorited_by_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VerbSentence> $sentences
 * @property-read int|null $sentences_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VerbTranslations> $translations
 * @property-read int|null $translations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereDetailsOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereInfinitive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb wherePastParticiple($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb wherePastSimple($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb wherePhonetic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Verb whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Verb extends Model
{
    public $translation = '';

    protected $fillable = [
        'infinitive',
        'past_simple',
        'past_participle',
        'level',
        'category',
        'description',
        'source_url',
        'phonetic',
        'details_origin',
    ];

    protected $casts = ['description' => 'array'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('mastered');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function isLearnedBy(User $user)
    {
        return ! $user->learnedVerbs()->wherePivot('verb_id', $this->id)->get()->isEmpty();
    }

    public function favoritedByUsers()
    {
        // Link verb to users via 'stared_verbs' table
        return $this->belongsToMany(User::class, 'stared_verbs')
            ->withTimestamps();
    }

    /**
     * Get popularity stats for the verb.
     */
    public function getPopularityStats(): array
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $totalUsers = User::count();
        $favoritedByCount = $this->favoritedByUsers()->count();

        $percentage = ($totalUsers > 0) ? ($favoritedByCount / $totalUsers) * 100 : 0;

        $friendsWhoFavorited = collect();
        $friendsCount = 0;

        if ($user && method_exists($user, 'friends')) {
            $friends = $user->friends();
            $friendIds = $friends->pluck('id');

            $friendsWhoFavorited = $this->favoritedByUsers()
                ->whereIn('users.id', $friendIds)
                ->take(3)
                ->get();

            $friendsCount = $this->favoritedByUsers()
                ->whereIn('users.id', $friendIds)
                ->count();
        }

        return [
            'percentage' => round($percentage),
            'friends' => $friendsWhoFavorited,
            'friends_count' => $friendsCount,
        ];
    }

    public function communityExamples()
    {
        return $this->hasMany(VerbExample::class)->orderBy('likes_count', 'desc');
    }

    public function sentences()
    {
        return $this->hasMany(VerbSentence::class);
    }

    public function translations()
    {
        return $this->hasMany(VerbTranslations::class);
    }
}
