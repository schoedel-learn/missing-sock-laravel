<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddOnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addOns = [
            [
                'name' => 'Four Poses Upgrade',
                'slug' => 'four-poses-upgrade',
                'description' => 'Upgrade to four poses for your child.',
                'price_cents' => 1999,
                'type' => 'upgrade',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pose Perfection',
                'slug' => 'pose-perfection',
                'description' => 'Professional pose selection service.',
                'price_cents' => 2999,
                'type' => 'service',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Premium Retouch',
                'slug' => 'premium-retouch',
                'description' => 'Professional photo retouching service.',
                'price_cents' => 3999,
                'type' => 'service',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Class Picture - 8x10',
                'slug' => 'class-picture-8x10',
                'description' => '8x10 class picture print.',
                'price_cents' => 1999,
                'type' => 'print',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Class Picture - 11x14',
                'slug' => 'class-picture-11x14',
                'description' => '11x14 class picture print.',
                'price_cents' => 2999,
                'type' => 'print',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Extra Prints Set',
                'slug' => 'extra-prints-set',
                'description' => 'Additional set of prints (4x6, 5x7, 8x10).',
                'price_cents' => 2499,
                'type' => 'print',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($addOns as $addOn) {
            \App\Models\AddOn::create($addOn);
        }
    }
}
