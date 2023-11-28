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
            'price' => fake()->price(),
            'description' => fake()->description(),
            'category_id' =>fake()->category_id(),
            'image' => fake()->image(),
            'user_id' => fake()->user_id()


        ];
    }
}
