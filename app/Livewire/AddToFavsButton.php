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

        // toggle() va ajouter si ça n'existe pas, et supprimer si ça existe déjà
        $user->favorites()->toggle($verbId);

        // Optionnel : envoyer un message flash ou un événement
        $this->dispatch('verbToggled');
    }

    public function render()
    {
        return view('livewire.add-to-favs-button');
    }
}
