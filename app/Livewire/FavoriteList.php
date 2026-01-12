<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Verb;

class FavoriteList extends Component
{
    public $verb;

    public function mount(Verb $verb)
    {
        $this->verb = $verb;
    }

    public function removeFavorite($verbId)
    {
        // On utilise toggle comme pour le bouton de description
        // C'est plus propre et ça gère la cohérence
        auth()->user()->favorites()->toggle($verbId);

        // On envoie un petit message de succès (optionnel)
        session()->flash('message', 'Verbe retiré de tes favoris.');
    }

    public function render()
    {
        return view('livewire.favorite-list', [
            'verbs' => auth()->user()->favorites()->get()
        ]);
    }
}
