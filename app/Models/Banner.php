<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_url',
        'image',
        'active',
        'position',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('assets/images/featured/img-1.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . ltrim($this->image, '/'));
    }
}
