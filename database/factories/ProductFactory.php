<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->realText(2000),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
            // 'deleted_at' => now(),
            // 'image_mime' => $this->faker->mimeType(),
            // 'image_size' => $this->faker->randomNumber(10),
            // 'created_by' => \App\Models\User::factory(),
            // 'updated_by' => \App\Models\User::factory(),
            // 'deleted_by' => \App\Models\User::factory(),
        ];
    }
}
