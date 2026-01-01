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
        'category'
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

    // app/Models/Verb.php

    public function favoritedByUsers()
    {
        // On lie le verbe aux utilisateurs via la table 'stared_verbs'
        return $this->belongsToMany(User::class, 'stared_verbs')
            ->withTimestamps();
    }

    public function getPopularityStats()
    {
        $user = Auth::user();
        $totalUsers = User::count();
        $favoritedByCount = $this->favoritedByUsers()->count(); // Assure-toi d'avoir la relation inverse dans Verb

        $percentage = ($totalUsers > 0) ? ($favoritedByCount / $totalUsers) * 100 : 0;

        // Récupérer les amis de l'utilisateur connecté qui aiment ce verbe
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
}
