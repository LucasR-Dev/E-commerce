<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Products::class;

     protected static function newFactory(): Factory 
     {
        return ProductsFactory::new();
     }

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'price' => fake()->randomFloat(2, 0, 1000),
            'description' => fake()->text(),
            'category_id' => fake()->numberBetween(1, 20),
            'image' => fake()->image(),
            'user_id' => fake()->numberBetween(1, 20),


        ];
    }
}
