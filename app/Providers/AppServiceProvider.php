<?php

namespace App\Providers;

use App\Contracts\MailServiceInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Registration;
use App\Policies\OrderPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\RegistrationPolicy;
use App\Services\Mail\LaravelMailService;
use App\Services\Mail\MailgunMailService;
use App\Services\Mail\SendGridMailService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind mail service interface based on config
        $this->app->singleton(MailServiceInterface::class, function ($app) {
            $provider = config('mail.custom_provider', 'laravel');

            return match ($provider) {
                'sendgrid' => new SendGridMailService(),
                'mailgun' => new MailgunMailService(),
                default => new LaravelMailService(),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Registration::class, RegistrationPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Payment::class, PaymentPolicy::class);
    }
}
