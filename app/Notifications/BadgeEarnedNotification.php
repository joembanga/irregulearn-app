<?php

namespace App\Notifications;

use App\Models\Badge;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BadgeEarnedNotification extends Notification implements \Illuminate\Contracts\Queue\ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Badge $badge)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'message' => "Bravo ! Tu as obtenu le badge \"{$this->badge->name}\" {$this->badge->icon}",
            'icon' => $this->badge->icon,
            'url' => '/profile',
            'badge_id' => $this->badge->id,
            'badge_name' => $this->badge->name,
        ];
    }
}
