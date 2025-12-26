<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ProfilePage extends Component
{
    public $user;
    public $rank;
    public $masteredCount;
    public $leaderboard;

    public function mount($username)
    {
        // On cherche l'utilisateur par son username (insensible à la casse)
        $this->user = User::where('username', $username)->firstOrFail();

        // Calcul du nombre de verbes maîtrisés
        $this->masteredCount = $this->user->verb()->wherePivot('mastered', true)->count();

        // Calcul du rang (Combientième est-il basé sur l'XP ?)
        $this->rank = User::where('xp_total', '>', $this->user->xp_total)->count() + 1;

        // Récupérer le TOP 5 pour la sidebar
        $this->leaderboard = User::orderByDesc('xp_total')->take(5)->get();
    }

    public function render()
    {
        return view('livewire.profile-page')->layout('layouts.app');
    }
}
