<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Promo Minggu Ini',
            'subtitle' => 'Diskon Spesial',
            'description' => $this->faker->sentence(12),
            'deadline_at' => Carbon::now()->addDays(10),
            'image' => null,
            'button_text' => 'Lihat Promo',
            'button_url' => '#',
            'active' => true,
        ];
    }
}
