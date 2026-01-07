<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'details_origin'
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
        return !$user->learnedVerbs()->wherePivot('verb_id', $this->id)->get()->isEmpty();
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
            'friends_count' => $friendsCount
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
