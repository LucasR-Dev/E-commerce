<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Category::class;

     protected static function newFactory(): Factory
     {
        return CategoryFactory::new();
     }

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'slug' => fake()->slug()
        ];
    }
}
