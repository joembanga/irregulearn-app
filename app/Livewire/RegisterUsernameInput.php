<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class RegisterUsernameInput extends Component
{
    public $username = '';
    public $status = 'neutral'; // neutral, valid, invalid
    public $message = '';

    public function updatedUsername()
    {
        // 1. Si vide
        if (empty($this->username)) {
            $this->status = 'neutral';
            $this->message = '';
            return;
        }

        // 2. Vérification DB
        $exists = User::where('username', $this->username)->exists();

        if ($exists) {
            $this->status = 'invalid';
            $this->message = '❌ Ce pseudo est déjà pris !';
        } elseif (strlen($this->username) < 3) {
            $this->status = 'invalid';
            $this->message = '⚠️ Trop court (min 3 lettres)';
        } else {
            $this->status = 'valid';
            $this->message = '✅ Pseudo disponible !';
        }
    }

    public function render()
    {
        return view('livewire.register-username-input');
    }
}
