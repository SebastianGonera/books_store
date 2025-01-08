<?php

namespace Database\Factories;


use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=> $this->faker->sentence(4),
            'author'=> $this->faker->name(),
            'description'=> $this->faker->paragraph(),
            'price'=> $this->faker->numberBetween(20, 99),
            'stock'=> $this->faker->numberBetween(50, 400),
            'image_url'=> $this->faker->imageUrl(),
            'category_id'=>Category::inRandomOrder()->first()->id,
        ];
    }
}
