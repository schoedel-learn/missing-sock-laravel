<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company() . ' ' . fake()->randomElement(['Elementary', 'Middle', 'High', 'Academy', 'School']);
        $uniqueId = fake()->unique()->numberBetween(1000, 9999);
        $slug = \Illuminate\Support\Str::slug($name) . '-' . $uniqueId;
        
        return [
            'name' => $name,
            'slug' => $slug,
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
            'zip' => fake()->postcode(),
            'contact_name' => fake()->name(),
            'contact_email' => fake()->safeEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }
}
