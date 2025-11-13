<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'image', 'active'
    ];

    protected static function booted(): void
    {
        static::saving(function (Brand $brand) {
            if (!$brand->slug && $brand->name) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    public function getImageUrlAttribute(): string
    {
        // Fallback ke icon default jika belum ada gambar
        if (!$this->image) {
            return asset('assets/images/brands/client-01.png');
        }

        // Jika sudah berupa URL penuh, langsung kembalikan
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        // Gunakan path publik bawaan Laravel (public/storage)
        return asset('storage/' . ltrim($this->image, '/'));
    }
}
