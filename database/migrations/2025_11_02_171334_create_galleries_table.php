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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('access_type', ['public', 'password', 'private', 'token'])->default('public');
            $table->string('password_hash')->nullable();
            $table->string('access_token')->nullable(); // Hashed token for token-based access
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->json('settings')->nullable(); // Custom settings (theme, layout, etc.)
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index('project_id');
            $table->index('slug');
            $table->index('access_type');
            $table->index('published_at');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
