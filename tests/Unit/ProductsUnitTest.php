<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;

class ProductsUnitTest extends TestCase
{
    public function test_create_product(): void
    {        
        $product = Product::factory()->create();
    
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'user_id' => $product->user->id,
            'category_id' => $product->category->id,
            'image' => $product->image
        ]);
    }
    public function test_update_product_name(): void
    {
        $data = [
            'name'=> fake()->name,
            'price'=> 15
        ];

        $product = Product::factory()->create();
        $product->update($data);

        $this->assertDatabaseHas('products', $data);

    }

    public function test_delete_product(): void
    {
        $product = Product::factory()->create();

        $product->delete();

        $this->assertDatabaseMissing('products', ['id'=> $product->id]);
    }
}
