<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title' => $this->faker->sentence,
            'image' => $this->faker->imageUrl,
            'slug' => $this->faker->slug(3),
            'content' => $this->faker->paragraph,
            'category_id' => Category::factory(),
            'user_id' => User::factory()
        ];
    }
}
