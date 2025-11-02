<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->string('payment_number')->unique();
            $table->string('stripe_payment_intent_id')->nullable()->unique();
            $table->string('stripe_charge_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->integer('amount_cents');
            $table->string('currency', 3)->default('USD');
            $table->enum('status', [
                'pending',
                'processing',
                'succeeded',
                'failed',
                'refunded',
                'cancelled'
            ])->default('pending');
            $table->string('card_brand')->nullable();
            $table->string('card_last4')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->integer('refund_amount_cents')->default(0);
            $table->string('failure_code')->nullable();
            $table->text('failure_message')->nullable();
            $table->timestamps();
            
            $table->index('payment_number');
            $table->index('stripe_payment_intent_id');
            $table->index(['registration_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
