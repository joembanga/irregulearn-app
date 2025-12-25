<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShopManager extends Component
{
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