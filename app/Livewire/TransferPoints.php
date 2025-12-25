<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransferPoints extends Component
{
    public User $receiver;
    public $amount = 100; // Montant par défaut

    public function transfer()
    {
        $sender = Auth::user();
        $this->amount = (int)$this->amount;

        // 1. Vérifications de sécurité
        if ($this->amount <= 0) return;

        if ($sender->xp_balance < $this->amount) {
            session()->flash('error', 'Solde XP insuffisant !');
            return;
        }

        // 2. Transaction (on retire au donneur, on donne au receveur)
        $sender->decrement('xp_balance', $this->amount);
        $this->receiver->increment('xp_balance', $this->amount);

        // 3. Notification pour le receveur
        $this->receiver->notify(new \App\Notifications\XpReceivedNotification($sender, $this->amount));

        session()->flash('success', "Tu as envoyé {$this->amount} XP à {$this->receiver->username} ! 🎁");
    }

    public function render()
    {
        return view('livewire.transfer-points');
    }
}
