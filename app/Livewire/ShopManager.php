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

    public function buyItem($itemId, $price)
    {
        $user = Auth::user();
        $unlocked = $user->unlocked_items ?? [];

        if (in_array($itemId, $unlocked)) {
            session()->flash('error', 'Déjà possédé !');
            return;
        }

        if ($user->xp_balance >= $price) {
            $user->decrement('xp_balance', $price);

            $unlocked[] = $itemId;
            $user->unlocked_items = $unlocked;
            $user->save();

            session()->flash('success', 'Item débloqué ! 🎨');
        } else {
            session()->flash('error', 'XP insuffisants...');
        }
    }

    public function buyRandomItem()
    {
        $user = Auth::user();
        $price = 800; // Cheaper than buying specific

        if ($user->xp_balance < $price) {
             session()->flash('error', 'XP insuffisants...');
             return;
        }

        // Define pool of premium items
        $premiumItems = [
            'Sunglasses', 'Wayfarers', // Accessories
            'WinterHat4', 'LongHairFrida', 'ShortHairDreads02', // Tops
            'Skull', 'Diamond', 'Bear' // Graphics
        ];

        $unlocked = $user->unlocked_items ?? [];
        $available = array_diff($premiumItems, $unlocked);

        if (empty($available)) {
             session()->flash('error', 'Tu as déjà tout débloqué !');
             return;
        }

        $wonItem = $available[array_rand($available)];

        $user->decrement('xp_balance', $price);
        $unlocked[] = $wonItem;
        $user->unlocked_items = $unlocked;
        $user->save();

        session()->flash('success', "Gagné : $wonItem ! 🎉");
    }

    public function render()
    {
        return view('livewire.shop-manager');
    }
}
