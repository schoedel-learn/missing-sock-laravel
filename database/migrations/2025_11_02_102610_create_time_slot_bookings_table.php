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
        Schema::create('time_slot_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_slot_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['booked', 'cancelled', 'completed'])->default('booked');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            
            $table->index(['time_slot_id', 'status']);
            $table->index('registration_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slot_bookings');
    }
};
