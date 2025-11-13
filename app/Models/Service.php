<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function asset;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'type', 'description', 'price', 'image', 'is_featured', 'active'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            // Use local placeholder for services to avoid external images
            return asset('assets/images/featured/img-2.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . ltrim($this->image, '/'));
    }
}
