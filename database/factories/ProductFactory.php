<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
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
    protected $model = Product::class;

    public function definition(): array
    {
        $user = User::all()->first() ?? User::factory()->create();
        $category = Category::all()->first() ?? Category::factory()->create();


        return [
            'name' => fake()->unique()->name(),
            'price' => fake()->randomFloat(2, 0, 1000),
            'description' => fake()->text(),
            'user_id' => $user->id,
            'category_id' => $category->id,
            'image' => fake()->imageUrl(),
        ];
    }
}