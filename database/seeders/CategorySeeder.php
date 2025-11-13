<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed curated categories only (no factories)
        $presets = [
            ['name' => 'Baju Pengantin', 'slug' => 'baju-pengantin', 'image' => null],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris', 'image' => null],
        ];

        foreach ($presets as $preset) {
            Category::updateOrCreate(
                ['slug' => $preset['slug']],
                ['name' => $preset['name'], 'image' => $preset['image']]
            );
        }
    }
}
