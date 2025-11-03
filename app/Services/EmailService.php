<?php

namespace App\Services;

use App\Contracts\MailServiceInterface;
use App\Jobs\SendEmailJob;
use Illuminate\Mail\Mailable;

class EmailService
{
    protected MailServiceInterface $mailService;

    public function __construct(MailServiceInterface $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Send an email notification.
     *
     * @param  Mailable  $mailable
     * @param  string|null  $to
     * @param  bool  $queue  Whether to queue the email (default: true)
     * @return bool
     */
    public function send(Mailable $mailable, ?string $to = null, bool $queue = true): bool
    {
        if ($queue && config('queue.default') !== 'sync') {
            SendEmailJob::dispatch($mailable, $to);
            return true;
        }

        return $this->mailService->send($mailable, $to);
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
        return $this->mailService->sendToMany($mailable, $to);
    }

    /**
     * Get the current mail provider name.
     *
     * @return string
     */
    public function getProvider(): string
    {
        return $this->mailService->getProvider();
    }
}

