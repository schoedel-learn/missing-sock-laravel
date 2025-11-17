<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'processing', 'succeeded', 'failed', 'refunded', 'cancelled']);
        $amountCents = fake()->numberBetween(2999, 19999);
        
        return [
            'user_id' => \App\Models\User::factory(),
            'registration_id' => \App\Models\Registration::factory(),
            'order_id' => fake()->optional()->passthrough(\App\Models\Order::factory()),
            'stripe_payment_intent_id' => fake()->optional()->bothify('pi_########################'),
            'stripe_charge_id' => fake()->optional()->bothify('ch_########################'),
            'stripe_customer_id' => fake()->optional()->bothify('cus_########################'),
            'amount_cents' => $amountCents,
            'currency' => 'USD',
            'status' => $status,
            'card_brand' => fake()->optional()->randomElement(['visa', 'mastercard', 'amex', 'discover']),
            'card_last4' => fake()->optional()->numerify('####'),
            'paid_at' => $status === 'succeeded' ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'failed_at' => $status === 'failed' ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'refunded_at' => $status === 'refunded' ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'refund_amount_cents' => $status === 'refunded' ? fake()->numberBetween(0, $amountCents) : 0,
            'failure_code' => $status === 'failed' ? fake()->randomElement(['card_declined', 'insufficient_funds', 'expired_card']) : null,
            'failure_message' => $status === 'failed' ? fake()->sentence() : null,
        ];
    }
}
