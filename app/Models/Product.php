<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function asset;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id','name','slug','description','price','image','gallery'
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            // Local placeholder image avoids reliance on external services
            return asset('assets/images/products/product-details.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function getGalleryUrlsAttribute(): array
    {
        $items = array_slice($this->gallery ?? [], 0, 4);
        return array_map(function ($path) {
            if (!$path) {
                return asset('assets/images/products/product-details.jpg');
            }
            if (str_starts_with($path, 'http')) {
                return $path;
            }
            // Support seeded asset paths (assets/images/...) and stored uploads (products/...)
            if (str_starts_with($path, 'assets/')) {
                return asset($path);
            }
            return asset('storage/' . ltrim($path, '/'));
        }, $items);
    }

    protected static function booted(): void
    {
        static::saved(function (Product $product) {
            if ($product->category_id) {
                // Ensure the primary category is always attached on the pivot
                $product->categories()->syncWithoutDetaching([$product->category_id]);
            }
        });
    }
}
