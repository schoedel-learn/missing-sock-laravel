<?php

namespace App\Services\Mail;

use App\Contracts\MailServiceInterface;
use App\Traits\ExtractsRecipientFromMailable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailgunMailService implements MailServiceInterface
{
    use ExtractsRecipientFromMailable;
    protected string $apiKey;
    protected string $domain;
    protected string $fromEmail;
    protected string $fromName;

    public function __construct()
    {
        $this->apiKey = config('mail.mailgun.secret');
        $this->domain = config('mail.mailgun.domain');
        $this->fromEmail = config('mail.from.address');
        $this->fromName = config('mail.from.name');
    }

    /**
     * Send an email via Mailgun API.
     *
     * @param  Mailable  $mailable
     * @param  string|null  $to
     * @return bool
     */
    public function send(Mailable $mailable, ?string $to = null): bool
    {
        try {
            // Require a recipient - either provided or from the Mailable
            $recipient = $to ?? $this->extractRecipientFromMailable($mailable);

            if (!$recipient) {
                Log::error('Mailgun send failed: No recipient provided and Mailable has no recipients');
                return false;
            }

            $message = $mailable->toMail(new \Illuminate\Notifications\AnonymousNotifiable(['email' => $recipient]));

            $payload = [
                'from' => "{$this->fromName} <{$this->fromEmail}>",
                'to' => $recipient,
                'subject' => $message->subject,
                'html' => $message->render(),
            ];

            $response = Http::withBasicAuth('api', $this->apiKey)
                ->asForm()
                ->post("https://api.mailgun.net/v3/{$this->domain}/messages", $payload);

            if ($response->successful()) {
                return true;
            }

            Log::error('Mailgun API error: ' . $response->body());

            return false;
        } catch (\Exception $e) {
            Log::error('Mailgun send failed: ' . $e->getMessage());

            return false;
        }
    }

    /**
     * Send an email to multiple recipients via Mailgun.
     *
     * @param  Mailable  $mailable
     * @param  array  $to
     * @return bool
     */
    public function sendToMany(Mailable $mailable, array $to): bool
    {
        try {
            $message = $mailable->toMail(new \Illuminate\Notifications\AnonymousNotifiable());

            $payload = [
                'from' => "{$this->fromName} <{$this->fromEmail}>",
                'to' => implode(',', $to),
                'subject' => $message->subject,
                'html' => $message->render(),
            ];

            $response = Http::withBasicAuth('api', $this->apiKey)
                ->asForm()
                ->post("https://api.mailgun.net/v3/{$this->domain}/messages", $payload);

            if ($response->successful()) {
                return true;
            }

            Log::error('Mailgun API error: ' . $response->body());

            return false;
        } catch (\Exception $e) {
            Log::error('Mailgun send failed: ' . $e->getMessage());

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
        return 'mailgun';
    }
}


