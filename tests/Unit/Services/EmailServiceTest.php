<?php

namespace Tests\Unit\Services;

use App\Contracts\MailServiceInterface;
use App\Services\EmailService;
use Illuminate\Mail\Mailable;
use Mockery;
use Tests\TestCase;

class EmailServiceTest extends TestCase
{
    protected EmailService $emailService;
    protected $mockMailService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mockMailService = Mockery::mock(MailServiceInterface::class);
        $this->emailService = new EmailService($this->mockMailService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_can_send_email(): void
    {
        $mailable = Mockery::mock(Mailable::class);
        $recipient = 'test@example.com';

        $this->mockMailService
            ->shouldReceive('send')
            ->once()
            ->with($mailable, $recipient)
            ->andReturn(true);

        $result = $this->emailService->send($mailable, $recipient);

        $this->assertTrue($result);
    }

    public function test_send_delegates_to_mail_service(): void
    {
        $mailable = Mockery::mock(Mailable::class);
        $recipient = 'user@example.com';

        $this->mockMailService
            ->shouldReceive('send')
            ->once()
            ->with($mailable, $recipient)
            ->andReturn(true);

        $result = $this->emailService->send($mailable, $recipient);
        
        $this->assertTrue($result);
    }
}

