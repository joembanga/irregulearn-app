<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Notifications\NewFriendNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowButton extends Component
{
    public User $user;
    public $status;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->checkStatus();
    }

    public function checkStatus()
    {
        $contact = DB::table('friendships')
            ->where('sender_id', Auth::id())
            ->where('recipient_id', $this->user->id)
            ->first();

        $this->status = $contact ? $contact->status : 'none';
    }

    public function toggleFollow()
    {
        if ($this->status === 'none') {
            DB::table('friendships')->insert([
                'sender_id' => Auth::id(),
                'recipient_id' => $this->user->id,
                'status' => 'accepted', // Pour simplifier au début, on accepte direct
                'created_at' => now(),
            ]);

            // On peut envoyer une notification ici
            $this->user->notify(new NewFriendNotification(Auth::user()));
        } else {
            DB::table('friendships')
                ->where('sender_id', Auth::id())
                ->where('recipient_id', $this->user->id)
                ->delete();
        }

        $this->checkStatus();
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
