<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_all_products(): void
    {
        $response = $this->getjson('/api/products');

        $response->assertSuccessful();
    }

    public function test_create_a_new_product(): void
    {
        $data = [
            'name'=> fake()->name,
            'price'=> 5,
            'description'=> 'material escolar',
            'user_id' => 1,
            'category_id' => 1,
        ];

        $response = $this->postjson('/api/products', $data);

        $response->assertSuccessful();
    }

    public function test_update_product_id(): void
    {
        $product = Product::first();

        $data = [
            'name'=> fake()->name,
            'price'=> 5,
            'description'=> 'material escolar',
            'user_id' => 1,
            'category_id' => 1,
        ];

        $response = $this->putjson('/api/products/' . $product->id, $data);

        $response->assertSuccessful();
    }

    public function test_delete_product_by_id(): void
    {
        $product = Product::first();
        
        $response = $this->deletejson('/api/products/' . $product->id);

        $response->assertSuccessful();
    }
 }
