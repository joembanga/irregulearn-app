<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Verb extends Model
{
    protected $fillable = [
        'infinitive',
        'past_simple',
        'past_participle',
        'translation',
        'level',
        'category',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('mastered');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function isMasteredBy($user)
    {
        return $this->users->contains($user->id) && $this->users->find($user->id)->pivot->mastered;
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
    public function getPopularityStats()
    {
        $user = Auth::user();
        $totalUsers = User::count();
        $favoritedByCount = $this->favoritedByUsers()->count(); // Ensure inverse relationship exists in Verb

        $percentage = ($totalUsers > 0) ? ($favoritedByCount / $totalUsers) * 100 : 0;

        // Get friends of the connected user who like this verb
        $friendIds = $user->friends()->pluck('id');
        $friendsWhoFavorited = $this->favoritedByUsers()
            ->whereIn('user_id', $friendIds)
            ->take(3)
            ->get();

        return [
            'percentage' => round($percentage),
            'friends' => $friendsWhoFavorited,
            'friends_count' => $this->favoritedByUsers()->whereIn('user_id', $friendIds)->count()
        ];
    }

    public function communityExamples()
    {
        return $this->hasMany(VerbExample::class)->orderBy('likes_count', 'desc');
    }
}
