<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;

class ProductsUnitTest extends TestCase
{
    public function test_create_product(): void
    {        
        $product = Product::factory()->create();
    
        $this->assertDatabaseHas('products', ['name' => $product->name]);
        $this->assertDatabaseHas('products', ['price' => $product->price]);
        $this->assertDatabaseHas('products', ['description' => $product->description]);
        $this->assertDatabaseHas('products', ['user_id' => $product->user->id]);
        $this->assertDatabaseHas('products', ['category_id' => $product->category->id]);
        $this->assertDatabaseHas('products', ['image' => $product->image]);
    }
    public function test_update_product_name(): void
    {
        $product = Product::factory()->create();
        $newProduct = $product->refresh();
      
        $this->assertEquals($product['name'], $newProduct->name);
    }

    public function test_delete_products(): void
    {
        $product = Product::factory()->create();

        $product->delete();

        $this->assertDatabaseMissing('products', ['id'=> $product->id]);
    }
}
