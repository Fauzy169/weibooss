<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    /** @use HasFactory<\Database\Factories\PromotionFactory> */
    use HasFactory;

    protected $fillable = [
        'title','subtitle','description','deadline_at','image','small_icon','button_text','button_url','active'
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
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

    public function getSmallIconUrlAttribute(): string
    {
        if (!$this->small_icon) {
            return asset('assets/images/hand-picked/deal-icon.png');
        }
        if (str_starts_with($this->small_icon, 'http')) {
            return $this->small_icon;
        }
        return asset('storage/' . ltrim($this->small_icon, '/'));
    }
}
