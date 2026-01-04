<?php

namespace App\Livewire;

use App\Models\Verb;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToFavsButton extends Component
{
    public $verb;

    public function mount(Verb $verb)
    {
        $this->verb = $verb;
    }

    public function addTofavs(int $verbId)
    {
        $user = Auth::user();

        $user->favorites()->toggle($verbId);

        $this->dispatch('verbToggled');
    }

    public function render()
    {
        return view('livewire.add-to-favs-button');
    }
}
