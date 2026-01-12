<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

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
        } elseif (! preg_match('/^[a-zA-Z0-9_-]+$/', $this->username)) {
            $this->status = 'invalid';
            $this->message = '⚠️ Ni espace ni caractères spéciaux (sauf _ et -)';
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
