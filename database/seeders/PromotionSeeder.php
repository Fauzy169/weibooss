<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Single active promotion (update if exists)
        Promotion::updateOrCreate(
            ['title' => 'Promo Minggu Ini'],
            [
                'subtitle' => 'Diskon Spesial',
                'description' => 'Penawaran terbatas untuk minggu ini. Jangan lewatkan kesempatan hemat belanja.',
                'deadline_at' => now()->addDays(7),
                'image' => null,
                'button_text' => 'Belanja Sekarang',
                'button_url' => '#promo',
                'active' => true,
            ]
        );
    }
}
