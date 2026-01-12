<?php

namespace App\Livewire;

use App\Models\Friendship;
use App\Models\User;
use App\Notifications\NewFriendNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

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
        $contact = Friendship::where(function ($q) {
            $q->where('sender_id', Auth::id())->where('recipient_id', $this->user->id);
        })->orWhere(function ($q) {
            $q->where('sender_id', $this->user->id)->where('recipient_id', Auth::id());
        })->first();

        $this->status = $contact ? $contact->status : 'none';
    }

    public function toggleFollow()
    {
        if ($this->status === 'none') {
            Friendship::create([
                'sender_id' => Auth::id(),
                'recipient_id' => $this->user->id,
                'status' => 'accepted',
            ]);

            // On peut envoyer une notification ici
            $this->user->notify(new NewFriendNotification(Auth::user()));
        } else {
            Friendship::where(function ($q) {
                $q->where('sender_id', Auth::id())->where('recipient_id', $this->user->id);
            })->orWhere(function ($q) {
                $q->where('sender_id', $this->user->id)->where('recipient_id', Auth::id());
            })->delete();
        }

        $this->checkStatus();
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
