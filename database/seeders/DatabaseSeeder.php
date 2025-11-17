<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
        ]);

        $coordinator = User::factory()->create([
            'name' => 'Test Coordinator',
            'email' => 'coordinator@example.com',
            'role' => UserRole::OrganizationCoordinator->value,
        ]);

        $sampleSchool = School::factory()->create([
            'name' => 'Sample Organization',
            'slug' => 'sample-organization',
        ]);

        $sampleSchool->coordinators()->attach($coordinator->id);

        // Seed packages and add-ons first (they don't depend on other models)
        $this->call([
            PackageSeeder::class,
            AddOnSeeder::class,
        ]);

        // Seed schools (optional - creates sample data)
        // Uncomment if you want sample schools for testing
        // $this->call([
        //     SchoolSeeder::class,
        // ]);
    }
}
