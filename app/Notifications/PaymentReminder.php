<?php

namespace App\Notifications;

use App\Enums\PaymentTypeEnums;
use App\Helpers\Settings;
use App\Models\Client;
use Emotality\Panacea\PanaceaMobileSms;
use Emotality\Panacea\PanaceaMobileSmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The Payment record.
     *
     * @param  \App\Models\Payment  $payment
     */
    public $payment;

    /**
     * The Payment url.
     *
     * @var string
     */
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($payment, $url = '/')
    {
        // Notification & Queue options
        $this->queue = 'notifications';
        $this->delay = 0;
        $this->payment = $payment;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(Client $notifiable): array
    {
        if ($this->payment->type == PaymentTypeEnums::CONTRIBUTION
            || $this->payment->type == PaymentTypeEnums::CLAIM) {
            return ['mail', PanaceaMobileSmsChannel::class];
        }

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(Client $notifiable): MailMessage
    {
        return (new MailMessage)
            ->theme('default')
            ->markdown('mail.payment.reminder');
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(Client $notifiable): PanaceaMobileSms
    {
        // Set message
        $message = '';
        if ($this->payment->type == PaymentTypeEnums::CONTRIBUTION) {
            $message = sprintf(
                'Sawubona %s, siyakukhumbuza ukuthi umnikelo wakho we-%s ka-%s uzofuneka ngo-%s. Sicela ukhokhele ehhovisi. Ungakunaki lokhu uma usukhokhile (Ref: %s). Siyabonga. %s',
                \Str::upper($notifiable->name),
                config('app.name'),
                sprintf('%s%.2f', 'R', $this->payment->amount),
                $this->payment->created_at->format('dMy'),
                $this->payment->slug,
                Settings::get('main_phone', '0320610097'),
            );
        }

        /* if ($this->payment->type == PaymentTypeEnums::CLAIM) {
            $message = sprintf(
                '%s! Isimangalo sakho se-%s sesicubunguliwe ngempumelelo futhi selikhokhiwe. Ref: %s Uma udinga usizo, thinta u-%s.',
                \Str::upper($notifiable->name),
                config('app.name'),
                $this->payment->slug,
                Settings::get('main_phone', '0320610097'),
            );
        } */

        $formattedNumber = \Str::replaceFirst('0', '+27', $notifiable->phone);

        return (new PanaceaMobileSms)
            ->toMany([$formattedNumber])
            ->message($message);
    }
}
