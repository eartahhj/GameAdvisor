<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_name' => fake()->name(),
            'author_email' => fake()->safeEmail(),
            'user_id' => rand(1, 100),
            'title' => fake()->text(15),
            'text' => fake()->text(100),
            'approved' => 1,
            'rating' => rand(1, 10),
            'game_id' => rand(1, 100)
        ];
    }
}
