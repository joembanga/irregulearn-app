<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Leaderboard extends Component
{
    public function render()
    {
        // Dans le contrôleur ou la route :
        $users = User::orderBy('xp_total', 'desc')->paginate(20);

        return view('livewire.leaderboard', [
            'users' => $users
        ]);
    }
}
