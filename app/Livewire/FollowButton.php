<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
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
        $contact = DB::table('classmates')
            ->where('user_id', auth()->id())
            ->where('friend_id', $this->user->id)
            ->first();

        $this->status = $contact ? $contact->status : 'none';
    }

    public function toggleFollow()
    {
        if ($this->status === 'none') {
            DB::table('classmates')->insert([
                'user_id' => auth()->id(),
                'friend_id' => $this->user->id,
                'status' => 'accepted', // Pour simplifier au début, on accepte direct
                'created_at' => now(),
            ]);

            // On peut envoyer une notification ici
            $this->user->notify(new \App\Notifications\NewClassmateNotification(auth()->user()));
        } else {
            DB::table('classmates')
                ->where('user_id', auth()->id())
                ->where('friend_id', $this->user->id)
                ->delete();
        }

        $this->checkStatus();
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
