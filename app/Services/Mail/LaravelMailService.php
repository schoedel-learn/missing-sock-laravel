<?php

namespace App\Services\Mail;

use App\Contracts\MailServiceInterface;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class LaravelMailService implements MailServiceInterface
{
    /**
     * Send an email using Laravel's default mail system.
     *
     * @param  Mailable  $mailable
     * @param  string|null  $to
     * @return bool
     */
    public function send(Mailable $mailable, ?string $to = null): bool
    {
        try {
            if ($to) {
                Mail::to($to)->send($mailable);
            } else {
                Mail::send($mailable);
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Mail send failed: ' . $e->getMessage());

            return false;
        }
    }

    /**
     * Send an email to multiple recipients.
     *
     * @param  Mailable  $mailable
     * @param  array  $to
     * @return bool
     */
    public function sendToMany(Mailable $mailable, array $to): bool
    {
        try {
            Mail::to($to)->send($mailable);

            return true;
        } catch (\Exception $e) {
            \Log::error('Mail send failed: ' . $e->getMessage());

            return false;
        }
    }

    /**
     * Get the provider name.
     *
     * @return string
     */
    public function getProvider(): string
    {
        return 'laravel';
    }
}


