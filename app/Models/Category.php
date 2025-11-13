<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function asset;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name','slug','image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productsMany()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            // Use local placeholder to avoid external requests / mixed content
            return asset('assets/images/featured/img-1.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . ltrim($this->image, '/'));
    }
}
