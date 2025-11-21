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
                'name' => 'Extra Smiles',
                'slug' => 'extra-smiles',
                'description' => 'Two 5x7 prints',
                'price_cents' => 1900, // $19.00
                'type' => 'print',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Big Moments',
                'slug' => 'big-moments',
                'description' => 'One 8x10 print',
                'price_cents' => 1900, // $19.00
                'type' => 'print',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Memory Mug',
                'slug' => 'memory-mug',
                'description' => 'Custom Coffee Mug',
                'price_cents' => 2200, // $22.00
                'type' => 'product',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Digital Add-On',
                'slug' => 'digital-add-on',
                'description' => 'One digital image download',
                'price_cents' => 2000, // $20.00
                'type' => 'digital',
                'is_active' => true,
                'sort_order' => 4,
            ],
            // Keep existing add-ons for backward compatibility
            [
                'name' => 'Four Poses Upgrade',
                'slug' => 'four-poses-upgrade',
                'description' => 'Upgrade to four poses for your child.',
                'price_cents' => 1000, // $10.00 (matches wizard)
                'type' => 'upgrade',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Pose Perfection',
                'slug' => 'pose-perfection',
                'description' => 'Professional pose selection service.',
                'price_cents' => 1400, // $14.00 base (varies by children count)
                'type' => 'service',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Premium Retouch',
                'slug' => 'premium-retouch',
                'description' => 'Professional photo retouching service.',
                'price_cents' => 1200, // $12.00 (matches wizard)
                'type' => 'service',
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($addOns as $addOn) {
            \App\Models\AddOn::updateOrCreate(
                ['slug' => $addOn['slug']],
                $addOn
            );
        }
    }
}
