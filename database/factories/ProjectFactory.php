<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['school_graduation', 'holidays', 'back_to_school', 'fall', 'winter', 'christmas', 'spring'];
        $type = fake()->randomElement($types);
        $name = ucfirst($type) . ' ' . fake()->year() . ' Session';
        $slug = \Illuminate\Support\Str::slug($name);
        
        return [
            'school_id' => \App\Models\School::factory(),
            'name' => $name,
            'slug' => $slug,
            'type' => $type,
            'available_backdrops' => fake()->randomElements(['winter', 'christmas', 'spring', 'fall'], fake()->numberBetween(1, 2)),
            'has_two_backdrops' => fake()->boolean(30),
            'registration_deadline' => fake()->dateTimeBetween('now', '+3 months'),
            'session_date' => fake()->dateTimeBetween('+1 month', '+6 months'),
            'is_active' => true,
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
