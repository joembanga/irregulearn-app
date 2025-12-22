<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'xp_total',
        'xp_balance',
        'lives',
        'role',
        'avatar',
        'current_streak',
        'daily_target'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_life_lost_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Récupérer les amis (Classmates)
    public function classmates()
    {
        // On récupère les utilisateurs présents dans la table classmates pour cet utilisateur
        return $this->belongsToMany(User::class, 'classmates', 'user_id', 'friend_id');
    }

    // Récupérer les demandes d'amis en attente (qu'on a reçues)
    public function friendRequests()
    {
        return $this->hasMany(Friendship::class, 'recipient_id')
            ->where('status', 'pending');
    }

    // Historique des points reçus
    public function receivedTransfers()
    {
        return $this->hasMany(PointTransfer::class, 'receiver_id');
    }

    public function dailyVerbs()
    {
        return $this->belongsToMany(Verb::class, 'daily_verbs')
            ->withPivot('is_learned', 'day')
            ->wherePivot('day', now()->toDateString());
    }

    public function generateDailyVerbs()
    {
        // Si l'utilisateur n'a pas encore de verbes pour aujourd'hui
        if ($this->dailyVerbs()->count() === 0) {
            // On prend 5 verbes au hasard que l'utilisateur n'a pas encore "maîtrisés" 
            // (Pour simplifier ici, on prend juste 5 verbes aléatoires)
            $verbs = Verb::inRandomOrder()->take(5)->get();

            foreach ($verbs as $verb) {
                $this->dailyVerbs()->attach($verb->id, ['day' => now()->toDateString()]);
            }
        }
    }

    public function refreshLives()
    {
        $maxLives = 5;
        $minutesPerLife = 60; // 1 vie par heure

        // Si l'utilisateur a moins de 5 vies et qu'il a un timer de début
        if ($this->lives < $maxLives && $this->last_life_lost_at) {

            // On calcule le nombre de minutes écoulées depuis la perte de la première vie
            $minutesElapsed = now()->diffInMinutes($this->last_life_lost_at);
            $livesToGain = floor($minutesElapsed / $minutesPerLife);

            if ($livesToGain > 0) {
                $newLives = min($maxLives, $this->lives + $livesToGain);

                // On met à jour
                $this->lives = $newLives;

                // Si on a récupéré toutes les vies, on reset le timer
                // Sinon, on décale le timer pour ne pas perdre les minutes entamées
                if ($newLives >= $maxLives) {
                    $this->last_life_lost_at = null;
                } else {
                    $this->last_life_lost_at = $this->last_life_lost_at->addMinutes($livesToGain * $minutesPerLife);
                }

                $this->save();
            }
        }
    }
}
