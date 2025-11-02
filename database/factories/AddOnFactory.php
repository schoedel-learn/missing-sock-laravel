<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AddOn>
 */
class AddOnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $addOnNames = [
            'Four Poses Upgrade',
            'Pose Perfection',
            'Premium Retouch',
            'Class Picture',
            'Extra Prints',
        ];
        
        $name = fake()->randomElement($addOnNames);
        $slug = \Illuminate\Support\Str::slug($name);
        $priceCents = fake()->randomElement([999, 1999, 2999, 4999]);
        
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->sentence(8),
            'price_cents' => $priceCents,
            'type' => fake()->randomElement(['upgrade', 'service', 'print']),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
