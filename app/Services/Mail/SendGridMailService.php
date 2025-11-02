<?php

namespace App\Services\Mail;

use App\Contracts\MailServiceInterface;
use App\Traits\ExtractsRecipientFromMailable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendGridMailService implements MailServiceInterface
{
    use ExtractsRecipientFromMailable;
    protected string $apiKey;
    protected string $fromEmail;
    protected string $fromName;
    protected ?string $templateId;
    protected string $mailCategory;
    protected bool $clickTracking;
    protected bool $openTracking;
    protected bool $bypassListManagement;

    public function __construct()
    {
        $this->apiKey = config('mail.sendgrid.api_key');
        $this->fromEmail = config('mail.from.address');
        $this->fromName = config('mail.from.name');
        $this->templateId = config('mail.sendgrid.template_id');
        $this->mailCategory = config('mail.sendgrid.mail_category', 'transactional');
        $this->clickTracking = config('mail.sendgrid.click_tracking', true);
        $this->openTracking = config('mail.sendgrid.open_tracking', true);
        $this->bypassListManagement = config('mail.sendgrid.bypass_list_management', true);
    }

    /**
     * Send an email via SendGrid API.
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
                Log::error('SendGrid send failed: No recipient provided and Mailable has no recipients');
                return false;
            }

            $message = $mailable->toMail(new \Illuminate\Notifications\AnonymousNotifiable(['email' => $recipient]));

            $personalizations = [
                [
                    'to' => [
                        [
                            'email' => $recipient,
                        ],
                    ],
                ],
            ];

            $payload = [
                'personalizations' => $personalizations,
                'from' => [
                    'email' => $this->fromEmail,
                    'name' => $this->fromName,
                ],
                'subject' => $message->subject,
                'content' => [
                    [
                        'type' => 'text/html',
                        'value' => $message->render(),
                    ],
                ],
                'tracking_settings' => [
                    'click_tracking' => [
                        'enable' => $this->clickTracking,
                    ],
                    'open_tracking' => [
                        'enable' => $this->openTracking,
                    ],
                ],
                'mail_settings' => [
                    'bypass_list_management' => [
                        'enable' => $this->bypassListManagement,
                    ],
                ],
            ];

            // Add template ID if configured (for transactional templates)
            if ($this->templateId) {
                $payload['template_id'] = $this->templateId;
            }

            // Add mail category for analytics/tracking
            if ($this->mailCategory) {
                $payload['categories'] = [$this->mailCategory];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.sendgrid.com/v3/mail/send', $payload);

            if ($response->successful()) {
                return true;
            }

            Log::error('SendGrid API error: ' . $response->body());

            return false;
        } catch (\Exception $e) {
            Log::error('SendGrid send failed: ' . $e->getMessage());

            return false;
        }
    }

    /**
     * Send an email to multiple recipients via SendGrid.
     *
     * @param  Mailable  $mailable
     * @param  array  $to
     * @return bool
     */
    public function sendToMany(Mailable $mailable, array $to): bool
    {
        try {
            $message = $mailable->toMail(new \Illuminate\Notifications\AnonymousNotifiable());

            $personalizations = [
                [
                    'to' => array_map(fn ($email) => ['email' => $email], $to),
                ],
            ];

            $payload = [
                'personalizations' => $personalizations,
                'from' => [
                    'email' => $this->fromEmail,
                    'name' => $this->fromName,
                ],
                'subject' => $message->subject,
                'content' => [
                    [
                        'type' => 'text/html',
                        'value' => $message->render(),
                    ],
                ],
                'tracking_settings' => [
                    'click_tracking' => [
                        'enable' => $this->clickTracking,
                    ],
                    'open_tracking' => [
                        'enable' => $this->openTracking,
                    ],
                ],
                'mail_settings' => [
                    'bypass_list_management' => [
                        'enable' => $this->bypassListManagement,
                    ],
                ],
            ];

            // Add template ID if configured (for transactional templates)
            if ($this->templateId) {
                $payload['template_id'] = $this->templateId;
            }

            // Add mail category for analytics/tracking
            if ($this->mailCategory) {
                $payload['categories'] = [$this->mailCategory];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.sendgrid.com/v3/mail/send', $payload);

            if ($response->successful()) {
                return true;
            }

            Log::error('SendGrid API error: ' . $response->body());

            return false;
        } catch (\Exception $e) {
            Log::error('SendGrid send failed: ' . $e->getMessage());

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
        return 'sendgrid';
    }
}


