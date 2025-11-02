<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

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
