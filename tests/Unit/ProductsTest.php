<?php

namespace Tests\Unit;

use App\Models\Products;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_products(): void
    {
        $products = Products::factory()->make()->toArray();
            
        $response = $this->post('/api/products', $products);
        
        $response->assertSuccessful()->assertStatus(200);
    }
}
