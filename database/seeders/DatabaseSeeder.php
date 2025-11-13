<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Optional: quick reset of data when running seeder directly
        // For a full reset prefer: php artisan migrate:fresh --seed
        Schema::disableForeignKeyConstraints();
        DB::table('category_product')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('banners')->truncate();
        DB::table('brands')->truncate();
        DB::table('promotions')->truncate();
        DB::table('services')->truncate();
        Schema::enableForeignKeyConstraints();

        \App\Models\User::updateOrCreate(
            ['email' => 'admin@weiboo.test'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            BannerSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            PromotionSeeder::class,
            BrandSeeder::class,
        ]);
    }
}
