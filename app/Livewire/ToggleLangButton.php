<?php

namespace App\Livewire;

use App\Models\Lang;
use Livewire\Component;

class ToggleLangButton extends Component
{
    public function render()
    {
        $langs = Lang::all();
        return view('livewire.toggle-lang-button', compact('langs'));
    }
}
