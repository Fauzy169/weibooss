<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create one primary photo service
        Service::updateOrCreate(
            ['slug' => 'jasa-foto-produk'],
            [
                'name' => 'Jasa Foto Produk',
                'type' => 'photo',
                'description' => 'Layanan foto produk profesional untuk katalog, marketplace, dan sosial media.',
                'price' => 750000,
                'is_featured' => true,
                'active' => true,
            ]
        );

        // Additional featured services like Wedding Organizer, etc.
        $services = [
            ['name' => 'Wedding Organizer', 'type' => 'wedding', 'price' => 5500000],
            ['name' => 'Makeup Artist', 'type' => 'makeup', 'price' => 1500000],
            ['name' => 'Event Planner', 'type' => 'event', 'price' => 3000000],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(
                ['slug' => Str::slug($s['name'])],
                [
                    'name' => $s['name'],
                    'type' => $s['type'],
                    'description' => 'Layanan ' . strtolower($s['name']) . ' profesional dan terpercaya.',
                    'price' => $s['price'],
                    'is_featured' => true,
                    'active' => true,
                ]
            );
        }
        // No factories; curated services only
    }
}
