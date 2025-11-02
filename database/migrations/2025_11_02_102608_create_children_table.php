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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->integer('child_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('class_name');
            $table->string('teacher_name')->nullable();
            $table->date('date_of_birth');
            $table->timestamps();
            
            $table->index(['registration_id', 'child_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
