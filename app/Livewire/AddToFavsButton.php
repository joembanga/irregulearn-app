<?php

namespace App\Livewire;

use App\Models\Verb;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToFavsButton extends Component
{
    public $verbId;

    public function mount(int $verbId)
    {
        $this->verbId = $verbId;
    }

    public function addTofavs(int $verbId)
    {
        $user = Auth::user();

        $user->favorites()->toggle($verbId);

        $this->dispatch('verbToggled');
    }

    public function render()
    {
        $isFav = Auth::user()->favorites()->where('verb_id', $this->verbId)->exists();
        return view('livewire.add-to-favs-button', compact('isFav'));
    }
}
