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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->json('metadata')->nullable(); // EXIF data, dimensions, file info
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('gallery_id');
            $table->index('is_featured');
            $table->index('sort_order');
            $table->index('published_at');
            $table->index(['gallery_id', 'sort_order']); // For efficient gallery photo ordering
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
