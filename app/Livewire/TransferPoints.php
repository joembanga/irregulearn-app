<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Notifications\XpReceivedNotification;
use Illuminate\Support\Facades\Auth;

class TransferPoints extends Component
{
    public User $receiver;
    public $amount = 100; // Montant par défaut

    public function transfer()
    {
        $sender = Auth::user();
        $this->amount = +$this->amount;

        if ($this->amount <= 50) {
            session()->flash('error', "Tu n'as pas assez de points pour faire un transfert");
            return;
        }

        if ($sender->xp_balance < $this->amount) {
            session()->flash('error', 'Solde XP insuffisant !');
            return;
        }

        $sender->decrement('xp_balance', $this->amount);
        
        $this->receiver->increment('xp_balance', $this->amount);

        $this->receiver->notify(new XpReceivedNotification($sender, $this->receiver, $this->amount));

        session()->flash('success', "Tu as envoyé {$this->amount} XP à {$this->receiver->username} ! 🎁");
    }

    public function render()
    {
        return view('livewire.transfer-points');
    }
}
