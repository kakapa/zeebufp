<?php

namespace App\Notifications;

use App\Enums\PaymentTypeEnums;
use App\Helpers\Settings;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Emotality\Panacea\PanaceaMobileSms;
use Emotality\Panacea\PanaceaMobileSmsChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentApproved extends Notification implements ShouldQueue
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
    public function via(User $notifiable): array
    {
        if($this->payment->type == PaymentTypeEnums::CONTRIBUTION
            || $this->payment->type == PaymentTypeEnums::CLAIM) {
            return ['database', 'mail', PanaceaMobileSmsChannel::class];
        }

        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->theme('default')
            ->markdown('mail.payment.approved');
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(User $notifiable): PanaceaMobileSms
    {
        // Set message
        $message = '';
        if($this->payment->type == PaymentTypeEnums::CONTRIBUTION) {
            $message = sprintf(
                '%s! Inkokhelo yakho yenyanga ye-%s seyitholakele futhi isicubunguliwe. Siyabonga. Ref: %s Uma udinga usizo, thinta u-%s.',
                \Str::upper($this->payment->account->client->name),
                    config('app.name'),
                    $this->payment->slug,
                    Settings::get('main_phone', '0320610097'),
            );
        }

        if($this->payment->type == PaymentTypeEnums::CLAIM) {
            $message = sprintf(
                '%s! Isimangalo sakho se-%s sesicubunguliwe ngempumelelo futhi selikhokhiwe. Ref: %s Uma udinga usizo, thinta u-%s.',
                \Str::upper($this->payment->account->client->name),
                    config('app.name'),
                    $this->payment->slug,
                    Settings::get('main_phone', '0320610097'),
            );
        }

        $formattedNumber = \Str::replaceFirst('0', '+27', $this->payment->account->client->phone);

        return (new PanaceaMobileSms)
            ->toMany([$formattedNumber])
            ->message($message);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase(User $notifiable): array
    {
        return [
            'short' => 'Payment Approved',
            'long' => sprintf(
                'You have successfully approved the payment #%s for %s. You can track the payment status from your dashboard.',
                $this->payment->slug,
                $this->payment->account->client->name,
            ),
            'url' => $this->url,
            'icon' => 'CreditCard',
            'color' => '#228739',
            'payment' => $this->payment
        ];
    }
}