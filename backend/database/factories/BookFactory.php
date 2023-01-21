<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'name'        => $this->faker->name,
            'price'       => $this->faker->randomFloat(2, 50, 1000),
            'image'       => "{$this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])}.png",
            'description' => $this->faker->paragraph,
        ];
    }
}
