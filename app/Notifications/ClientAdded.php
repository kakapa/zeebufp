<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientAdded extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Client record.
     *
     * @param  \App\Models\Client  $client
     */
    public $client;

    /**
     * The Client url.
     *
     * @var string
     */
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($client, $url = '/')
    {
        // Notification & Queue options
        $this->queue = 'notifications';
        $this->delay = 0;
        $this->client = $client;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(User $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->theme('default')
            ->markdown('mail.clients.added');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase(User $notifiable): array
    {
        return [
            'short' => 'Client Added',
            'long' => sprintf(
                'You have successfully added a client, %s #%s . You can track the client status from your dashboard.',
                $this->client->name,
                $this->client->slug,
            ),
            'url' => $this->url,
            'icon' => 'UserRoundPlus',
            'color' => '#90b8e8',
            'client' => $this->client
        ];
    }
}
