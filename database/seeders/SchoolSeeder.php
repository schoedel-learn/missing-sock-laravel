<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This seeder creates example schools for development/testing
        // In production, you would import actual school data
        
        \App\Models\School::factory()->count(5)->create();
    }
}
