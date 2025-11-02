<?php

namespace App\Services;

use App\Contracts\MailServiceInterface;
use Illuminate\Mail\Mailable;

class MarketingService
{
    protected MailServiceInterface $mailService;

    public function __construct(MailServiceInterface $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Send marketing email.
     *
     * @param  Mailable  $mailable
     * @param  string|array  $to
     * @return bool
     */
    public function sendEmail(Mailable $mailable, string|array $to): bool
    {
        if (is_array($to)) {
            return $this->mailService->sendToMany($mailable, $to);
        }

        return $this->mailService->send($mailable, $to);
    }

    /**
     * Send bulk email campaign.
     *
     * @param  Mailable  $mailable
     * @param  array  $recipients
     * @return array
     */
    public function sendCampaign(Mailable $mailable, array $recipients): array
    {
        $results = [
            'sent' => 0,
            'failed' => 0,
        ];

        foreach ($recipients as $recipient) {
            if ($this->mailService->send($mailable, $recipient)) {
                $results['sent']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }

    /**
     * TODO: Add SMS functionality using vonage/laravel when needed.
     */
}


