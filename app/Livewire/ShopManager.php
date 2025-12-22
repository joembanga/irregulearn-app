<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShopManager extends Component
{
    public function buyLives()
    {
        $user = Auth::user();
        $price = 500;

        if ($user->xp_balance >= $price) {
            if ($user->lives >= 5) {
                session()->flash('error', 'Tes vies sont déjà au maximum !');
                return;
            }

            $user->decrement('xp_balance', $price);
            $user->update(['lives' => 5, 'last_life_lost_at' => null]);

            session()->flash('success', 'Vies rechargées ! ❤️');
        } else {
            session()->flash('error', 'XP insuffisants...');
        }
    }

    public function buyFreeze()
    {
        $user = Auth::user();
        $price = 2000;

        if ($user->xp_balance >= $price) {
            $user->decrement('xp_balance', $price);
            $user->increment('streak_freezes');

            session()->flash('success', 'Gel de série acheté ! ❄️');
        } else {
            session()->flash('error', 'XP insuffisants...');
        }
    }

    public function render()
    {
        return view('livewire.shop-manager');
    }
}