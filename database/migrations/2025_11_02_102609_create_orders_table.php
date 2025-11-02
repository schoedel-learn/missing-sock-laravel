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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('registration_id')->constrained();
            $table->foreignId('child_id')->nullable()->constrained();
            
            // Main Package
            $table->foreignId('main_package_id')->constrained('packages');
            $table->integer('main_package_price_cents');
            
            // Optional Second/Third Packages
            $table->foreignId('second_package_id')->nullable()->constrained('packages');
            $table->integer('second_package_price_cents')->nullable();
            $table->foreignId('third_package_id')->nullable()->constrained('packages');
            $table->integer('third_package_price_cents')->nullable();
            
            // Sibling Package
            $table->foreignId('sibling_package_id')->nullable()->constrained('packages');
            $table->integer('sibling_package_price_cents')->nullable();
            $table->integer('sibling_special_fee_cents')->default(0);
            
            // Upgrades & Services
            $table->boolean('four_poses_upgrade')->default(false);
            $table->integer('four_poses_upgrade_price_cents')->default(0);
            $table->boolean('pose_perfection')->default(false);
            $table->integer('pose_perfection_price_cents')->default(0);
            $table->boolean('premium_retouch')->default(false);
            $table->integer('premium_retouch_price_cents')->default(0);
            $table->string('retouch_specification')->nullable();
            
            // Class Picture
            $table->string('class_picture_size')->nullable();
            $table->integer('class_picture_price_cents')->default(0);
            
            // Pricing
            $table->integer('subtotal_cents');
            $table->integer('shipping_cents')->default(0);
            $table->integer('discount_cents')->default(0);
            $table->string('coupon_code')->nullable();
            $table->integer('total_cents');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('order_number');
            $table->index(['registration_id', 'child_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
