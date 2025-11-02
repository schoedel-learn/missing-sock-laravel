<?php

namespace App\Contracts;

use Illuminate\Mail\Mailable;

interface MailServiceInterface
{
    /**
     * Send an email using Laravel's Mailable class.
     *
     * @param  Mailable  $mailable
     * @param  string|null  $to
     * @return bool
     */
    public function send(Mailable $mailable, ?string $to = null): bool;

    /**
     * Send an email to multiple recipients.
     *
     * @param  Mailable  $mailable
     * @param  array  $to
     * @return bool
     */
    public function sendToMany(Mailable $mailable, array $to): bool;

    /**
     * Get the provider name (e.g., 'sendgrid', 'mailgun', 'laravel').
     *
     * @return string
     */
    public function getProvider(): string;
}


