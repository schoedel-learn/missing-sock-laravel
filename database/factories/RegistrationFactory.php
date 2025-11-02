<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => \App\Models\School::factory(),
            'project_id' => \App\Models\Project::factory(),
            'parent_first_name' => fake()->firstName(),
            'parent_last_name' => fake()->lastName(),
            'parent_email' => fake()->safeEmail(),
            'parent_phone' => fake()->phoneNumber(),
            'registration_type' => fake()->randomElement(['prepay', 'register_only']),
            'number_of_children' => fake()->numberBetween(1, 3),
            'sibling_special' => fake()->boolean(20),
            'package_pose_distribution' => fake()->optional()->randomElement(['equal', 'first_child', 'custom']),
            'shipping_method' => fake()->randomElement(['school', 'home']),
            'shipping_address' => fake()->optional()->streetAddress(),
            'shipping_address_line2' => fake()->optional()->secondaryAddress(),
            'shipping_city' => fake()->optional()->city(),
            'shipping_state' => fake()->optional()->stateAbbr(),
            'shipping_zip' => fake()->optional()->postcode(),
            'auto_select_images' => fake()->boolean(10),
            'special_instructions' => fake()->optional()->sentence(),
            'email_opt_in' => fake()->boolean(70),
            'signature_data' => fake()->optional()->text(),
            'signature_date' => fake()->optional()->dateTime(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'session_completed', 'gallery_ready', 'images_selected', 'order_shipped', 'completed']),
        ];
    }
}
