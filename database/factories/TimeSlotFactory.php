<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSlot>
 */
class TimeSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(),
            'slot_datetime' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'max_participants' => fake()->numberBetween(2, 6),
            'current_bookings' => fake()->numberBetween(0, 4),
            'is_available' => fake()->boolean(80),
        ];
    }
}
