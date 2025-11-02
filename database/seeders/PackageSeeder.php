<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic Package',
                'slug' => 'basic-package',
                'description' => 'Perfect for families who want digital access to all photos.',
                'price_cents' => 2999,
                'number_of_poses' => 1,
                'includes_prints' => false,
                'includes_digital' => true,
                'print_sizes' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Standard Package',
                'slug' => 'standard-package',
                'description' => 'Includes digital photos plus selected prints.',
                'price_cents' => 4999,
                'number_of_poses' => 2,
                'includes_prints' => true,
                'includes_digital' => true,
                'print_sizes' => ['4x6', '5x7'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium Package',
                'slug' => 'premium-package',
                'description' => 'Enhanced package with multiple poses and larger prints.',
                'price_cents' => 7999,
                'number_of_poses' => 3,
                'includes_prints' => true,
                'includes_digital' => true,
                'print_sizes' => ['4x6', '5x7', '8x10'],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Deluxe Package',
                'slug' => 'deluxe-package',
                'description' => 'Our most popular package with everything included.',
                'price_cents' => 9999,
                'number_of_poses' => 4,
                'includes_prints' => true,
                'includes_digital' => true,
                'print_sizes' => ['4x6', '5x7', '8x10', '11x14'],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Ultimate Package',
                'slug' => 'ultimate-package',
                'description' => 'The complete package with premium prints and extras.',
                'price_cents' => 12999,
                'number_of_poses' => 4,
                'includes_prints' => true,
                'includes_digital' => true,
                'print_sizes' => ['4x6', '5x7', '8x10', '11x14', '16x20'],
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Digital Only Package',
                'slug' => 'digital-only-package',
                'description' => 'All digital photos with unlimited downloads.',
                'price_cents' => 3999,
                'number_of_poses' => 1,
                'includes_prints' => false,
                'includes_digital' => true,
                'print_sizes' => null,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($packages as $package) {
            \App\Models\Package::create($package);
        }
    }
}
