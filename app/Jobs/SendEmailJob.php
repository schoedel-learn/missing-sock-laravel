<?php

namespace App\Jobs;

use App\Contracts\MailServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Mailable $mailable,
        protected string $recipient
    ) {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(MailServiceInterface $mailService): void
    {
        try {
            $mailService->send($this->mailable, $this->recipient);
            
            Log::info('Email sent successfully', [
                'recipient' => $this->recipient,
                'mailable' => get_class($this->mailable),
            ]);
        } catch (\Exception $e) {
            Log::error('Email send failed', [
                'recipient' => $this->recipient,
                'mailable' => get_class($this->mailable),
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email job failed after all retries', [
            'recipient' => $this->recipient,
            'mailable' => get_class($this->mailable),
            'error' => $exception->getMessage(),
        ]);
    }
}

