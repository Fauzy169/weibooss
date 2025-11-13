<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Curated products only; no factories
        $baju = Category::where('slug', 'baju-pengantin')->orWhere('name','Baju Pengantin')->first();
        $aks  = Category::where('slug', 'aksesoris')->orWhere('name','Aksesoris')->first();

        if (!$baju || !$aks) {
            $this->command?->warn('Categories not found. Run CategorySeeder first.');
            return;
        }

        $bajuItems = [
            ['name' => 'Gaun Pengantin Putih Elegan', 'price' => 2500000, 'image' => null, 'description' => 'Gaun pengantin klasik dengan detail renda elegan.'],
            ['name' => 'Kebaya Modern Payet', 'price' => 1800000, 'image' => null, 'description' => 'Kebaya modern dengan payet berkilau untuk tampilan mewah.'],
            ['name' => 'Gaun Ball Gown Premium', 'price' => 3200000, 'image' => null, 'description' => 'Silhouette ball gown untuk nuansa royal di hari istimewa.'],
            ['name' => 'Dress Pengantin Simple Minimalis', 'price' => 1450000, 'image' => null, 'description' => 'Desain minimalis yang elegan dan nyaman.'],
        ];

        $aksItems = [
            ['name' => 'Mahkota Pengantin', 'price' => 350000, 'image' => null, 'description' => 'Mahkota elegan untuk melengkapi tampilan pengantin.'],
            ['name' => 'Veil / Kerudung Pengantin', 'price' => 250000, 'image' => null, 'description' => 'Kerudung pengantin panjang bahan tule halus.'],
            ['name' => 'Sarung Tangan Satin', 'price' => 120000, 'image' => null, 'description' => 'Sarung tangan satin putih elegan.'],
            ['name' => 'Kalung Mutiara Sintetis', 'price' => 175000, 'image' => null, 'description' => 'Kalung mutiara sintetis untuk aksen anggun.'],
        ];

        // Helper to create product and attach categories
        $createProduct = function(array $row, Category $primary, array $also = []) {
            $slug = Str::slug($row['name']);
            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $primary->id,
                    'name' => $row['name'],
                    'description' => $row['description'] ?? null,
                    'price' => $row['price'],
                    'image' => $row['image'] ?? null,
                ]
            );
            $categoryIds = array_unique(array_merge([$primary->id], array_map(fn($c)=>$c->id, $also)));
            $product->categories()->sync($categoryIds);
        };

        foreach ($bajuItems as $it) {
            $createProduct($it, $baju);
        }

        foreach ($aksItems as $it) {
            $createProduct($it, $aks);
        }
    }
}
