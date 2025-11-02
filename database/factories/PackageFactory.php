<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $packageNames = [
            'Basic Package',
            'Standard Package',
            'Premium Package',
            'Deluxe Package',
            'Ultimate Package',
            'Digital Only Package',
        ];
        
        $name = fake()->randomElement($packageNames);
        $slug = \Illuminate\Support\Str::slug($name);
        $priceCents = fake()->randomElement([2999, 4999, 7999, 9999, 12999, 15999]);
        
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->sentence(10),
            'price_cents' => $priceCents,
            'number_of_poses' => fake()->numberBetween(1, 4),
            'includes_prints' => fake()->boolean(70),
            'includes_digital' => fake()->boolean(80),
            'print_sizes' => fake()->randomElements(['4x6', '5x7', '8x10', '11x14'], fake()->numberBetween(1, 3)),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
