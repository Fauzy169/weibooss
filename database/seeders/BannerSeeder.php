<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Curated homepage banners (no factories)
        Banner::updateOrCreate(
            ['title' => 'Koleksi Baju Pengantin Baru'],
            [
                'subtitle' => 'Eksklusif Musim Ini',
                'description' => 'Temukan koleksi gaun dan kebaya pengantin terbaru kami.',
                'button_text' => 'Lihat Koleksi',
                'button_url' => '#produk-rekomendasi',
                'image' => null, // fallback image used
                'active' => true,
                'position' => 'home-hero',
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Aksesoris Pelengkap Pernikahan'],
            [
                'subtitle' => 'Detail yang Menyempurnakan',
                'description' => 'Mahkota, veil, dan perhiasan untuk melengkapi penampilan Anda.',
                'button_text' => 'Belanja Aksesoris',
                'button_url' => '#aksesoris',
                'image' => null,
                'active' => true,
                'position' => 'home-hero',
            ]
        );
    }
}
