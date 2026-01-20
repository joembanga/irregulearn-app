<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationIcon extends Component
{
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
    }

    public function render()
    {
        return view('livewire.notification-icon', [
            'notifications' => auth()->user()->notifications()->latest()->limit(10)->get()
        ]);
    }
}
