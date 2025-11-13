<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(2);
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(100,999),
            'type' => $this->faker->randomElement(['photo','wedding','makeup','event']),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomElement([null, $this->faker->numberBetween(500000,5000000)]),
            'image' => null, // can be updated manually or via upload
            'is_featured' => $this->faker->boolean(40),
            'active' => true,
        ];
    }
}
