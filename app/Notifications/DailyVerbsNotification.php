<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailyVerbsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $verbs)
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Tes 5 verbes du jour sont prêts !')
            ->line('Il est temps de s\'entraîner.')
            ->action('Apprendre maintenant', url('/learn'))
            ->line('Bonne chance pour ta série !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Tes 5 verbes du jour sont arrivés !',
            'verb_count' => $this->verbs->count(),
            'url' => route('verbs.today'),
            'icon' => '📚'
        ];
    }
}
