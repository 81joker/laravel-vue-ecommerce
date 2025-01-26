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
            'title' => $this->faker->text(),
            'image' => $this->faker->imageUrl(640, 480),
            // 'image' => $this->faker->image('public/storage/products', 640, 480, null, false),
            // 'image_mime' => $this->faker->mimeType(),
            // 'image_size' => $this->faker->randomNumber(8),
            'description' => $this->faker->realText(2000),
            'price' => $this->faker->randomFloat(2, 20,5000),
            // 'created_by' => now(),
            // 'updated_by' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
            'deleted_at' => null,
            'deleted_by' => 1,
        ];
    }
}
