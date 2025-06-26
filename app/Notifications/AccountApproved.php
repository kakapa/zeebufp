<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Emotality\Panacea\PanaceaMobileSms;
use Emotality\Panacea\PanaceaMobileSmsChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Account record.
     *
     * @param  \App\Models\Account  $account
     */
    public $account;

    /**
     * The Account url.
     *
     * @var string
     */
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($account, $url = '/')
    {
        // Notification & Queue options
        $this->queue = 'notifications';
        $this->delay = 0;
        $this->account = $account;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(User $notifiable): array
    {
       return ['database', PanaceaMobileSmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->theme('default')
            ->markdown('mail.account.approved');
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(User $notifiable): PanaceaMobileSms
    {
        $formattedNumber = \Str::replaceFirst('0', '+27', $this->account->client->phone);

        return (new PanaceaMobileSms)
        ->toMany([$formattedNumber])
        ->message(
            sprintf('Congratulations! Your new %s policy has been approved. Ref %s', config('app.name'), $this->account->slug)
        );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase(User $notifiable): array
    {
        return [
            'short' => 'Account Approved',
            'long' => sprintf(
                'You have successfully approved the account #%s for %s. You can track the status account from your dashboard.',
                $this->account->slug,
                $this->account->client->name,
            ),
            'url' => $this->url,
            'account' => $this->account
        ];
    }
}