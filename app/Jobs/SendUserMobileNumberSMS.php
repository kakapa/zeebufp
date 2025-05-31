<?php

namespace App\Jobs;

use App\Models\User;
use Emotality\Panacea\PanaceaMobile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Propaganistas\LaravelPhone\PhoneNumber;

class SendUserMobileNumberSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * public \App\Models\User $user
     */
    public User $user;

    /**
     * public string $template
     */
    public string $template;

    /**
     * public string $content
     */
    public string $content;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(User $user, $template = 'code', $content = '')
    {
        $this->queue = 'default';
        $this->user = $user;
        $this->template = $template;
        $this->content = $content;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Send sms
            $phone = new PhoneNumber($this->user->mobile_number, 'ZA');
            PanaceaMobile::sms($phone, $this->getMessageTemplate());
        } catch (\Exception $exception) {
            // Use this, or, the backoff() function below.
            // If you choose this, delete the backoff() function
            // If you choose backoff(), delete this try/catch
            $this->release(300);
        }
    }

    /**
     * Get message template
     */
    public function getMessageTemplate()
    {
        if ($this->template === 'code') {
            return sprintf(
                "Hi %s,\nYour SANCO verification code:\n%s",
                $this->user->name,
                $this->user->pin
            );
        } elseif ($this->template === 'new-pin') {
            return sprintf(
                "Hi %s,\nYour new SANCO pin:\n%s",
                $this->user->name,
                $this->content
            );
        } else {
            return sprintf("%s", $this->content);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // This will be called after retries reached its max attempts via release() or backoff().
        // Send user a notification of failure or something...
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        // Change this according to importance of the job.
        // Lower the seconds if it's important!
        return [15, 60, 180, 300, 900];
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return [
            'send-code'
        ];
    }
}
