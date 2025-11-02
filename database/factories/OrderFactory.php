<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mainPackage = \App\Models\Package::factory();
        $subtotal = fake()->numberBetween(2999, 19999);
        $shipping = fake()->numberBetween(0, 999);
        $discount = fake()->numberBetween(0, 2000);
        $total = $subtotal + $shipping - $discount;
        
        return [
            'registration_id' => \App\Models\Registration::factory(),
            'child_id' => \App\Models\Child::factory(),
            'main_package_id' => $mainPackage,
            'main_package_price_cents' => $subtotal,
            'second_package_id' => fake()->optional()->passthrough(\App\Models\Package::factory()),
            'second_package_price_cents' => fake()->optional()->numberBetween(1999, 7999),
            'third_package_id' => fake()->optional()->passthrough(\App\Models\Package::factory()),
            'third_package_price_cents' => fake()->optional()->numberBetween(1999, 7999),
            'sibling_package_id' => fake()->optional()->passthrough(\App\Models\Package::factory()),
            'sibling_package_price_cents' => fake()->optional()->numberBetween(1499, 4999),
            'sibling_special_fee_cents' => fake()->numberBetween(0, 999),
            'four_poses_upgrade' => fake()->boolean(30),
            'four_poses_upgrade_price_cents' => fake()->numberBetween(0, 1999),
            'pose_perfection' => fake()->boolean(20),
            'pose_perfection_price_cents' => fake()->numberBetween(0, 2999),
            'premium_retouch' => fake()->boolean(15),
            'premium_retouch_price_cents' => fake()->numberBetween(0, 3999),
            'retouch_specification' => fake()->optional()->sentence(),
            'class_picture_size' => fake()->optional()->randomElement(['8x10', '11x14', '16x20']),
            'class_picture_price_cents' => fake()->numberBetween(0, 2999),
            'subtotal_cents' => $subtotal,
            'shipping_cents' => $shipping,
            'discount_cents' => $discount,
            'coupon_code' => fake()->optional()->bothify('COUPON##??'),
            'total_cents' => $total,
        ];
    }
}
