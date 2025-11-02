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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->foreignId('school_id')->constrained();
            $table->foreignId('project_id')->constrained();
            
            // Parent/Guardian Information
            $table->string('parent_first_name');
            $table->string('parent_last_name');
            $table->string('parent_email');
            $table->string('parent_phone');
            
            // Registration Details
            $table->enum('registration_type', ['prepay', 'register_only']);
            $table->integer('number_of_children');
            $table->boolean('sibling_special')->default(false);
            $table->string('package_pose_distribution')->nullable();
            
            // Shipping
            $table->enum('shipping_method', ['school', 'home'])->default('school');
            $table->string('shipping_address')->nullable();
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip')->nullable();
            
            // Preferences
            $table->boolean('auto_select_images')->default(false);
            $table->text('special_instructions')->nullable();
            $table->boolean('email_opt_in')->default(false);
            
            // Signature
            $table->text('signature_data')->nullable();
            $table->timestamp('signature_date')->nullable();
            
            // Status
            $table->enum('status', [
                'pending',
                'confirmed',
                'session_completed',
                'gallery_ready',
                'images_selected',
                'order_shipped',
                'completed',
                'cancelled'
            ])->default('pending');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['school_id', 'project_id', 'status']);
            $table->index('parent_email');
            $table->index('registration_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
