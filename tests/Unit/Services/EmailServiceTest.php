<?php

namespace Tests\Unit\Services;

use App\Jobs\SendEmailJob;
use App\Services\EmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class EmailServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_is_queued_when_queue_is_enabled(): void
    {
        Queue::fake();
        
        config(['queue.default' => 'database']); // Enable queueing

        $emailService = app(EmailService::class);
        $mailable = new class extends Mailable {
            public function build()
            {
                return $this->subject('Test')->text('email.test');
            }
        };

        $emailService->send($mailable, 'test@example.com');

        Queue::assertPushed(SendEmailJob::class);
    }

    public function test_email_is_sent_synchronously_when_requested(): void
    {
        Queue::fake();
        
        config(['queue.default' => 'database']);

        $emailService = app(EmailService::class);
        $mailable = new class extends Mailable {
            public function build()
            {
                return $this->subject('Test')->text('email.test');
            }
        };

        // Request synchronous sending
        $emailService->send($mailable, 'test@example.com', queue: false);

        // Should not be queued
        Queue::assertNothingPushed();
    }

    public function test_email_is_not_queued_when_sync_driver(): void
    {
        Queue::fake();
        
        config(['queue.default' => 'sync']); // Sync driver

        $emailService = app(EmailService::class);
        $mailable = new class extends Mailable {
            public function build()
            {
                return $this->subject('Test')->text('email.test');
            }
        };

        $emailService->send($mailable, 'test@example.com');

        // Should not queue with sync driver
        Queue::assertNothingPushed();
    }
}

