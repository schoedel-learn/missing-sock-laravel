<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_id' => \App\Models\Registration::factory(),
            'child_number' => fake()->numberBetween(1, 3),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'class_name' => fake()->randomElement(['Kindergarten', '1st Grade', '2nd Grade', '3rd Grade', '4th Grade', '5th Grade']) . ' - ' . fake()->randomElement(['A', 'B', 'C']),
            'teacher_name' => fake()->optional()->name(),
            'date_of_birth' => fake()->dateTimeBetween('-10 years', '-3 years'),
        ];
    }
}
