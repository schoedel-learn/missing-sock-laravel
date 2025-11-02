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
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('photo_id')->nullable()->constrained()->nullOnDelete(); // Nullable for batch downloads
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('expires_at');
            $table->integer('max_attempts')->default(3);
            $table->integer('attempts')->default(0);
            $table->timestamp('downloaded_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('is_batch')->default(false); // For batch/ZIP downloads
            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'user_id']);
            $table->index(['photo_id', 'order_id', 'user_id']);
            $table->index('expires_at');
            $table->index('is_batch');
            
            // Unique constraint: one download record per order/photo/user combination
            // This prevents duplicate download links for the same photo
            $table->unique(['order_id', 'photo_id', 'user_id'], 'unique_order_photo_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};
