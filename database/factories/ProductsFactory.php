<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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

    //  protected static function newFactory(): Factory 
    //  {
    //     return ProductsFactory::new();
    //  }

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();

        return [
            'name' => fake()->unique()->name(),
            'price' => fake()->randomFloat(2, 0, 1000),
            'description' => fake()->text(),
            'user_id' => $user->id,
            'category_id' => $category->id,
            'image' => fake()->image(),
           


        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');

    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
