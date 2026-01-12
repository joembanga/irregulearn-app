<?php

namespace App\Notifications;

use App\Models\Verb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExampleLiked extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Verb $verb)
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Ton exemple sur le verbe {$this->verb->infinitive} a reçu un like ! ❤️",
            'xp_gained' => 5,
            'url' => route('verbs.show', $this->verb->slug),
            'icon' => '❤️'
        ];
    }
}
