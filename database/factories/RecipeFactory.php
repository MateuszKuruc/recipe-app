<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(mt_rand(2, 5));
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->text,
            'ingredients' => fake()->text,
            'instructions' => fake()->realText(800),
            'prepare_time' => fake()->randomElement([0, 5, 10, 15, 20, 25, 30]),
            'cooking_time' => fake()->randomElement([15, 30, 45, 60, 75, 90]),
            'servings' => fake()->randomElement([2, 3, 4, 6]),
//            'main_image' => fake()->imageUrl(600, 400, 'food'),
            'main_image' => 'https://placehold.co/600x400?text=Food',
//            'secondary_image' => fake()->imageUrl(600, 400, 'food'),
            'secondary_image' => 'https://placehold.co/600x400?text=FoodExtra'
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Recipe $recipe) {
            $tagIds = Tag::inRandomOrder()->take(rand(2, 3))->pluck('id');
            $recipe->tags()->attach($tagIds);
        });
    }
}
